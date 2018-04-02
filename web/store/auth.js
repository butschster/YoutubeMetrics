export const state = () => ({
    permissions: {}
})

export const getters = {
    authenticated(state) {
        return state.loggedIn;
    },
    user(state) {
        return state.user;
    },
    permissions(state) {
        return state.permissions;
    },
}

export const mutations = {
    SET_USER_PERMISSIONS(state, permissions) {
        state.permissions = permissions
    }
}

export const actions = {
    setPermissions({commit}, permissions) {
        commit('SET_USER_PERMISSIONS', permissions);
    },

    clearPermissions({commit}) {
        commit('SET_USER_PERMISSIONS', {});
    }
}