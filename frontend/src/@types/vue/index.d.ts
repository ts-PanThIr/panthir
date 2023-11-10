import type {Raw} from "vue";
import type {AxiosStatic} from "axios";

export {}

// no libs here
export interface IConfigVars {
  $locale: string;
  $currency: string;
  $apiUrl: string;
  $http: Raw<AxiosStatic>;
  $router: Raw<Router>;
}

declare module 'vue' {
  interface ComponentCustomProperties {
    configVars: IConfigVars;
    // $translate: (key: string) => string
  }
}
