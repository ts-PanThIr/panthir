import {defineStore} from 'pinia';
import ddiList from '~/assets/data/ddi.json';
import type {Ref} from "vue";
import {inject, ref} from "vue";
import type {IConfigVars} from "~/@types/vue";

export interface IContactItem {
  type?: string;
  name: string;
  phone?: string;
  email?: string;
  ddi?: string;
  id?: string;
  delete?: boolean;
}

interface IState {
  list: Ref<IContactItem[]>;
  types: Ref<string[]>;
  ddiList: {
    name: string;
    dial_code: string;
    code: string
  }[];
}

const newContact: IContactItem = {
  name: '',
  phone: '',
  email: '',
  ddi: '',
  type: '',
};

export const useContactStore = defineStore('contact', () => {
  const configVars = inject('configVars') as IConfigVars;

  const STATE: IState = {
    ddiList: ddiList,
    list: ref([]) as Ref<IContactItem[]>,
    types: ref([]) as Ref<string[]>
  }

  const ACTIONS = {
    createNewItem(item = {...newContact}) {
      if (!item) return;
      STATE.list.value.push(item);
    },
    delete(index: number) {
      if (STATE.list.value[index].id) {
        STATE.list.value[index].delete = !STATE.list.value[index].delete;
        return;
      }
      STATE.list.value.splice(index, 1);
    },
    getTypes: async function (type: string): Promise<void> {
      const data = await configVars.$http.get(`${configVars.$apiUrl}/api/${type}/contact/types`);
      STATE.types.value.push(...data.data.data)
    }
  }

  return {...STATE, ...ACTIONS}
})
