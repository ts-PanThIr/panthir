import {defineStore} from 'pinia';
import {
  useAddressStore,
  useContactStore,
  useNotificationStore,
  type IContactItem,
  type IAddressItem,
} from '~/stores';
import {FormHelper} from '~/helpers/index';
import type {AxiosResponse} from 'axios';
import {inject, ref} from "vue";
import type {Ref} from "vue";
import type {IConfigVars} from "~/@types/vue";

interface ISupplier {
  addresses?: IAddressItem[];
  contacts?: IContactItem[];
  document?: string;
  name?: string;
  id?: string;
  additionalInformation?: string;
  secondaryDocument?: string;
  nickName?: string;
}

interface ISupplierSearch {
  limit?: number | null;
  page?: number | null;
}

interface PostReturn {
  document: string;
  name: string;
  surname?: string;
  id: string;
}

interface IState {
  list: Ref<ISupplier[]>;
  supplier: Ref<ISupplier>;
}

export const useSupplierStore = defineStore('supplier', () => {
  const configVars = inject('configVars') as IConfigVars;

  const STATE: IState = {
    list: ref([]) as Ref<ISupplier[]>,
    supplier: ref({}) as Ref<ISupplier>
  }

  const ACTIONS = {
    getAll: async function ({limit = null, page = null}: ISupplierSearch): Promise<void> {
      const params = {
        params: {
          limit,
          page
        }
      }
      STATE.list.value = await configVars.$http
        .get(`${configVars.$apiUrl}/api/supplier/`, params)
        .then((d: AxiosResponse) => {
          return d.data.data;
        });
    },

    getOne: async function (id: string): Promise<void> {
      const path = `${configVars.$apiUrl}/api/supplier/${id}`;

      const data = await configVars.$http.get(path).then(d => {
        return d.data.data;
      });
      STATE.supplier.value = {...STATE.supplier.value, ...data};
      useAddressStore().list = data.addresses;
      useContactStore().list = data.contacts;
    },

    send: async function (method: string): Promise<PostReturn> {
      if (undefined === STATE.supplier.value) {
        throw new Error('Undefined customer.')
      }
      STATE.supplier.value.addresses = useAddressStore().list;
      STATE.supplier.value.contacts = useContactStore().list;
      const formData = FormHelper.jsonToFormData(STATE.supplier.value);
      if (method == 'POST') {
        return await this.post(formData);
      }
      return await this.put(STATE.supplier.value);
    },

    put: async function (formData): Promise<PostReturn> {
      return await configVars.$http
        .put(`${configVars.$apiUrl}/api/supplier/${STATE.supplier.value.id}/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },

    post: async function (formData): Promise<PostReturn> {
      return await configVars.$http
        .post(`${configVars.$apiUrl}/api/supplier/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
  }

  return {...ACTIONS, ...STATE}
})
