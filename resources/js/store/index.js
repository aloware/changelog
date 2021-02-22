import Vuex from 'vuex';
import Vue from 'vue';
import changelog from "./modules/changelog";

Vue.use(Vuex);


export default new Vuex.store({
    modules : {
        changelog
    }
});
