<template>
    <section class="container">
        <div class="bg-white box-shadow p-4 mt-5">
            <div class="d-flex justify-content-between">
                <nuxt-link :to="{ name: 'channel-id', params: {id: this.video.channel.id } }">
                    <img :src="video.channel.links.thumb" class="rounded-circle mr-2" width="30px"> {{ video.channel.name }}
                </nuxt-link>

                <a class="btn bg-danger btn-sm text-white box-shadow-v3" :href="video.links.youtube" target="_blank">
                    <i class="fab fa-youtube"></i> {{ $t('video.button.youtube') }}
                </a>
            </div>

            <h3 class="card-title mt-5 mb-0">{{ video.title }}</h3>
            <p class="small">{{ video.description }}</p>
        </div>

        <div class="bg-dark py-3 text-center text-white">
            <Statistics :data="video.stat" />
        </div>

        <Player :id="video.id" class="bg-white" />
        <Chart :id="video.id" class="box-shadow" />
        <Tags :id="video.id" class="bg-white" />

        <Comments :id="video.id" class="mt-3" />
        <div class="mt-3">
            <nuxt-child />
        </div>
    </section>
</template>

<script>
    import Chart from '~/components/Video/Chart';
    import Player from '~/components/Video/Player';
    import Tags from '~/components/Video/Tags';
    import Statistics from '~/components/Video/Statistics';
    import Comments from '~/components/Video/Comments';

    export default {
        components: { Chart, Statistics, Player, Tags, Comments },
        validate({params}) {
            return /^[\w_-]+$/.test(params.id)
        },
        async asyncData({app, params, error}) {
            const video = await app.$videoRepository.show(params.id, ['spam_comments']);

            return {video};
        },
        head() {
            return {
                title: this.video.title,
                //description: this.video.description
            }
        }
    }
</script>