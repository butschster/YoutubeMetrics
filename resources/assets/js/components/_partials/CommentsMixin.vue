<script>
    import Comments from './Comments';
    import Loader from 'vue-spinner/src/PacmanLoader';

    export default {
        components: {Loader, Comments},
        data() {
            return {
                comments: [],
                totalComments: 0,
                loading: false
            }
        },
        methods: {
            markAsReported(comment) {
                this.comments = _.map(this.comments, (c) => {
                    if (c.channel_id == comment.channel_id) {
                        c.channel_type = comment.channel_type;
                    }

                    return c;
                })
            }
        },
        computed: {
            canReport() {
                return this.can('channel.report');
            }
        }
    }
</script>