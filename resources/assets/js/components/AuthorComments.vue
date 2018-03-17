<template>
    <div>
        <loader :loading="loading" class="text-center"></loader>

        <comments :comments="comments" :total="totalComments" :hideAuthor="true"></comments>
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
                loading: false
            }
        },
        mounted() {
            this.load();
        },
        methods: {
            async load() {
                this.loading = true;
                try {
                    let response = await axios.get(`/api/author/${this.id}/comments/`);
                    this.comments = response.data.comments;
                    this.totalComments = response.data.total_comments;
                } catch (e) {

                }

                this.loading = false;
            }
        }
    }
</script>