<template>
    <div>
        <div class="comments" v-if="hasComments">
            <Comment
                    :comment="comment"
                    :hideAuthor="hideAuthor"
                    :canReport="canReport"
                    v-for="comment in comments"
                    :key="comment.id"
                    v-on:reported="markAsReported"></Comment>
        </div>

        <div v-else class="alert bg-white box-shadow" role="alert">
            <div class="media">
                <span class="d-flex mr-3">
                    <i class="fas fa-2x fa-info-circle"></i>
                </span>
                <span class="media-body align-self-center">
                     Комментариев пока нет :(
                </span>
            </div>
        </div>

    </div>
</template>

<script>
    import Comment from './Comment';

    export default {
        components: {Comment},
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
            }
        },
        methods: {
            markAsReported(comment) {
                this.$emit('reported', comment);
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