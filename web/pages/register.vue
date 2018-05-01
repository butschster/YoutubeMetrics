<template>
    <div class="container login-page-container d-flex justify-content-center">
        <div class="col-md-6 col-lg-5 align-self-center">
            <div class="login-box">
                <header class="bg-dark text-center mb-5 py-4">
                    <Logo class="logo"/>
                </header>

                <form v-on:submit.prevent="submit" class="px-5 pt-0">
                    <div class="form-group mb-4">
                        <input v-model="form.name" :class="{'is-invalid': errors.name}" type="text" class="form-control"
                               :placeholder="$t('auth.field.name')" autofocus>

                        <div class="invalid-feedback" v-if="errors.name" v-for="(error, i) in errors.name"
                             :key="`name${i}`">
                            {{ error }}
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <input v-model="form.email" :class="{'is-invalid': errors.email}" type="email"
                               class="form-control" :placeholder="$t('auth.field.email')">

                        <div class="invalid-feedback" v-if="errors.email" v-for="(error, i) in errors.email"
                             :key="`email${i}`">
                            {{ error }}
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <input v-model="form.password" :class="{'is-invalid': errors.password}" type="password"
                               class="form-control" :placeholder="$t('auth.field.password')">
                        <div class="invalid-feedback" v-if="errors.password" v-for="(error, i) in errors.password"
                             :key="`password${i}`">
                            {{ error }}
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <input v-model="form.password_confirmation" type="password" class="form-control"
                               :placeholder="$t('auth.field.password_confirmation')">
                    </div>

                    <div class="text-center mb-5">
                        <button class="btn btn-block btn-default">{{ $t('auth.button.register') }}</button>
                    </div>
                </form>

                <footer class="text-center pb-5">
                    <p class="mb-0">{{ $t('auth.text.have_account') }}
                        <nuxt-link :to="{name: 'login'}">{{ $t('auth.links.login') }}</nuxt-link>
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
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }
            }
        },
        methods: {
            async submit() {
                try {
                    await this.$userRepository.register(this.form);
                    await this.$auth.login({
                        data: this.form
                    });

                    this.$router.push({
                        path: this.$route.query.redirect || '/'
                    });

                    this.showRegistrationSuccess({
                        message: this.$t('auth.text.welcome', {name: this.form.name})
                    });
                } catch (e) {
                    this.showRegisterError({message: e.message});
                }

            }
        },
        notifications: {
            showRegisterError: {
                type: 'error'
            },
            showRegistrationSuccess: {
                type: 'success'
            }
        },
        head() {
            return {
                title: `${this.$t('auth.title.register')} - BotsMeter`,
            }
        }
    }
</script>