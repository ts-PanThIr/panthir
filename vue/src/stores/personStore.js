import { defineStore } from "pinia";
import { useAddressStore, useContactStore, useNotificationStore } from "~/stores";
import { FormHelper } from "~/helpers";

export const usePersonStore = defineStore({
  id: "person",
  state: () => ({
    list: {},
    person: {
      individual: true,
    },
    primaryAddress: 0,
    primaryContact: 0,
  }),
  actions: {
    async getAll() {
      try {
        const path = `${this.$apiUrl}/api/person`;
        const params = { individual: this.person.individual };

        this.list = await this.$http.get(path, { params }).then((d) => {
          return d.data.data;
        });
      } catch (error) {
        console.log(error);
      }
    },
    async getOne(id) {
      try {
        const params = { individual: this.person.individual };
        const path = `${this.$apiUrl}/api/person/${id}`;

        const data = await this.$http.get(path, { params }).then((d) => {
          return d.data.data;
        });
        if (this.person.individual) {
          this.person = { ...this.person, ...data.individualPerson, ...data };
        } else {
          this.person = { ...this.person, ...data };
        }
        useAddressStore().list = data.addresses;
        useContactStore().list = data.contacts;
      } catch (error) {
        console.log(error);
      }
    },
    async send() {
      try {
        this.person.addresses = useAddressStore().list;
        this.person.contacts = useContactStore().list;
        const formData = FormHelper.jsonToFormData(this.person);
        let response = await this.post(formData);
        console.log(response);
      } catch (error) {
        console.log(error);
      }
    },

    async post(formData) {
      return await this.$http
        .post(`${this.$apiUrl}/api/person/`, formData)
        .then((d) => {
          useNotificationStore().proccessReturn(d.data.notify)
          return d.data.data;
        });
    },
  },
});
