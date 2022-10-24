import {defineStore} from "pinia";
import {useAddressStore, useContactStore} from "~/stores";
import {FormHelper} from "~/helpers";

export const usePersonStore = defineStore({
    id: "person",
    state: () => ({
        person: {
            individual: true
        },
    }),
    actions: {
        async getAll(id = null) {
            try {
                let params = {};
                let path = `${this.$apiUrl}/api/person`;
                if (id) {
                    path = `${this.$apiUrl}/api/person/${id}`;
                    params = {individual: this.person.individual}
                }

                const data = await this.$http.get(path, {params}).then((d) => {
                    return d.data.data;
                });
                if (this.person.individual) {
                    this.person = {...this.person, ...data.individualPerson, ...data}
                } else {
                    this.person = {...this.person, ...data}
                }
                useAddressStore().list = data.addresses
                useContactStore().list = data.contacts
                console.log(data)

            } catch (error) {
                console.log(error)
            }
        },
        async send() {
            try {
                this.person.addresses = useAddressStore().list;
                this.person.contacts = useContactStore().list;
                const formData = FormHelper.jsonToFormData(this.person);
                let response = await this.post(formData)
                console.log(response);

            } catch (error) {
                console.log(error);
            }
        },

        async post(formData) {
            return await this.$http
                .post(`${this.$apiUrl}/api/person/`, formData)
                .then((d) => {
                    return d.data.data;
                });
        },
    },
});
