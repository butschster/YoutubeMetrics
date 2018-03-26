<template>
    <div class="comment mb-3 border-bottom">
        <a class="float-right btn btn-sm btn-link" :href="linkToComment" target="_blank">
            <i class="fas fa-link fa-fw"></i>
        </a>

        <div class="comment-content">
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
                return `/comment/${this.comment.id}`;
            },
        }
    }
</script>