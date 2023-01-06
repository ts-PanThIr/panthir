import {defineStore} from 'pinia';
export const useNotificationStore = defineStore({
  id: "notification",
  state: () => ({
    lastId: 0,
    messages: [],
  }),
  actions: {
    // time = -1 to keep open
    addMessage (text, type = 'danger', time = 5000) {
      this.lastId++
      const message = {
        text: text,
        type: type,
        time: time,
        id: this.lastId,
      }
      this.messages.unshift(message)
    },
    removeMessage (id) {
      const indexToDelete = this.messages.findIndex(n => n.id === id)
      if (indexToDelete !== -1) {
        this.messages.splice(indexToDelete, 1)
      }
    },
    proccessReturn(arr) {
      for (let r in arr) {
        this.addMessage(arr[r].text, arr[r].type)
      }
    },
  },
})