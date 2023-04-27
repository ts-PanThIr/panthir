import { customRef } from 'vue';

export const useLocalStorage = function (
  key: string,
  defaultValue: string,
): unknown {
  return customRef<string>((track, trigger) => ({
    get: (): string => {
      track();
      const value = localStorage.getItem(key);
      return value ? JSON.parse(value) : defaultValue;
    },
    set: (value): void => {
      if (value === null) {
        localStorage.removeItem(key);
      } else {
        localStorage.setItem(key, JSON.stringify(value));
      }
      trigger();
    },
  }));
};
