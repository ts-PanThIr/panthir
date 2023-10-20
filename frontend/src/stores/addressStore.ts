import {defineStore} from 'pinia';
import {computed, ref} from "vue";
import type {Ref} from "vue";

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
  const count = ref(0)

  const state: IState = {
    list: ref([]) as Ref<IAddressItem[]>,
    types: ref([]) as Ref<string[]>
  }

  const getters = {
    doubleCount: computed(() => count.value * 2)
  }

  const actions = {
    createNewItem(item = {...newAddress}): void {
      if (!item) return;
      state.list.value.push(item);
    },
    delete(index): void {
      if(state.list.value[index].id){
        state.list.value[index].delete = !state.list.value[index].delete;
        return;
      }
      state.list.value.splice(index, 1);
    },
    getTypes: async function (type: string): Promise<void> {
      const data = await this.$http.get(`${this.$apiUrl}/api/${type}/address/types`);
      state.types.value.push(...data.data.data)
    }
  }

  return {...state, ...getters, ...actions}
})
