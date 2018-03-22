<template>
    <div class="comment mb-3" :class="classes">
        <span v-if="canReport && !isReported" class="float-right text-danger btn btn-sm btn-link" @click="report">
            <i class="fas fa-ban"></i>
        </span>

        <a class="float-right text-danger btn btn-sm btn-link" :href="youtubeLink" target="_blank">
            <i class="fab fa-youtube fa-lg"></i>
        </a>

        <a class="float-right btn btn-sm btn-link" :href="linkToComment" target="_blank">
            <i class="fas fa-link fa-fw"></i>
        </a>

        <div class="comment-content">
           <span class="badge badge-light" v-if="!hideAuthor">
                <i class="far fa-user-circle"></i>
               <a :href="linkToChannel" target="_blank">{{ comment.channel_name }}</a>
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
                    let response = await axios.post(`/api/channel/abuse`, {channel_id: this.comment.channel_id});

                    this.comment.channel_type = response.data.type;

                    this.$emit('reported', this.comment);
                } catch (e) {
                }
            }
        },
        computed: {
            youtubeLink() {
                return `https://www.youtube.com/watch?v=${this.comment.video_id}&lc=${this.comment.id}`
            },
            linkToComment() {
                return `/comment/${this.comment.id}`;
            },
            linkToChannel() {
                return `/channel/${this.comment.channel_id}`;
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