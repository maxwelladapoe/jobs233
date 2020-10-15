import axios from 'axios';

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: null,
        preference: null,
        previousPage: null,

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

        previousPage(state) {
            return state.previousPage;
        },
        profileType(state) {
            if (state.preference) {
                let prefs = state.preference.split(',');
                if (prefs.length === 2 && prefs.includes('work') && prefs.includes('hire')) {
                    return 'work&hire'
                } else if (prefs.length === 1) {
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
        },
        SET_PREVIOUS_PAGE(state, value) {
            state.previousPage = value;
        }

    },

    actions: {
        async logIn({dispatch, state}, credentials) {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/auth/login', credentials);

            return dispatch('me');
        },

        async logOut({dispatch, state}) {

            await axios.put(`/auth/${state.user.id}/is_offline`);

            await axios.get(`/auth/logout`)
            return dispatch('me');


        },

        async refresh({dispatch}) {
            return dispatch('me');
        },

        setPreviousPage(previousPage) {
            commit('SET_PREVIOUS_PAGE', response.data);
        },

        me({commit, state}) {
            return axios.get('/user').then((response) => {
                commit('SET_AUTHENTICATED', true);
                commit('SET_USER', response.data);
                axios.put(`/auth/${state.user.id}/is_online`);
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
