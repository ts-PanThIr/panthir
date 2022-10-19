import { defineStore } from "pinia";
import { useAddressStore, useContactStore } from "~/stores";
import { FormHelper } from "~/helpers";

export const usePersonStore = defineStore({
  id: "person",
  state: () => ({
    person: {},
  }),
  actions: {
    async getAll(id = null) {
      try {
        let path = `${this.$apiUrl}/api/person`;
        if (id) {
          path = `${this.$apiUrl}/api/person/${id}`;
        }

        this.person = await this.$http.get(path).then((d) => {
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
