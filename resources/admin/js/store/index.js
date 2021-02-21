import Vue from 'vue';
import Vuex from 'vuex';
import adminAuth from './adminAuth';
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

export default new Vuex.Store({

    modules: {
        adminAuth
    }
})
