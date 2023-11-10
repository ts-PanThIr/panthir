import {defineStore} from 'pinia';
import {FormHelper} from '~/helpers';
import {inject, ref} from "vue";
import type {Ref} from "vue";
import type {IConfigVars} from "~/@types/vue";

export interface IUser {
  id?: string;
  email?: string;
  profile?: string;
}

interface IUserSearch {
  email?: string | null;
  profile?: string | null;
  limit?: number | null;
  page?: number | null;
}

interface IPasswordReset {
  email: string;
  password: string;
  token: string;
}

interface IState {
  user: Ref<IUser>;
  list: Ref<IUser[]>;
  profileList: Ref<string[]>;
}

export const useUsersStore = defineStore('users', () => {
  const configVars = inject('configVars') as IConfigVars;

  const STATE: IState = {
    profileList: ref([]) as Ref<string[]>,
    list: ref([]) as Ref<IUser[]>,
    user: ref({}) as Ref<IUser>,
  }

  const ACTIONS = {
    async getAll({limit = null, page = null, email = null, profile = null}: IUserSearch): Promise<void> {
      const params = {params: {limit, page, email, profile}}
      const data = await configVars.$http.get(`${configVars.$apiUrl}/api/users/`, params);
      STATE.list.value = data.data.data
    },

    async getById(id: string): Promise<void> {
      const data = await configVars.$http.get(`${configVars.$apiUrl}/api/users/${id}`);
      STATE.user.value = data.data.data
    },

    async getByClient(clientId: number): Promise<void> {
      const data = await configVars.$http.get(`${configVars.$apiUrl}/api/users/client/${clientId}`);
      STATE.list.value = data.data.data
    },

    async getByToken(token: string): Promise<void> {
      const data = await configVars.$http.get(`${configVars.$apiUrl}/api/users/token/${token}`);
      STATE.user.value = data.data.data[0]
    },

    async getProfile(): Promise<void> {
      const data = await configVars.$http.get(`${configVars.$apiUrl}/api/users/profile`);
      STATE.profileList.value = data.data.data
    },

    async resetPassword(obj: IPasswordReset): Promise<IUser> {
      const data = await configVars.$http.put(`${configVars.$apiUrl}/api/user/resetPassword`, {
        email: obj.email,
        password: obj.password,
        passwordResetToken: obj.token
      });
      return data.data.data as IUser;
    },

    async addUser(email: string, clientId: null | number = null): Promise<IUser> {
      const formData = FormHelper.jsonToFormData({
        email: email,
        client: clientId,
      });
      const data = await configVars.$http.post(`${configVars.$apiUrl}/api/user/`, formData);
      STATE.list.value.push(data.data.data as IUser)
      return data.data.data as IUser;
    },
  }
  return {...ACTIONS, ...STATE}
})
