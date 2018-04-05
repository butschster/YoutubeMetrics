<template>
    <div>
        <h3>{{ $t('channe.title.comments_author') }}</h3>

        <comments :comments="comments" v-on:reported="markAsReported" class="mt-4"></comments>
    </div>
</template>

<script>
    import CommentsMixin from '~/components/Comments/CommentsMixin';

    export default {
        mixins: [CommentsMixin],
        async asyncData({app, params}) {
            let comments = await app.$channelRepository.comments(params.id);

            return {comments}
        }
    }
</script>