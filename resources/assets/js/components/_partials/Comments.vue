<template>
    <div>
        <div class="comments" v-if="hasComments">
            <h3 class="mb-4">Комментарии ({{ total }})</h3>

            <div class="comment mb-3 rounded" :class="classes(comment)" v-for="comment in comments">
                <button class="btn btn-sm btn-danger float-right" @click="report(comment)"
                        v-if="comment.author_type == 'normal'">Report
                </button>
                <div class="comment-content">
                    <h6 class="small comment-meta">
                        <span class="badge badge-light">
                            <i class="far fa-user-circle"></i> <a :href="`/author/${comment.author_id}`" target="_blank">{{ comment.author_id }}</a>
                        </span>

                        <small class="badge badge-light">
                            <i class="fas fa-link"></i> <a :href="`https://www.youtube.com/watch?v=${comment.video_id}&lc=${comment.id}`" target="_blank">{{ comment.id }}</a>
                        </small>
                    </h6>
                    <div class="comment-body">
                        <p>{{ comment.text }}</p>

                        <span class="badge badge-light">
                            <i class="far fa-thumbs-up"></i> {{ comment.total_likes }}
                        </span>
                        <span class="badge badge-info">{{ comment.created_at }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="alert alert-primary" role="alert">
            Комментариев нет
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            comments: {
                required: true,
                type: Array,
                default() {
                    return [];
                }
            },
            total: {
                required: true,
                type: Number,
                default: 0
            }
        },
        methods: {
            async report(comment) {
                try {
                    let response = await axios.post(`/api/channel/abuse`, {channel_id: comment.author_id});
                    comment.author_type = response.data.type;
                } catch (e) {

                }
            },
            classes(comment) {
                return `comment-${comment.author_type}`;
            }
        },
        computed: {
            hasComments() {
                return this.comments.length > 0;
            }
        }
    }
</script>

<style scoped>

</style>