import { defineStore } from 'pinia';
import { useLocalStorage } from '~/helpers/localStorage';

interface State {
  user: User | null;
  returnUrl?: string;
  list: User[];
}

interface User {
  id: string;
  token: string;
}

export const useAuthStore = defineStore('auth', {
  state: (): State => ({
    user: useLocalStorage('user', '') as User,
    returnUrl: undefined,
    list: []
  }),
  actions: {
    async login(username: string, password: string): Promise<void> {
      const data = {
        username: username,
        password: password,
      };
      // { headers: { "Content-Type": "application/json" }
      const user = await this.$http.post(
        `${this.$apiUrl}/api/login_check`,
        JSON.stringify(data),
        { headers: { 'Content-Type': 'application/json' } },
      );

      this.user = user.data;
      localStorage.setItem('user', JSON.stringify(user.data));
      this.$router.push('/');
    },
    async logout(): Promise<void> {
      this.user = null;
      localStorage.removeItem('user');
      await this.$router.push('/account/login');
    },
  },
});
