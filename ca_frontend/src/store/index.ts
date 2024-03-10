import { createStore } from 'vuex'
import auth from "@/store/modules/auth";
import VuexPersistence from 'vuex-persist'
let stores = <any> "";

stores = {
  auth
}
const vuexLocal = new VuexPersistence({
  modules: ['auth']
  })
/**
 * @desc Inject module in store
 */
//  const dataState = createPersistedState({
//   paths: ['auth','general.theme_dark']
// })
export default createStore({
    modules: stores,
    plugins:[vuexLocal.plugin],
})