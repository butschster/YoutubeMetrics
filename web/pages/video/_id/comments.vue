<template>
    <div>
        <h3>{{ $t('video.title.comments') }}</h3>

        <comments :comments="comments" v-on:reported="markAsReported" class="mt-4"></comments>
    </div>
</template>

<script>
    import CommentsMixin from '~/components/Comments/CommentsMixin';

    export default {
        mixins: [CommentsMixin],
        async asyncData({app, params}) {
            let comments = await app.$videoRepository.comments(params.id);

            return {comments}
        }
    }
</script>