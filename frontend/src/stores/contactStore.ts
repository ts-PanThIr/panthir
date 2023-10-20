import {defineStore} from 'pinia';
import ddiList from '~/assets/data/ddi.json';
import type {Ref} from "vue";
import {ref} from "vue";

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
  const state: IState = {
    ddiList: ddiList,
    list: ref([]) as Ref<IContactItem[]>,
    types: ref([]) as Ref<string[]>
  }

  const actions = {
    createNewItem(item = {...newContact}) {
      if (!item) return;
      state.list.value.push(item);
    },
    delete(index: number) {
      if (state.list.value[index].id) {
        state.list.value[index].delete = !state.list.value[index].delete;
        return;
      }
      state.list.value.splice(index, 1);
    },
    getTypes: async function (type: string): Promise<void> {
      const data = await this.$http.get(`${this.$apiUrl}/api/${type}/contact/types`);
      state.types.value.push(...data.data.data)
    }
  }

  return {...state, ...actions}
})
