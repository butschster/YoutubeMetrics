<template>
    <div>
        <h3>Комментарии</h3>

        <loader :loading="loading" class="text-center"></loader>

        <comments v-if="!loading" :comments="comments" :total="totalComments" :hideAuthor="true" v-on:reported="markAsReported"></comments>
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
        mounted() {
            this.load();
        },
        methods: {
            async load() {
                this.loading = true;
                try {
                    let response = await axios.get(`/api/channel/${this.id}/comments/`);
                    this.comments = response.data.comments;
                    this.totalComments = response.data.total_comments;
                } catch (e) {

                }

                this.loading = false;
            }
        }
    }
</script>