<template>
    <div>
        <h3>Комментарии</h3>

        <loader :loading="loading" class="text-center"></loader>

        <nav class="navbar navbar-expand-lg navbar-light bg-white" v-if="canReport">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" :class="{active: this.tab == 'channel'}" href="#" @click.prevent="loadAll()">Автор</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="{active: this.tab == 'spam'}" href="#" @click.prevent="loadSpam()">Боты</a>
                </li>
            </ul>
        </nav>

        <comments v-if="!loading" :comments="comments" v-on:reported="markAsReported" class="mt-4"></comments>
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
                tab: 'channel'
            }
        },
        mounted() {
            this.loadAll();
        },
        methods: {
            async loadAll() {
                this.loading = true;
                try {
                    let response = await axios.get(`/api/channel/${this.id}/comments/`);
                    this.comments = response.data.data;
                } catch (e) {

                }

                this.tab = 'channel';
                this.loading = false;
            },
            async loadSpam() {
                this.loading = true;
                try {
                    let response = await axios.get(`/api/channel/${this.id}/comments/bots`);
                    this.comments = response.data.data;
                } catch (e) {

                }

                this.tab = 'spam';
                this.loading = false;
            }
        }
    }
</script>