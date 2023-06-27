import { defineStore } from 'pinia';
import { useLocalStorage } from '~/helpers/localStorage';
import {EMessageType, useNotificationStore} from "~/stores/notificationStore";
import type {AxiosError} from "axios/index";

interface State {
  user: User | null;
  returnUrl?: string;
  list: User[];
}

interface User {
  id: string;
  token: string;
  roles: string[];
  exp: number;
  iat: number;
  username: string;
}

export const useAuthStore = defineStore('auth', {
  state: (): State => ({
    user: useLocalStorage('user', '') as User,
    returnUrl: undefined,
    list: []
  }),
  actions: {
    async login(username: string, password: string): Promise<void> {
      try {
        const data = {
          username: username,
          password: password,
        };
        // { headers: { "Content-Type": "application/json" }
        const returned = await this.$http.post(
          `${this.$apiUrl}/api/login_check`,
          JSON.stringify(data),
          { headers: { 'Content-Type': 'application/json' } },
        );
        this.user = {
          ...JSON.parse(atob(returned.data.token.split('.')[1])),
          token: returned.data.token
        } as User;

        localStorage.setItem('user', JSON.stringify(this.user));
        await this.$router.push({name: 'BOHome'});
      } catch (e) {
        const { addMessage } = useNotificationStore();
        addMessage({text: 'Invalid credentials.', type: EMessageType.Danger})
      }
    },
    async logout(): Promise<void> {
      this.user = null;
      localStorage.removeItem('user');
      await this.$router.push({name: 'login'});
    },
  },
});
