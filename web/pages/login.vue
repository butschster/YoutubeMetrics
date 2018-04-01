<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Вход</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input v-model="form.email" :class="{'is-invalid': errors.email}" type="email" class="form-control" required autofocus>

                                <div class="invalid-feedback" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">пароль</label>

                            <div class="col-md-6">
                                <input v-model="form.password" type="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" @click="submit">
                                    Вход
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
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
        }
    }
</script>