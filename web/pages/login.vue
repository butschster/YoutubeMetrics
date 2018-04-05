<template>
    <div class="container login-page-container d-flex justify-content-center">
        <div class="col-md-6 col-lg-5 align-self-center">
            <div class="login-box">
                <header class="bg-dark text-center mb-5 py-4">
                    <Logo class="logo"/>
                </header>

                <form v-on:submit.prevent="submit" class="px-5 pt-0">
                    <div class="form-group mb-4">
                        <input v-model="form.email" :class="{'is-invalid': errors.email}" type="email"
                               class="form-control" :placeholder="$t('auth.field.email')" autofocus>

                        <div class="invalid-feedback" v-if="errors.email">
                            {{ errors.email[0] }}
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <input v-model="form.password" type="password" class="form-control"
                               :placeholder="$t('auth.field.password')">
                    </div>

                    <div class="text-center mb-5">
                        <button class="btn btn-block btn-default">{{ $t('auth.button.login') }}</button>
                    </div>
                </form>

                <footer class="text-center pb-5">
                    <p class="mb-0">{{ $t('auth.text.no_account') }}
                        <nuxt-link :to="{name: 'register'}">
                            {{ $t('auth.links.register') }}
                        </nuxt-link>
                    </p>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    import Logo from '~/layouts/_partials/Logo'

    export default {
        components: {Logo},
        layout: 'login',
        middleware: 'guest',
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            async submit() {
                await this.$auth.login({
                    data: this.form
                })

                this.$router.push({
                    path: this.$route.query.redirect || '/'
                })
            }
        },
        head() {
            return {
                title: `${this.$t('auth.title.login')} - BotsMeter`,
            }
        }
    }
</script>