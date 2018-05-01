<template>
    <li class="mb-3">
        <div class="media p-4 channel">
            <div class="mr-3">
                <nuxt-link :to="{name: 'channel-id', params: {id: channel.id}}" target="_blank">
                    <img class="rounded-circle" width="40px" height="40px" :src="channel.links.thumb">
                </nuxt-link>
            </div>

            <div class="media-body">
                <button class="btn btn-sm btn-success float-right ml-3" @click="markAsVerified()">
                    <i class="far fa-check-circle"></i> Человек
                </button>

                <button class="btn btn-danger float-right" @click="ban">
                    <i class="fas fa-ban"></i>
                </button>

                <h6>
                    <nuxt-link :to="{name: 'channel-id', params: {id: channel.id}}">{{ channel.name }}</nuxt-link>
                </h6>

                <small>Дата создания: {{ channel.created_at }}</small>

                <div class="border-top media-meta pt-2 mt-2">
                    <button class="btn btn-sm btn-link" @click="showComments()">
                        <i class="far fa-comment-alt"></i> Комментарии
                    </button>
                    <button class="btn btn-sm btn-link" @click="showReporters()">
                        <i class="fas fa-user-md"></i> Жалобы
                    </button>
                </div>
            </div>
        </div>
        <div class="media-comments border-top" v-if="hasComments">
            <div class="comments">
                <comment :comment="comment" v-for="comment in channel.comments" :key="comment.id"></comment>
            </div>
        </div>
    </li>
</template>

<script>
    import Comment from './Comment';

    export default {
        components: {Comment},
        props: {
            channel: {
                required: true,
                type: Object,
                default() {
                    return {
                        id: null,
                        name: null,
                        type: null,
                        links: {
                            thumb: null
                        },
                        policies: {
                            report: false
                        }
                    }
                }
            }
        },
        methods: {

            async showComments() {
                if (this.hasComments) {
                    this.hideComments();
                    return;
                }

                try {
                    this.channel.comments = await this.$channelRepository.comments(this.channel.id);
                } catch (e) {

                }
            },

            async ban() {
                try {
                    const result = await this.$swal({
                        title: 'Это точно бот?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Да!',
                        cancelButtonText: 'Отмена'
                    });

                    if (result.value) {
                        await this.$channelRepository.bot(this.channel.id);
                        this.$emit('bot', this.channel);
                    }
                } catch (e) {
                }
            },

            async markAsVerified() {
                try {
                    const result = await this.$swal({
                        title: 'Вы уверены, что это человек?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Да!',
                        cancelButtonText: 'Отмена'
                    });

                    if (result.value) {
                        await this.$channelRepository.verify(this.channel.id);
                        this.$emit('verified', this.channel);
                    }
                } catch (e) {
                }
            },

            hideComments() {
                this.channel.comments = [];
            }
        },
        computed: {
            hasComments() {
                return this.channel.comments.length > 0;
            }
        }
    }
</script>