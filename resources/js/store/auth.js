import axios from 'axios';

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: null,
        preference: null,

    },

    getters: {
        authenticated(state) {
            return state.authenticated;
        },

        user(state) {
            return state.user;
        },

        preference(state) {
            return state.preference;
        },
        profileType(state) {
            if (state.preference) {
                let prefs = state.preference.split(',');
                if (prefs.length === 2 && prefs.includes('work') && prefs.includes('hire')) {
                    return 'work&hire'
                }else if(prefs.length ===1){
                   return prefs[0]
                }
            }
        }
    },

    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value;
        },
        SET_USER(state, value) {
            state.user = value;
        },
        SET_PREFERENCE(state, value) {
            state.preference = value;
        }

    },

    actions: {
        async logIn({dispatch}, credentials) {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/auth/login', credentials);

            return dispatch('me');
        },

        async logOut({dispatch}) {
            await axios.get('/auth/logout');

            return dispatch('me')
        },

        async refresh({dispatch}){
            return dispatch('me');
        },

        me({commit}) {
            return axios.get('/user').then((response) => {
                commit('SET_AUTHENTICATED', true);
                commit('SET_USER', response.data);
                commit('SET_PREFERENCE', response.data.profile.preference);
            }).catch(() => {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', null);
            })
        },

        async signUp({dispatch}, credentials) {
            return await axios.post('/auth/register', credentials)
        }
    }

}
