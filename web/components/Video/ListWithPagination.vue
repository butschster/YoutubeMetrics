<template>
    <div>
        <div class="row">
            <Video v-for="video in videos" :key="video.id" :video="video"/>
        </div>
        <Pagination :data="pagination" v-on:page-changed="gotoPage"></Pagination>
    </div>
</template>

<script>
    import Video from './_partials/Card';
    import Pagination from '~/components/Pagination';

    export default {
        name: 'videos',
        components: {Video, Pagination},
        data() {
            return {
                videos: [],
                pagination: {}
            }
        },

        mounted() {
            this.loadVideos(this.$route.query.page || 1);
        },

        methods: {
            async loadVideos(page = 1) {
                try {
                    [this.videos, this.pagination] = await this.$videoRepository.list({page});
                } catch (e) {

                }
            },

            gotoPage(page) {
                this.$router.replace({
                    query: {page}
                });

                this.loadVideos(page);
            }
        }
    }
</script>