import changelogApi from '../../api'
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
    project : null,
    pagination : null,

    users : [],
    user : {
        id : '',
        uuid : '',
        first_name : '',
        last_name : '',
        email : ''
    },
    auth : {
        id : '',
        uuid : '',
        first_name : '',
        last_name : '',
        email : ''
    }
}
const getters = {
    categories : (state) => state.categories,
    category : (state) => state.category,
    _beforeEditingCategoryCache : (state) => state._beforeEditingCategoryCache,
    _beforeEditingChangelogCache : (state) => state._beforeEditingChangelogCache,
    changelogs : (state) => state.changelogs,
    changelog : (state) => state.changelog,
    showChangelogEditor : (state) => state.showChangelogEditor,
    project : (state) => state.project,
    rawChangelog : (state) => state.rawChangelog,
    pagination : (state) => state.pagination,
    showCategoryEditor : (state) => state.showCategoryEditor,
    users : (state) => state.users,
    user : (state) => state.user,
    auth: (state) => state.auth

}
const actions = {
    async getChangelogs({commit}, projectUuid) {
        const response = await changelogApi.changelog.index(projectUuid);
        commit('setChangelogs', response.data);
        return response;
    },

    async getPublishedChangelogs({commit}, { projectUuid, page }) {
        let nextPage = (typeof page !== 'undefined') ? '?page=' + page : '';

        const response = await changelogApi.changelog.published(projectUuid, nextPage);

        if (!page) {
            commit('setChangelogs', response.data.data);
        } else {
            commit('appendChangelogs', response.data.data);
        }

        commit('setPaginationData', response.data);

        return response;
    },

    async storeChangelog({commit, state}, changelog) {
        changelog.category_id = changelog.category.id
        const response = await changelogApi.changelog.store(state.project.uuid, changelog);

        if (typeof response !== 'undefined' && response.status === 200) {
            commit('resetChangelog');
            commit('storeChangelog', response.data.changelog);
        }

        return response;
    },

    async updateChangelog({commit, state}, changelog) {
        changelog.category_id = changelog.category.id
        const response = await changelogApi.changelog.update(changelog.id, changelog);

        if (response.status === 200) {
            commit('resetChangelog');
            commit('updateChangelog', response.data.changelog);
        }

        return response;
    },

    async deleteChangelog({commit, state}, changelog) {
        const response = await changelogApi.changelog.delete(changelog.id);
        if (response.status === 200 && response.data.status === 'success') {
          commit('deleteChangelog', changelog);
        }

        return response;
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

    toggleChangelogEditor({commit}) {
        commit('setChangelogEditorVisibility');
    },

    setProject({commit}, project) {
        commit('setProject', project);
    },

    resetChangelog({commit}) {
        commit('resetChangelog');
    },

    async getCategories({commit}, companyId) {
        const response = await changelogApi.category.index(companyId);
        commit('setCategories', response.data);
    },

    async storeCategory({commit, state}, category) {
        const response = await changelogApi.category.store(category.company_id, category);
        if (typeof response !== 'undefined' && response.status === 200) {
            commit('resetCategoryData', state);
            commit('appendCategory', response.data.category);
        }

        return response;
    },

    async updateCategory({commit, state}, category) {
        const response = await changelogApi.category.update(category.id, category);
        if (typeof response !== 'undefined' && response.status === 200) {
            commit('resetCategoryData');
            commit('updateCategory', response.data.category);
        }

        return response;
    },

    async deleteCategory({commit, state},category ) {
        const response = await changelogApi.category.delete(category.id);

        if (response.status === 200 && response.data.status === 'success') {
            commit('deleteCategory', category);
        }

        return response;
    },

    async storeUser({commit, state}, user) {
        const response = await changelogApi.user.store(user);
        if (typeof response !== 'undefined' && response.status === 200) {
            commit('appendUser', response.data.user);
        }

        return response;
    },

    async deleteUser({commit, state}, user) {
        const response = await changelogApi.user.delete(user.id);

        if (typeof response !== 'undefined' && response.status === 200 && response.data.status === 'success') {
            commit('removeUser', user);
        }

        return response;
    },

    setAuthUser({ commit, state }, user){
        commit('setAuthUser', user)
    }
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
        if (state.categories[0]) {
            state.changelog.category = state.categories[0];
        }

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

    setChangelogEditorVisibility : (state) => (state.showChangelogEditor = !state.showChangelogEditor),
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
                state._beforeEditingCategoryCache = Object.assign({}, state.category)
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
    },

    setUsers : (state, users) => (state.users = users),
    combineUsers : (state, users) => (state.users = state.users.concat(users)),
    appendUser : function(state, user){
        state.users.push(user);
        state.user = {
            first_name : '',
            last_name : '',
            email : ''
        }
    },
    removeUser : function(state, user){
        for (let i = 0; i < state.users.length; i++) {
            if (state.users[i].id === user.id) {
                state.users.splice(i, 1);
                break;
            }
        }
    },
    setAuthUser : function(state, user){
        state.auth = user;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
