import {defineStore} from "pinia";

export const useAddressStore = defineStore({
    id: "address",
    state: () => ({
        list: [],
        primary: null
    }),
    actions: {
        createNewItem() {
            if (!item) return;
            this.items.push(item);
        },
        delete(index) {
            this.list.splice(index, 1);
        },
        add() {
            this.list.push({});
        }
    },
});
