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
                    if (c.author_id == comment.author_id) {
                        c.author_type = comment.author_type;
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