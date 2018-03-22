<template>
    <div>
        <h3>Комментарии</h3>

        <loader :loading="loading" class="text-center"></loader>

        <nav class="navbar navbar-expand-lg navbar-light bg-white" v-if="canReport">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" :class="{active: this.tab == 'all'}" href="#" @click="loadAll()">Все</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="{active: this.tab == 'spam'}" href="#" @click="loadSpam()">Только
                        спам</a>
                </li>
            </ul>
        </nav>

        <comments v-if="!loading" :comments="comments" :total="totalComments" v-on:reported="markAsReported"></comments>

        <div v-if="!canReport" class="alert box-shadow bg-info text-white" role="alert">
            <div class="media">
                <span class="d-flex mr-3">
                    <i class="fas fa-2x fa-info-circle"></i>
                </span>
                <span class="media-body align-self-center">
                     Просмотр всех комментариев и модерация доступны только после регистрации.
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import CommentsMixin from '../_partials/CommentsMixin';

    export default {
        props: {
            id: {
                required: true
            }
        },
        mixins: [CommentsMixin],
        data() {
            return {
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
        }
    }
</script>