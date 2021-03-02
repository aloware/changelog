import axios from "axios";
const state = {
    changelogs : [],
    categories : [],
    changelog : {
        'id' : null,
        'title' : 'Title',
        'body' : 'Content',
        'published_at' : '',
        'category' : ''
    },
    activeEditor : false,
    projectuuid : ''
}
const getters = {
    categories : (state) => state.categories,
    changelogs : (state) => state.changelogs,
    changelog : (state) => state.changelog,
    activeEditor : (state) => state.activeEditor,
    projectuuid : (state) => state.projectuuid,
    rawChangelog : (state) => state.rawChangelog,

}
const actions = {
    async getCategories({commit}, companyId) {
        const response = await axios.get("/api/company/" + companyId + "/categories");
        commit('setCategories', response.data);
    },

    async getChangelogs({commit}, projectUuid) {
        const response = await axios.get("/api/" + projectUuid + "/changelogs");
        commit('setChangelogs', response.data);
    },

    async storeChangelog({commit, state}, { vm, changelog }) {
        const response = await axios.post("/project/" + state.projectuuid + "/changelogs", changelog).catch(function(error){
            console.log(error.response)
            vm.$toastr.e("Error", Object.values(error.response.data.errors)[0][0]);
        });
        if (typeof response !== 'undefined' && response.status === 200) {
            commit('resetChangelog');
            commit('storeChangelog', response.data.changelog);
        }
    },

    async updateChangelog({commit, state}, changelog) {
        const response = await axios.put("/project/changelogs/" + changelog.id, changelog);
        console.log('here');
        if (response.status === 200) {
            commit('resetChangelog');
            commit('updateChangelog', response.data.changelog);
        } else if (response.status === 200 && response.data.status === 'error') {
            return response;
        }
    },

    async deleteChangelog({commit, state}, changelog, callback) {
      const response = await axios.delete("/project/changelogs/" + changelog.id);
      if (response.status === 200 && response.data.status === 'success') {
          commit('deleteChangelog', changelog);
      } else if (response.status === 200 && response.data.status === 'error') {
          return response;
      }
    },

    addChangelog({ commit }) {
        commit('addChangelog');
    },

    editChangelog({ commit }, changelog) {
        commit('editChangelog', changelog);
    },

    toggleEditor({commit}) {
        commit('setEditorVisibility');
    },
    setProjectUuid({commit}, projectuuid) {
        commit('setProject', projectuuid);
    },

    resetChangelog({commit}) {
        commit('resetChangelog');
    }
}

const mutations = {
    setCategories : (state, categories) => (state.categories = categories),
    setChangelogs : (state, changelogs) => (state.changelogs = changelogs),
    storeChangelog : function(state, changelog) {
        state.changelogs.push(changelog);
    },
    updateChangelog : function(state, changelog) {
        for (let i = 0; i < state.changelogs.length; i++) {
            if (state.changelogs[i].id === changelog.id) {
                state.changelogs[i] =  changelog;
            }
        }
    },
    deleteChangelog : function(state, changelog) {
        for (let i = 0; i < state.changelogs.length; i++) {
            if (state.changelogs[i].id === changelog.id) {
                state.changelogs.splice(i, 1);
            }
        }
    },
    addChangelog : function(state){
        state.activeEditor = true;
    },

    editChangelog : function(state, changelog){
        state.changelog = changelog;
        state.activeEditor = true;
    },

    setEditorVisibility : (state) => (state.activeEditor = !state.activeEditor),
    setProject : (state, projectuuid) => (state.projectuuid = projectuuid),
    removeTemporaryChangelog : function(state){
        for (let i = 0; i < state.changelogs.length; i++) {
            if (state.changelogs[i].temp === true) {
                state.changelogs.splice(i, 1);
            }
        }
    },
    resetChangelog : function(state) {
        state.activeEditor = false;
        state.changelog = {
            'id' : null,
            'title' : 'Title',
            'body' : 'Content',
            'published_at' : '',
            'category' : ''
        };
    }
}



export default {
    state,
    getters,
    actions,
    mutations
}
