import { defineStore } from "pinia";
import ddiList from "~/assets/data/ddi.json";

const newContact = {
  name: "",
  phone: "",
  email: "",
  ddi: "",
};

export const useContactStore = defineStore({
  id: "contact",
  state: () => ({
    list: [],
    primary: null, // must be the index
    ddiList: ddiList,
  }),
  actions: {
    createNewItem(item = { ...newContact }) {
      if (!item) return;
      this.list.push(item);
    },
    delete(index) {
      this.list.splice(index, 1);
    },
  },
});
