<template>
    <div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <ul class="navbar-nav ml-auto">
                <template v-if="!authenticated">

                    <li>
                        <nuxt-link class="nav-link" :to="{ name: 'login' }">Вход</nuxt-link>
                    </li>
                    <li>
                        <nuxt-link class="nav-link" :to="{ name: 'register'}">Регистрация</nuxt-link>
                    </li>

                </template>
                <template v-else>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ user.name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#" @click.prevent="logout">
                                Выход
                            </a>
                        </div>
                    </li>

                </template>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            async logout() {
                this.$auth.logout();
            }
        }
    }
</script>