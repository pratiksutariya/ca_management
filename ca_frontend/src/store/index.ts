import { createStore } from 'vuex'
import auth from "@/store/modules/auth";
import superadmin from "@/store/modules/superadmin";
import VuexPersistence from 'vuex-persist'
let stores = <any> "";

stores = {
  auth,
  superadmin
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