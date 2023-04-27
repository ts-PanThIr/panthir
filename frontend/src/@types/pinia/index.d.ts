import type { Axios } from 'axios';
import 'pinia';
import type { Router } from 'vue-router';

declare module 'pinia' {
  export interface PiniaCustomProperties {
    $router: Router;
    $http: Axios;
    $apiUrl: string;
  }
}
