<template>
    <li class="mb-3">
        <div class="media p-4 channel">
            <div class="mr-3">
                <a :href="channel.link" target="_blank">
                    <img class="rounded-circle" width="40px" height="40px" :src="channel.thumb">
                </a>
            </div>
            <div class="media-body">
                <button class="btn btn-sm btn-success float-right" @click="markAsVerified()">
                    <i class="far fa-check-circle"></i> Человек
                </button>

                <h6>
                    <a :href="channel.link" target="_blank">{{ channel.name }}</a>
                </h6>

                <small>Дата создания: {{ channel.created_at }}</small>

                <div class="border-top media-meta pt-2 mt-2">
                    <button class="btn btn-danger btn-sm float-right" @click="markAsBot()">
                        <i class="fas fa-ban"></i> Бот
                    </button>

                    <button class="btn btn-sm btn-link" @click="showComments()">
                        <i class="far fa-comment-alt"></i> Комментарии
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
    import Comment from '../_partials/Comment';

    export default {
        components: {Comment},
        props: {
            channel: {
                required: true,
                type: Object
            }
        },
        methods: {
            async markAsBot() {
                try {
                    await axios.post(`/api/channel/${this.channel.id}/moderate`, {status: 'bot'});
                    this.$emit('bot', this.channel);
                } catch (e) {
                }
            },

            async markAsVerified() {
                try {
                    await axios.post(`/api/channel/${this.channel.id}/moderate`, {status: 'verified'});
                    this.$emit('verified', this.channel);
                } catch (e) {
                }
            },

            async showComments() {
                if (this.hasComments) {
                    this.hideComments();
                    return;
                }

                try {
                    let response = await axios.get(`/api/channel/${this.channel.id}/comments/`);
                    this.channel.comments = response.data.data;
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