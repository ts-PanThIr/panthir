import { defineStore } from "pinia";
import { useAddressStore, useContactStore } from "~/stores";
import { FormHelper } from "~/helpers";

export const usePersonStore = defineStore({
  id: "person",
  state: () => ({
    person: {},
  }),
  actions: {
    async getAll() {
      try {
        this.person = await this.$http
          .get(`${this.$apiUrl}/api/person`)
          .then((d) => {
            return d.data.data;
          });
      } catch (error) {
        this.person = { error };
      }
    },
    async send() {
      try {
        this.person.addresses = useAddressStore().list;
        this.person.contacts = useContactStore().list;
        const formData = FormHelper.jsonToFormData(this.person);

        this.person = await this.$http
          .post(`${this.$apiUrl}/api/person/`, formData)
          .then((d) => {
            return d.data.data;
          });
      } catch (error) {
        console.log(error);
      }
    },
  },
});
