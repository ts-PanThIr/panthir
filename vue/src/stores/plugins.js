let context = {}

export const piniaPlugins = {
    setContext: (param) => { context = param },
    getContext: () => { return context },

    setAxios: (param) => { context.use(() => { return { $http: param }}) },
    setApiUrl: (param) => { context.use(() => { return { $apiUrl: param} }) },
    setRouter: (param) => { context.use(() => { return { $router: param} }) },
};