import {createPinia, defineStore} from 'pinia';
import {
  useAddressStore,
  useContactStore,
  useNotificationStore,
  type IContactItem,
  type IAddressItem,
} from '~/stores';
import {FormHelper} from '~/helpers';
import type {AxiosResponse} from 'axios';
import type {Ref} from "vue";
import {ref, inject} from "vue";
import type {IConfigVars} from "~/@types/vue";
import storeReset from "~/plugins/storeReset";

interface ICustomer {
  addresses?: IAddressItem[];
  contacts?: IContactItem[];
  document?: string;
  name?: string;
  id?: number;
  additionalInformation?: string;
  secondaryDocument?: string;
  surname?: string;
  birthDate?: string;
}

interface ICustomerSearch {
  limit?: number | null;
  page?: number | null;
}

interface PostReturn {
  document: string;
  name: string;
  surname?: string;
  id: number;
}

interface IState {
  list: Ref<ICustomer[]>;
  customer: Ref<ICustomer>;
}

export const useCustomerStore = defineStore('customer', () => {
  const configVars = inject('configVars') as IConfigVars;

  const STATE: IState = {
    list: ref([]) as Ref<ICustomer[]>,
    customer: ref({}) as Ref<ICustomer>
  }

  const ACTIONS = {
    getAll: async function ({limit = null, page = null}: ICustomerSearch): Promise<void> {
      const params = {
        params: {
          limit,
          page
        }
      }
      STATE.list.value = await configVars.$http
        .get(`${configVars.$apiUrl}/api/customer/`, params)
        .then((d: AxiosResponse) => {
          return d.data.data;
        });
    },

    getOne: async function (id: number): Promise<void> {
      const path = `${configVars.$apiUrl}/api/customer/${id}`;

      const data = await configVars.$http.get(path).then(d => {
        return d.data.data;
      });
      STATE.customer.value = {...STATE.customer.value, ...data};
      useAddressStore().list = data.addresses;
      useContactStore().list = data.contacts;
    },

    send: async function (method: string): Promise<PostReturn> {
      if (undefined === STATE.customer.value) {
        throw new Error('Undefined customer.')
      }

      STATE.customer.value.addresses = useAddressStore().list;
      STATE.customer.value.contacts = useContactStore().list;
      const formData = FormHelper.jsonToFormData(STATE.customer);
      if (method == 'POST') {
        return await this.post(formData);
      }
      return await this.put();
    },

    post: async function (formData): Promise<PostReturn> {
      return await configVars.$http
        .post(`${configVars.$apiUrl}/api/customer/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
    put: async function (): Promise<PostReturn> {
      return await configVars.$http
        .put(`${configVars.$apiUrl}/api/customer/${STATE.customer.value.id}/`, STATE.customer.value)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
  }

  return {...ACTIONS, ...STATE}
})
