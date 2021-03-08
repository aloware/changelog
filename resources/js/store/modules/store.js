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
    projectuuid : '',
    project : null,
    pagination : null
}
const getters = {
    categories : (state) => state.categories,
    changelogs : (state) => state.changelogs,
    changelog : (state) => state.changelog,
    activeEditor : (state) => state.activeEditor,
    projectuuid : (state) => state.projectuuid,
    rawChangelog : (state) => state.rawChangelog,
    pagination : (state) => state.pagination,

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

    async getPublishedChangelogs({commit}, { projectUuid, page }) {
        let nextPage = (typeof page !== 'undefined') ? '?page=' + page : '';
        const response = await axios.get("/api/" + projectUuid + "/published/changelogs" + nextPage);
        if (!page) {
            commit('setChangelogs', response.data.data);
        } else {
            commit('appendChangelogs', response.data.data);
        }

        commit('setPaginationData', response.data);
    },

    async storeChangelog({commit, state}, { vm, changelog }) {
        const response = await axios.post("/project/" + state.projectuuid + "/changelogs", changelog).catch(function(error){
            vm.$toastr.e("Error", Object.values(error.response.data.errors)[0][0]);
        });
        if (typeof response !== 'undefined' && response.status === 200) {
            commit('resetChangelog');
            commit('storeChangelog', response.data.changelog);
        }
    },

    async updateChangelog({commit, state}, changelog) {
        const response = await axios.put("/project/changelogs/" + changelog.id, changelog);
        if (response.status === 200) {
            commit('resetChangelog');
            commit('updateChangelog', response.data.changelog);
        } else if (response.status === 200 && response.data.status === 'error') {
            return response;
        }
    },

    async deleteChangelog({commit, state}, changelog) {
      const response = await axios.delete("/project/changelogs/" + changelog.id);
      if (response.status === 200 && response.data.status === 'success') {
          commit('deleteChangelog', changelog);
      } else if (response.status === 200 && response.data.status === 'error') {
          return response;
      }
    },

    setInitialChangelogsData({ commit }, data) {
        commit('appendChangelogs', data.data);
        commit('setPaginationData', data);
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
        commit('setProjectUuid', projectuuid);
    },

    setProject({commit}, project) {
        commit('setProject', project);
    },

    resetChangelog({commit}) {
        commit('resetChangelog');
    }
}

const mutations = {
    setCategories : (state, categories) => (state.categories = categories),
    setChangelogs : (state, changelogs) => (state.changelogs = changelogs),
    //this is used more often on pagination
    appendChangelogs : (state, changelogs) => (state.changelogs = state.changelogs.concat(changelogs)),
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
    setProjectUuid : (state, projectuuid) => (state.projectuuid = projectuuid),
    setProject : (state, project) => (state.project = project),
    resetChangelog : function(state) {
        state.activeEditor = false;
        state.changelog = {
            'id' : null,
            'title' : 'Title',
            'body' : 'Content',
            'published_at' : '',
            'category' : '',
            'is_published' : false
        };
    },
    setPaginationData : function(state, data) {
        delete data.data;
        state.pagination = data;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
