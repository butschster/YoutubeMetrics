<template>
    <li class="mb-3">
        <div class="media p-4 channel" :class="classes">
            <div class="mr-3">
                <a :href="channel.link" target="_blank">
                    <img class="rounded-circle" width="40px" height="40px" :src="channel.thumb">
                </a>
            </div>
            <div class="media-body">

                <button class="btn btn-sm btn-danger float-right" v-if="!isReported" @click="report">
                    <i class="fas fa-ban"></i>
                </button>

                <h6>
                    <a :href="channel.link" target="_blank">{{ channel.name }}</a>
                </h6>

                <small>Дата создания: {{ channel.created_at }}</small>

                <div class="border-top media-meta pt-2 mt-2">
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
    import Comment from './Comment';

    export default {
        components: {Comment},
        props: {
            channel: {
                required: true,
                type: Object
            }
        },
        methods: {
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

            report() {
                this.$swal({
                    title: 'Вы уверены, что это спам?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Да, это спам!',
                    cancelButtonText: 'Отмена'
                }).then((result) => {
                    if (result.value) {
                        this.sendReport();
                    }
                })
            },

            async sendReport() {
                try {
                    let response = await axios.post(`/api/channel/abuse`, {channel_id: this.channel.id});
                    this.channel.type = response.data.type;

                    this.$emit('reported', this.comment);
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
            },

            classes() {
                return `channel-${this.channel.type}`;
            },
            isReported() {
                return this.channel.type != 'normal';
            }
        }
    }
</script>