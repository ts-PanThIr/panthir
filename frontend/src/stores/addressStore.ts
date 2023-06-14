import { defineStore } from 'pinia';

export interface IAddressItem {
  name?: string;
  zip?: string;
  country?: string;
  district?: string;
  city?: string;
  address?: string;
  addressComplement?: string;
  number?: string;
}

const newAddress: IAddressItem = {
  name: '',
  zip: '',
  country: '',
  district: '',
  city: '',
  address: '',
  addressComplement: '',
  number: '',
};

interface IState {
  list: IAddressItem[];
  primary?: number; // must be the index
};

export const useAddressStore = defineStore({
  id: 'address',
  state: (): IState => ({
    list: [],
    primary: undefined, // must be the index
  }),
  actions: {
    createNewItem(item = { ...newAddress }) {
      if (!item) return;
      this.list.push(item);
    },
    delete(index) {
      this.list.splice(index, 1);
    },
  },
});
