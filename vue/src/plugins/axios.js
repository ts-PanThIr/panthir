// Add a request interceptor
import axios from "axios";
import { useAuthStore } from "~/stores";

axios.interceptors.request.use(
  function (config) {
    authHeader(config.url, config.headers.common);
    // Do something before request is sent
    return config;
  },
  function (error) {
    // Do something with request error
    return Promise.reject(error);
  }
);

axios.interceptors.response.use(
  function (response) {
    handleResponse(response);
    // Do something before request is sent
    return response;
  },
  function (error) {
    handleError(error.response);
    // Do something with request error
    return Promise.reject(error);
  }
);

function authHeader(url, headers) {
  // return auth header with jwt if user is logged in and request is to the api url
  if (url.includes("/api/login_check")) {
    return;
  }

  const { user } = useAuthStore();
  const isLoggedIn = !!user?.token;
  const isApiUrl = url.startsWith(import.meta.env.VITE_API_URL);
  if (isLoggedIn && isApiUrl) {
    headers.Authorization = `Bearer ${user.token}`;
  }
}

async function handleResponse(response) {
  const data = response.data;

  // check for error response
  if (!(response && response.status === 200 && response.statusText === "OK")) {
    const { user, logout } = useAuthStore();
    if ([401, 403].includes(response.status) && user) {
      // auto logout if 401 Unauthorized or 403 Forbidden response returned from api
      logout();
    }

    // get error message from body or default to response status
    const error = (data && data.message) || response.status;
    return Promise.reject(error);
  }

  return data;
}

async function handleError(error) {
  const { user, logout } = useAuthStore();
  if ([401, 403].includes(error.status) && user) {
    // auto logout if 401 Unauthorized or 403 Forbidden response returned from api
    logout();
    return;
  }
  return Promise.reject(error);
}
