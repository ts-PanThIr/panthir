import { defineStore } from 'pinia';

export enum EMessageType {
  Danger = 'error',
  Success = 'success',
  Warning = 'warning',
  Info = 'info',
}

export interface IMessage {
  text: string;
  type: string;
  time?: number;
  id?: number;
}

interface IState {
  lastId: number;
  messages: IMessage[];
}

export const useNotificationStore = defineStore('notification', {
  state: (): IState => ({
    lastId: 0,
    messages: [],
  }),
  actions: {
    // time = -1 to keep open
    addMessage({ text, type, time = 5000 }: IMessage): void {
      this.lastId++;
      const message = {
        text,
        type,
        time,
        id: this.lastId,
      };
      this.messages.unshift(message);
    },
    removeMessage(id: number) {
      const indexToDelete = this.messages.findIndex(n => n.id === id);
      if (indexToDelete !== -1) {
        this.messages.splice(indexToDelete, 1);
      }
    },
    processReturn(arr: IMessage[]) {
      for (const r in arr) {
        this.addMessage({ text: arr[r].text, type: arr[r].type } as IMessage);
      }
    },
  },
});
