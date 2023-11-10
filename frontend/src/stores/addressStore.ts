import {defineStore} from 'pinia';
import {inject, ref} from "vue";
import type {Ref} from "vue";
import type {IConfigVars} from "~/@types/vue";

export interface IAddressItem {
  type?: string;
  zip?: string;
  country?: string;
  district?: string;
  city?: string;
  address?: string;
  addressComplement?: string;
  number?: string;
  id?: string;
  delete?: boolean;
}

const newAddress: IAddressItem = {
  type: '',
  zip: '',
  country: '',
  district: '',
  city: '',
  address: '',
  addressComplement: '',
  number: '',
};

interface IState {
  list: Ref<IAddressItem[]>;
  types: Ref<string[]>;
}

export const useAddressStore = defineStore('address', () => {
  const configVars = inject('configVars') as IConfigVars;

  const STATE: IState = {
    list: ref([]) as Ref<IAddressItem[]>,
    types: ref([]) as Ref<string[]>
  }

  const ACTIONS = {
    createNewItem(item = {...newAddress}): void {
      if (!item) return;
      STATE.list.value.push(item);
    },
    delete(index): void {
      if (STATE.list.value[index].id) {
        STATE.list.value[index].delete = !STATE.list.value[index].delete;
        return;
      }
      STATE.list.value.splice(index, 1);
    },
    getTypes: async function (type: string): Promise<void> {
      const data = await configVars.$http.get(`${configVars.$apiUrl}/api/${type}/address/types`);
      STATE.types.value.push(...data.data.data)
    }
  }

  return {...STATE, ...ACTIONS}
})
