import {defineStore} from 'pinia';
import {useLocalStorage} from '~/helpers/localStorage';
import {EMessageType, useNotificationStore} from "~/stores/notificationStore";
import {inject, ref} from "vue";
import type {Ref} from "vue";
import type {IConfigVars} from "~/@types/vue";

interface IUser {
  id: string;
  token: string;
  roles: string[];
  exp: number;
  iat: number;
  username: string;
}

interface IState {
  user: Ref<IUser>;
  returnUrl?: Ref<string>;
  list: Ref<IUser[]>;
}

export const useAuthStore = defineStore('auth', () => {
  const configVars = inject('configVars') as IConfigVars;

  const emptyUser: IUser = {
    id: '',
    token: '',
    roles: [],
    exp: 0,
    iat: 0,
    username: ''
  }
  const STATE: IState = {
    user: ref(useLocalStorage('user', '') || emptyUser as IUser) as Ref<IUser>,
    returnUrl: ref('') as Ref<string>,
    list: ref([]) as Ref<IUser[]>
  }

  const ACTIONS = {
    login: async function (username: string, password: string): Promise<void> {
      try {
        const data = {
          username: username,
          password: password,
        };
        // { headers: { "Content-Type": "application/json" }
        const returned = await configVars.$http.post(
          `${configVars.$apiUrl}/api/login_check`,
          JSON.stringify(data),
          {headers: {'Content-Type': 'application/json'}},
        );
        STATE.user.value = {
          ...JSON.parse(atob(returned.data.token.split('.')[1])),
          token: returned.data.token
        } as IUser;

        localStorage.setItem('user', JSON.stringify(STATE.user.value));
        await configVars.$router.push({name: 'BOHome'});
      } catch (e) {
        const {addMessage} = useNotificationStore();
        addMessage({text: 'Invalid credentials.', type: EMessageType.Danger})
      }
    },
    logout: async function (): Promise<void> {
      STATE.user.value = emptyUser;
      localStorage.removeItem('user');
      await configVars.$router.push({name: 'login'});
    },
  }

  return {...STATE, ...ACTIONS}
})
