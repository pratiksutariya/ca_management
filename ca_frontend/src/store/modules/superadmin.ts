import axios from '@/plugins/apiServices';

const state = {
    
};

const mutations = {
    
};

// getters
const getters = {};
//actions
const actions = {
    async addNewCA({ commit }, data: any) {
        let resp = await axios.post('ca/add-new-ca', data);
        if (resp.data.status == true) {
            
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
