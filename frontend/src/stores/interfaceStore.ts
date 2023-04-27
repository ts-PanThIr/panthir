import { defineStore } from 'pinia';
import { useLocalStorage } from '~/helpers';

interface IState {
  menuOpen: unknown;
  pageTitle?: string;
}
export const useInterfaceStore = defineStore({
  id: 'interface',
  state: (): IState => ({
    menuOpen: useLocalStorage('menuOpen', 'false'),
    pageTitle: undefined
  }),
  actions: {
    switchMenu() {
      this.menuOpen = !this.menuOpen;
    },
  },
});
