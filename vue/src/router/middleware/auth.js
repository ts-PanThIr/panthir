export default function auth({store}){
    let isLoggedIn = false // Can be calculated through store
    // let isLoggedIn = store.getters['sessionData/isLoggedIn']
    if(!isLoggedIn){
        return { name:'login' }
    }

    return true
}