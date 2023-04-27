import { defineStore } from 'pinia';
import ddiList from '~/assets/data/ddi.json';

export interface IcontactItem {
  name: string;
  phone?: string;
  email?: string;
  ddi?: string;
}

type State = {
  list: IcontactItem[];
  primary?: number;
  ddiList: { name: string; dial_code: string; code: string }[];
};

const newContact: IcontactItem = {
  name: '',
  phone: '',
  email: '',
  ddi: '',
};

export const useContactStore = defineStore({
  id: 'contact',
  state: (): State => ({
    list: [],
    primary: undefined,
    ddiList: ddiList,
  }),
  actions: {
    createNewItem(item = { ...newContact }) {
      if (!item) return;
      this.list.push(item);
    },
    delete(index: number) {
      this.list.splice(index, 1);
    },
  },
});
