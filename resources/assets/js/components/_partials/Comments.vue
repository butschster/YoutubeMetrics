<template>
    <div>
        <div class="comments" v-if="hasComments">
            <h3 class="mb-4">Комментарии <small class="text-muted">({{ total }})</small></h3>

            <div class="comment mb-3 rounded" :class="classes(comment)" v-for="comment in comments">
                <a class="float-right text-danger btn btn-sm btn-link" :href="`https://www.youtube.com/watch?v=${comment.video_id}&lc=${comment.id}`" target="_blank">
                    <i class="fab fa-youtube fa-lg"></i>
                </a>

                <a class="float-right btn btn-sm btn-link" :href="`/comment/${comment.id}`" target="_blank">
                    <i class="fas fa-link fa-fw"></i>
                </a>

                <div class="comment-content">
                   <span class="badge badge-light" v-if="!hideAuthor">
                        <i class="far fa-user-circle"></i> <a :href="`/author/${comment.author_id}`" target="_blank">{{ comment.author_name }}</a>
                    </span>
                    <div class="comment-body">
                        <p>{{ comment.text }}</p>
                    </div>

                    <div class="comment-meta">
                        <span class="badge badge-light">
                            <i class="far fa-thumbs-up fa-fw fa-lg"></i> {{ comment.total_likes }}
                        </span>
                        <span class="badge badge-light">{{ comment.created_at }}</span>
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
            hideAuthor: {
                type: Boolean,
                default: false
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