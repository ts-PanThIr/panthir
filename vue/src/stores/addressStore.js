import {defineStore} from "pinia";


export const useAddressStore = defineStore({
    id: "address",
    state: () => ({}),
    actions: {
        createNewItem() {
            if (!item) return;
            this.items.push(item);
        },
    },
});
