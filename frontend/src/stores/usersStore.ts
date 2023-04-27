import { defineStore } from 'pinia';
import { FormHelper } from '~/helpers';

type TState = {
  profileList: string[];
  list: IUser[];
  user: IUser;
};

export interface IUser {
  id?: string;
  email?: string;
  profile?: string;
};

export const useUsersStore = defineStore('users', {
  state: (): TState => ({
    profileList: [],
    list: [],
    user: {},
  }),
  actions: {
    async getAll(): Promise<void> {
      this.list = await this.$http
        .get(`${this.$apiUrl}/api/users`)
        .then((d) => {
          return d.data.data;
        });
    },

    async getById(id: string): Promise<void> {
      const data = await this.$http.get(`${this.$apiUrl}/api/users/${id}`);
      this.user = data.data.data
    },

    async getByClient(clientId: number): Promise<void> {
      const data = await this.$http.get(`${this.$apiUrl}/api/users/client/${clientId}`);
      this.list = data.data.data
    },

    async getByToken(token: string): Promise<void> {
      const data = await this.$http.get(`${this.$apiUrl}/api/users/token/${token}`);
      console.log(data)
    },

    async getProfile(): Promise<void> {
      const data = await this.$http.get(`${this.$apiUrl}/api/users/profile`);
      this.profileList = data.data.data
    },

    async addUser (email: string, clientId: null | number = null): Promise<void> {
      const formData = FormHelper.jsonToFormData({
        email: email,
        client: clientId,
      });
      const data = await this.$http.post(`${this.$apiUrl}/api/user/`, formData);
      this.list.push(data.data.data as IUser)
    },
  },
});
