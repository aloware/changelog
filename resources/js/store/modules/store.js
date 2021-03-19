import axios from "axios";
const state = {
    changelogs : [],
    categories : [],
    changelog : {
        'id' : null,
        'title' : '',
        'body' : '',
        'published_at' : '',
        'category' : ''
    },
    _beforeEditingChangelogCache : null,
    category : {
        label : '',
        bg_color : '#007bff',
        text_color : '#fff',
    },
    _beforeEditingCategoryCache : null,
    showChangelogEditor : false,
    showCategoryEditor : false,
    projectuuid : '',
    project : null,
    pagination : null
}
const getters = {
    categories : (state) => state.categories,
    category : (state) => state.category,
    _beforeEditingCategoryCache : (state) => state._beforeEditingCategoryCache,
    _beforeEditingChangelogCache : (state) => state._beforeEditingChangelogCache,
    changelogs : (state) => state.changelogs,
    changelog : (state) => state.changelog,
    showChangelogEditor : (state) => state.showChangelogEditor,
    projectuuid : (state) => state.projectuuid,
    project : (state) => state.project,
    rawChangelog : (state) => state.rawChangelog,
    pagination : (state) => state.pagination,
    showCategoryEditor : (state) => state.showCategoryEditor,

}
const actions = {
    async getCategories({commit}, companyId) {
        const response = await axios.get("/api/company/" + companyId + "/categories");
        commit('setCategories', response.data);
    },

    async getChangelogs({commit}, projectUuid) {
        const response = await axios.get("/api/" + projectUuid + "/changelogs");
        commit('setChangelogs', response.data);

        return response;
    },

    async getPublishedChangelogs({commit}, { vm,  projectUuid, page }) {
        let nextPage = (typeof page !== 'undefined') ? '?page=' + page : '';
        const response = await axios.get("/api/" + projectUuid + "/published/changelogs" + nextPage);
        vm.loading = false
        if (!page) {
            commit('setChangelogs', response.data.data);
        } else {
            commit('appendChangelogs', response.data.data);
        }

        commit('setPaginationData', response.data);
    },

    async storeChangelog({commit, state}, changelog) {
        changelog.category_id = changelog.category.id
        const response = await axios.post("/project/" + state.project.uuid + "/changelogs", changelog);
        if (typeof response !== 'undefined' && response.status === 200) {
            commit('resetChangelog');
            commit('storeChangelog', response.data.changelog);
        } else if (response.status === 200 && response.data.status === 'error') {
            return response;
        }
    },

    async updateChangelog({commit, state}, changelog) {
        changelog.category_id = changelog.category.id
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
    },

    async storeCategory({commit, state}, category) {
        const response = await axios.post("/company/"+ category.company_id +"/category", category);
        if (typeof response !== 'undefined' && response.status === 200) {
            commit('resetCategoryData');
            commit('appendCategory', response.data.category);
        }

        return response;
    },

    async updateCategory({commit, state}, category) {
        const response = await axios.put("/company/category/" + category.id, category);
        if (typeof response !== 'undefined' && response.status === 200) {
            commit('resetCategoryData');
            commit('updateCategory', response.data.category);
        }

        return response;
    },

    async deleteCategory({commit, state}, { vm, category }) {
        const response = await axios.delete("/company/category/" + category.id);
        if (response.status === 200 && response.data.status === 'success') {
            commit('deleteCategory', category);
            vm.deletionInProgress = !1;
        } else if (response.status === 200 && response.data.status === 'error') {
            vm.$toastr.e("Error", response.data.message);
            vm.deletionInProgress = !1;
        }
    },
}

const mutations = {
    setCategories : (state, categories) => {
        state.categories = categories
    },
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
                break;
            }
        }
    },
    deleteChangelog : function(state, changelog) {
        for (let i = 0; i < state.changelogs.length; i++) {
            if (state.changelogs[i].id === changelog.id) {
                state.changelogs.splice(i, 1);
                break;
            }
        }
    },

    addChangelog : function(state){
        state.showChangelogEditor = true;
    },
    editChangelog : function(state, changelog){
        state.changelog = changelog;
        for (let i = 0; i < state.changelogs.length; i++) {
            if (state.changelogs[i].id === changelog.id) {
                state.changelog = state.changelogs[i]
                state._beforeEditingChangelogCache = Object.assign({}, state.changelogs[i])
                break
            }
        }


        state.showChangelogEditor = !0;
    },

    setEditorVisibility : (state) => (state.showChangelogEditor = !state.showChangelogEditor),
    setProjectUuid : (state, projectuuid) => (state.projectuuid = projectuuid),
    setProject : (state, project) => (state.project = project),
    resetChangelog : function(state) {
        state.showChangelogEditor = false;
        state.changelog = {
            'id' : null,
            'title' : '',
            'body' : '',
            'published_at' : '',
            'category' : '',
            'is_published' : false
        };

        if (state._beforeEditingChangelogCache) {
            for (let i = 0; i < state.changelogs.length; i++) {
                if (state.changelogs[i].id === state._beforeEditingChangelogCache.id) {
                    Object.assign(state.changelogs[i], state._beforeEditingChangelogCache);
                    state._beforeEditingChangelogCache = null
                    break
                }
            }
        }
    },
    setPaginationData : function(state, data) {
        delete data.data;
        state.pagination = data;
    },

    appendCategory : function(state, category) {
        state.categories.push(category)
    },

    updateCategory : function(state, category){
        for (let i = 0; i < state.categories.length; i++) {
            if (state.categories[i].id === category.id) {
                state.categories[i] =  category;
                break;
            }
        }
    },

    addCategory :  function(state) {
        state.category = {
            label : '',
            bg_color : '#007bff',
            text_color : '#fff',
        }
    },

    editCategory : function (state, category) {
        for (let i = 0; i < state.categories.length; i++) {
            if (state.categories[i].id === category.id) {
                state.category = state.categories[i]
                state._beforeEditingCategoryCache = Object.assign({}, state.categories[i])
                break
            }
        }
    },

    deleteCategory : function(state, category) {
        for (let i = 0; i < state.categories.length; i++) {
            if (state.categories[i].id === category.id) {
                state.categories.splice(i, 1);
                break;
            }
        }
    },

    toggleCategoryEditor : (state) => (state.showCategoryEditor = !state.showCategoryEditor),
    cancelCategoryForm : (state) => {
        state.category = {
            label : '',
            bg_color : '#007bff',
            text_color : '#fff',
        };
        state.showCategoryEditor = !state.showCategoryEditor
        if (state._beforeEditingCategoryCache) {
            for (let i = 0; i < state.categories.length; i++) {
                if (state.categories[i].id === state._beforeEditingCategoryCache.id) {
                    Object.assign(state.categories[i], state._beforeEditingCategoryCache);
                    state._beforeEditingCategoryCache = null
                    break
                }
            }
        }
    },
    resetCategoryData : function(state){
        state.category = state._beforeEditingCategoryCache = {
            label : '',
            bg_color : '#007bff',
            text_color : '#fff',
        };
        state.showCategoryEditor = !1
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
