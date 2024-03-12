import axios from '@/plugins/apiServices';

const state = {
    authenticated: false,
    user: '',
    idToken: '',
    role:''
};

const mutations = {
    SET_AUTHENTICATED(state : any, value : any) {
        state.authenticated = value;
    },
    SET_USER(state : any, value : any) {
        state.user = value;
    },
    SET_ID_TOKEN(state : any, value : any) {
        state.idToken = value;
    },
    SET_ROLE(state : any, value : any) {
      state.role = value;
  }
};

// getters
const getters = {};
//actions
const actions = {
    async login({ commit }, data: any) {
        let resp = await axios.post('login', data);
        if (resp.data.status == true) {
            commit('SET_USER', resp.data.data);
            commit('SET_ID_TOKEN', resp.data.data?.access_token);
            commit('SET_AUTHENTICATED', true);
            commit('SET_ROLE', resp.data.data?.role);
        }
        return resp;
    },
    async logout({ commit }, data: any) {
        let resp = await axios.get('user/logout', data);
        if (resp.data.status == true) {
            commit('SET_USER', "");
            commit('SET_ID_TOKEN', "");
            commit('SET_AUTHENTICATED', false);
            commit('SET_ROLE', "");
        }
        return resp;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
