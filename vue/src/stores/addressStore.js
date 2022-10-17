import { defineStore } from "pinia";

const newAddress = {
  name: "",
  zip: "",
  country: "",
  district: "",
  city: "",
  address: "",
  complement: "",
  number: "",
};

export const useAddressStore = defineStore({
  id: "address",
  state: () => ({
    list: [],
    primary: null, // must be the index
  }),
  actions: {
    createNewItem(item = { ...newAddress }) {
      if (!item) return;
      this.list.push(item);
    },
    delete(index) {
      this.list.splice(index, 1);
    },
  },
});
