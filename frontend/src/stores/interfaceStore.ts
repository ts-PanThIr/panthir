import {defineStore} from 'pinia';
import {useLocalStorage} from '~/helpers';
import {ref} from "vue";
import type {Ref} from "vue";


interface IState {
  menuOpen: Ref<boolean>;
  pageTitle: Ref<string>;
}

export const useInterfaceStore = defineStore('interface', () => {
  const STATE: IState = {
    menuOpen: ref(useLocalStorage('menuOpen', 'false')) as Ref<boolean>,
    pageTitle: ref('') as Ref<string>
  }

  const ACTIONS = {
    switchMenu: function () {
      STATE.menuOpen.value = !STATE.menuOpen.value;
    },
  }

  return {...STATE, ...ACTIONS}
})


