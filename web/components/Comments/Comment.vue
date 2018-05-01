<template>
    <div class="comment media mb-3" :class="classes">
        <img class="rounded-circle mr-3 mt-3" width="30px" :src=" comment.channel.links.thumb">

        <div class="comment-content media-body bg-white p-3 rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 v-if="!hideAuthor" class="mb-0">
                        <nuxt-link :to="linkToChannel" target="_blank">{{ comment.channel.name }}</nuxt-link>
                    </h6>
                    <span class="text-muted font-size-8">{{ comment.created_at }}</span>
                </div>

                <div>
                    <span v-if="canReport && !isReported" class="text-danger btn btn-sm btn-link" @click="report"
                          title="Отправить жалобу">
                        <i class="fas fa-ban"></i>
                    </span>

                    <a class="text-danger btn btn-sm btn-link" title="Посмотреть на youtube"
                       :href="comment.links.youtube" target="_blank">
                        <i class="fab fa-youtube fa-lg"></i>
                    </a>

                    <nuxt-link class="btn btn-sm btn-link" :to="linkToComment" title="Ссылка на комментарий"
                               target="_blank">
                        <i class="fas fa-link fa-fw"></i>
                    </nuxt-link>
                </div>
            </div>

            <div class="comment-body">
                <p>{{ comment.text }}</p>
            </div>

            <div class="comment-meta font-size-10 text-muted">
                <span >
                    <i class="far fa-thumbs-up fa-fw fa-lg"></i> {{ comment.stat.likes }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            comment: Object,

            hideAuthor: {
                type: Boolean,
                default: false
            },
            canReport: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            async report() {
                try {
                    const result = await this.$swal({
                        title: 'Вы уверены, что это спам?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Да, это спам!',
                        cancelButtonText: 'Отмена'
                    });

                    if (result.value) {
                        let response = await this.$channelRepository.report(this.comment.channel.id);
                        this.comment.channel.type = response.type;
                        this.$emit('reported', this.comment);
                    }

                } catch (e) {
                }
            }
        },
        computed: {
            linkToComment() {
                return {name: 'comment-id', params: {id: this.comment.id}}
            },
            linkToChannel() {
                return {name: 'channel-id', params: {id: this.comment.channel.id}}
            },
            classes() {
                return `comment-${this.comment.channel_type}`;
            },
            isReported() {
                return this.comment.channel_type != 'normal';
            }
        }
    }
</script>