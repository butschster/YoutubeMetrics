<template>
    <div>
        <div class="comments" v-if="hasComments">
            <h3 class="mb-4">Комментарии</h3>

            <div class="comment mb-3 rounded" :class="classes(comment)" v-for="comment in comments">
                <span class="float-right text-danger btn btn-sm btn-link" @click="report(comment)">
                    <i class="fas fa-ban"></i>
                </span>

                <a class="float-right text-danger btn btn-sm btn-link"
                   :href="`https://www.youtube.com/watch?v=${comment.video_id}&lc=${comment.id}`" target="_blank">
                    <i class="fab fa-youtube fa-lg"></i>
                </a>

                <a class="float-right btn btn-sm btn-link" :href="`/comment/${comment.id}`" target="_blank">
                    <i class="fas fa-link fa-fw"></i>
                </a>

                <div class="comment-content">
                   <span class="badge badge-light" v-if="!hideAuthor">
                        <i class="far fa-user-circle"></i> <a :href="`/channel/${comment.author_id}`" target="_blank">{{ comment.author_name }}</a>
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

        <div v-else class="alert border bg-white" role="alert">
            <div class="media">
                <span class="d-flex mr-3">
                    <i class="fas fa-2x fa-info-circle"></i>
                </span>
                <span class="media-body align-self-center">
                     Комментариев пока нет.
                </span>
            </div>
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
            report(comment) {
                this.$swal({
                    title: 'Вы уверены, что это спам?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Да, это спам!',
                    cancelButtonText: 'Отмена'
                }).then((result) => {
                    if (result.value) {
                        this.sendReport(comment);
                    }
                })
            },
            async sendReport(comment) {
                try {
                    let response = await axios.post(`/api/channel/abuse`, {channel_id: comment.author_id});
                    comment.author_type = response.data.type;

                    this.comments.each((c) => {
                        if (c.author_id == comment.author_id) {
                            c.author_type = comment.author_type
                        }
                    })
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
            },
            canReport() {
                return this.can('channel.report');
            }
        }
    }
</script>

<style scoped>

</style>