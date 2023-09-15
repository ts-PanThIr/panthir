import {defineStore} from 'pinia';
import {
  useAddressStore,
  useContactStore,
  useNotificationStore,
  type IcontactItem,
  type IAddressItem,
} from '~/stores';
import {FormHelper} from '~/helpers/index';
import type {AxiosResponse} from 'axios';

interface ISupplier {
  addresses?: IAddressItem[];
  contacts?: IcontactItem[];
  document?: string;
  name?: string;
  id?: number;
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
  id: number;
}

interface IState {
  list: ISupplier[];
  supplier: ISupplier;
}

export const useSupplierStore = defineStore({
  id: 'supplier',
  state: (): IState => ({
    list: [],
    supplier: {}
  }),
  actions: {
    async getAll({limit = null, page = null}: ISupplierSearch): Promise<void> {
      const params = {
        params: {
          limit,
          page
        }
      }
      this.list = await this.$http
        .get(`${this.$apiUrl}/api/supplier/`, params)
        .then((d: AxiosResponse) => {
          return d.data.data;
        });
    },

    async getOne(id: number): Promise<void> {
      const path = `${this.$apiUrl}/api/supplier/${id}`;

      const data = await this.$http.get(path).then(d => {
        return d.data.data;
      });
      this.supplier = {...this.supplier, ...data};
      useAddressStore().list = data.addresses;
      useContactStore().list = data.contacts;
    },

    async send(method: string): Promise<PostReturn> {
      if (undefined === this.supplier) {
        throw new Error('Undefined customer.')
      }
      this.supplier.addresses = useAddressStore().list;
      this.supplier.contacts = useContactStore().list;
      const formData = FormHelper.jsonToFormData(this.supplier);
      if (method == 'POST') {
        return await this.post(formData);
      }
      return await this.put(formData);
    },

    async put(formData): Promise<PostReturn> {
      return await this.$http
        .post(`${this.$apiUrl}/api/supplier/${this.supplier.id}/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
    
    async post(formData): Promise<PostReturn> {
      return await this.$http
        .post(`${this.$apiUrl}/api/supplier/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
  },
});
