import {defineStore} from 'pinia';
import {
  useAddressStore,
  useContactStore,
  useNotificationStore,
  type IcontactItem,
  type IAddressItem,
} from '~/stores';
import {FormHelper} from '~/helpers';
import type {AxiosResponse} from 'axios';

interface ICustomer {
  addresses?: IAddressItem[];
  contacts?: IcontactItem[];
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

type TState = {
  list: ICustomer[];
  customer: ICustomer;
}

export const useCustomerStore = defineStore({
  id: 'customer',
  state: (): TState => ({
    list: [],
    customer: {}
  }),
  actions: {
    async getAll({limit = null, page = null}: ICustomerSearch): Promise<void> {
      const params = {
        params: {
          limit,
          page
        }
      }
      this.list = await this.$http
        .get(`${this.$apiUrl}/api/customer/`, params)
        .then((d: AxiosResponse) => {
          return d.data.data;
        });
    },

    async getOne(id: number): Promise<void> {
      const path = `${this.$apiUrl}/api/customer/${id}`;

      const data = await this.$http.get(path).then(d => {
        return d.data.data;
      });
      this.customer = {...this.customer, ...data};
      useAddressStore().list = data.addresses;
      useContactStore().list = data.contacts;
    },

    async send(): Promise<PostReturn> {
      if (undefined === this.customer) {
        throw new Error('Undefined customer.')
      }

      this.customer.addresses = useAddressStore().list;
      this.customer.contacts = useContactStore().list;
      const formData = FormHelper.jsonToFormData(this.customer);
      return await this.post(formData);
    },

    async post(formData): Promise<PostReturn> {
      return await this.$http
        .post(`${this.$apiUrl}/api/customer/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
  },
});
