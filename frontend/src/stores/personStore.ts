import { defineStore } from 'pinia';
import {
  useAddressStore,
  useContactStore,
  useNotificationStore,
  type IcontactItem,
  type IAddressItem,
} from '~/stores';
import { FormHelper } from '~/helpers/index';
import type { AxiosResponse } from 'axios';

interface IPerson {
  addresses?: IAddressItem[];
  contacts?: IcontactItem[];
  individual: boolean;
  active?: boolean;
  name?: string;
  surname?: string;
  id?: number;
}

interface IState {
  list: IAddressItem[];
  person: IPerson;
  primaryAddress?: number; // must be the index~
  primaryContact?: number;
}

export const usePersonStore = defineStore({
  id: 'person',
  state: ():IState => ({
    list: [],
    person: {
      individual: true,
    },
    primaryAddress: undefined,
    primaryContact: undefined,
  }),
  actions: {
    async getAll(): Promise<void> {
      const path = `${this.$apiUrl}/api/person`;
      const params = { individual: this.person.individual };

      this.list = await this.$http
        .get(path, { params })
        .then((d: AxiosResponse) => {
          return d.data.data;
        });
    },

    async getOne(id: number): Promise<void> {
      const params = { individual: this.person.individual };
      const path = `${this.$apiUrl}/api/person/${id}`;

      const data = await this.$http.get(path, { params }).then(d => {
        return d.data.data;
      });
      this.person = { ...this.person, ...data };
      useAddressStore().list = data.addresses;
      useContactStore().list = data.contacts;
    },

    async send(): Promise<void> {
      this.person.addresses = useAddressStore().list;
      this.person.contacts = useContactStore().list;
      const formData = FormHelper.jsonToFormData(this.person);
      const response = await this.post(formData);
    },

    async sendClient(): Promise<void> {
      const formData = FormHelper.jsonToFormData(this.person);
      const data = await this.postClient(formData);
      console.log(data);
    },

    async post(formData): Promise<void> {
      const data = await this.$http
        .post(`${this.$apiUrl}/api/person/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
        console.log(data)
    },

    async postClient(formData): Promise<void> {
      return await this.$http
        .post(`${this.$apiUrl}/api/client/`, formData)
        .then(d => {
          useNotificationStore().processReturn(d.data.notify);
          return d.data.data;
        });
    },
  },
});
