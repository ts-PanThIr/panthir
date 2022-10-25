import { defineStore } from "pinia";

export const useInterfaceStore = defineStore({
  id: "interface",
  state: () => ({
    menuOpen: true,
  }),
  actions: {
    switchMenu() {
      this.menuOpen = !this.menuOpen;
    },
  },
});
