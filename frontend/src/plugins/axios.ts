import type {
  AxiosError,
  AxiosInstance,
  AxiosResponse,
  InternalAxiosRequestConfig,
} from 'axios';
import {
  EMessageType,
  useAuthStore,
  useNotificationStore,
  type IMessage,
} from '~/stores';

const onRequest = (
  config: InternalAxiosRequestConfig,
): InternalAxiosRequestConfig => {
  if (
    config.headers === undefined ||
    config.url === undefined ||
    config.url.includes('/api/login_check')
  ) {
    return config;
  }

  const { user } = useAuthStore();
  const isLoggedIn = !!user?.token;
  const isApiUrl = config.url.startsWith(import.meta.env.VITE_API_URL);
  if (isLoggedIn && isApiUrl) {
    config.headers.Authorization = `Bearer ${user.token}`;
  }
  return config;
};

const onRequestError = (error: AxiosError): Promise<AxiosError> => {
  return Promise.reject(error);
};

const onResponse = async (response: AxiosResponse): Promise<AxiosResponse> => {
  if (!(response && response.status === 200 && response.statusText === 'OK')) {
    const { user, logout } = useAuthStore();
    if ([401, 403].includes(response.status) && user) {
      // auto logout if 401 Unauthorized or 403 Forbidden response returned from api
      await logout();
    }

    // get error message from body or default to response status
    const error = (response.data && response.data.message) || response.status;
    throw new Error(error);
  }

  if (response.data.notify && response.data.notify.length > 0) {
    const { processReturn } = useNotificationStore();
    processReturn(response.data.notify as IMessage[]);
  }

  return response;
};

const onResponseError = async (error: AxiosError): Promise<AxiosError> => {
  const { logout } = useAuthStore();
  const { addMessage } = useNotificationStore();
  if (error.response === undefined) {
    addMessage({ text: 'API Connection Error.', type: EMessageType.Danger });
    return Promise.reject(error);
  }
  if (error.response.status === 500) {
    addMessage({ text: 'Error in the API.', type: EMessageType.Danger });
    return Promise.reject(error);
  }
  if ([401, 403].includes(error.response.status)) {
    // auto logout if 401 Unauthorized or 403 Forbidden response returned from api
    await logout();
  }
  return Promise.reject(error);
};

export function setupInterceptorsTo(
  axiosInstance: AxiosInstance,
): AxiosInstance {
  axiosInstance.interceptors.request.use(onRequest, onRequestError);
  axiosInstance.interceptors.response.use(onResponse, onResponseError);
  return axiosInstance;
}
