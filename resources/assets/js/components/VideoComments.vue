<template>
    <div>
        <loader :loading="loading" class="text-center"></loader>

        <h3>Комментарии</h3>
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" :class="{active: this.tab == 'all'}" href="#" @click="loadAll()">Все</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="{active: this.tab == 'spam'}" href="#" @click="loadSpam()">Только спам</a>
                </li>
            </ul>
        </nav>

        <comments v-if="!loading" :comments="comments" :total="totalComments"></comments>
    </div>
</template>

<script>
    import Comments from './_partials/Comments';
    import Loader from 'vue-spinner/src/PacmanLoader';

    export default {
        props: {
            id: {
                required: true
            }
        },
        components: {Loader, Comments},
        data() {
            return {
                comments: [],
                totalComments: 0,
                loading: false,
                tab: 'spam'
            }
        },
        mounted() {
            this.loadSpam();
        },
        methods: {
            async loadAll() {
                this.loading = true;
                try {
                    let response = await axios.get(`/api/video/${this.id}/comments/`);
                    this.comments = response.data.comments;
                    this.totalComments = response.data.total_comments;
                } catch (e) {

                }

                this.tab = 'all';
                this.loading = false;
            },
            async loadSpam() {
                this.loading = true;
                try {
                    let response = await axios.get(`/api/video/${this.id}/comments/spam`);
                    this.comments = response.data.comments;
                    this.totalComments = response.data.total_comments;
                } catch (e) {

                }

                this.tab = 'spam';
                this.loading = false;
            }
        },
        computed: {
            canReport() {
                return this.can('channel.report');
            }
        }
    }
</script>