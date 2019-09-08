import JwtService from "../common/jwt.service";

const types = {
    LOGIN: 'LOGIN',
    LOGOUT: 'LOGOUT'
}

const state = {
    logged: !!window.localStorage.getItem('token')
}

const mutations = {
    [types.LOGIN](state) {
        state.logged = true
    },

    [types.LOGOUT](state) {
        state.logged = false
    }
}

const getters = {
    isLogged: state => state.logged
}

const actions = {
    login({commit}, response) {
        let data = response.data;
        JwtService.saveToken(data.access_token);
        JwtService.saveUser(data.user);
    },

    logout({commit}) {
        JwtService.destroyToken();
        JwtService.destroyUser();
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
