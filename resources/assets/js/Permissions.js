export default class Permissions {
    constructor(user, permissions) {
        this.user = user;
        this.permissions = permissions;
    }

    before() {

    }

    has(action) {
        if (this.before()) {
            return true;
        }

        return _.get(this.permissions, action) === true;
    }
}