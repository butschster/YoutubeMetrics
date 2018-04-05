export default async function ({app, store}) {
    async function loadPermissions() {
        const permissions = await app.$userRepository.permissions();
        store.dispatch('auth/setPermissions', permissions);
    }

    app.$auth.$storage.watchState('loggedIn', async (state) => {
        if (state) {
            await loadPermissions();
        } else {
            store.dispatch('auth/clearPermissions');
            // почему то при logout не удаляется токен из axios
            // поэтому удаляем его вручную, иначе перестает работает авторизация
            delete app.$axios.defaults.headers.common.Authorization;
        }
    });

    if (app.$auth.$storage.getState('loggedIn')) {
        await loadPermissions();
    }
}