export { }

// no libs here
export interface IConfigVars {
  $locale: string;
  $currency: string;
  $apiUrl: string;
}

declare module 'vue' {
  interface ComponentCustomProperties {
    configVars: IConfigVars;
    // $translate: (key: string) => string
  }
}
