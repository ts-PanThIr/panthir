// Add a request interceptor
import axios from "axios";

axios.interceptors.request.use(
  function (config) {
    console.log("teste");
    // Do something before request is sent
    return config;
  },
  function (error) {
    // Do something with request error
    return Promise.reject(error);
  }
);
