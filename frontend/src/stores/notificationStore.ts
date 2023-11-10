import {defineStore} from 'pinia';
import {ref} from "vue";
import type {Ref} from "vue";

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
  lastId: Ref<number>;
  messages: Ref<IMessage[]>;
}

export const useNotificationStore = defineStore('notification', () => {
  const STATE: IState = {
    lastId: ref(0) as Ref<number>,
    messages: ref([]) as Ref<IMessage[]>
  }

  const ACTIONS = {
    addMessage: function ({text, type, time = 5000}: IMessage): void {
      STATE.lastId.value++;
      const message = {
        text,
        type,
        time,
        id: STATE.lastId.value,
      };
      STATE.messages.value.unshift(message);
    },
    removeMessage: function (id: number) {
      const indexToDelete = STATE.messages.value.findIndex(n => n.id === id);
      if (indexToDelete !== -1) {
        STATE.messages.value.splice(indexToDelete, 1);
      }
    },
    processReturn: function (arr: IMessage[]) {
      for (const r in arr) {
        this.addMessage({text: arr[r].text, type: arr[r].type} as IMessage);
      }
    },
  }

  return {...STATE, ...ACTIONS}
})
