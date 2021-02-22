import axios from "axios";

const state = {
    changelogs : [],
}
const getters = {
    changelogs : (state) => state.changelogs
}
const actions = {
    async getChangelogs({ commit }) {
        const response = await axios.get('route-get-all-changelogs');
        commit('call-mutations', response.data);
    },

    async createChangelog({ commit }, changelog) {
        const response = await axios.post('route-to-post-changelogs', changelog);
        commit('createChangelog', response.data);
    },
}
const mutations = {
    setChangelogs : (state, changelogs) => (state.changelogs = changelogs),
    createChangelog : function(state, changelog) {
        state.changelogs.push(changelog);
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
