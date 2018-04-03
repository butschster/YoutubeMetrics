<template>
    <div class="comment p-3 mb-3 border-bottom">
        <a class="float-right btn btn-sm btn-link" :href="linkToComment" target="_blank">
            <i class="fas fa-link fa-fw"></i>
        </a>

        <div class="comment-content">
            <div class="comment-body">
                <p>{{ comment.text }}</p>
            </div>

            <div class="comment-meta">
                <span class="badge badge-light">
                    <i class="far fa-thumbs-up fa-fw fa-lg"></i> {{ comment.stat.likes }}
                </span>
                <span class="badge badge-light">{{ comment.created_at }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            comment: {
                type: Object,
                required: true
            }
        },
        computed: {
            linkToComment() {
                return {name: 'comment-id', params: {id: this.comment.id}}
            },
        }
    }
</script>