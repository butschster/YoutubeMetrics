<template>
    <section class="container">
        <div class="bg-white box-shadow p-4 mt-5">

            <nuxt-link :to="{ name: 'channel-id', params: {id: this.video.channel.id } }" target="_blank">
                <img :src="video.channel.links.thumb" class="rounded-circle mr-2" width="30px"> {{ video.channel.name }}
            </nuxt-link>

            <h3 class="card-title mt-3 mb-0">{{ video.title }}</h3>
            <p class="small">{{ video.description }}</p>
        </div>

        <div class="bg-dark py-3 text-center text-white">
            <Statistics :data="video.stat" />
        </div>

        <Chart :id="video.id"/>
        <Player :id="video.id"/>

        <div class="text-center">
            <a class="btn bg-danger text-white" :href="`https://www.youtube.com/watch?v=${video.id}`" target="_blank">
                <i class="fab fa-youtube"></i> Посмотреть на youtube
            </a>
        </div>
    </section>
</template>

<script>
    import Chart from '~/components/Video/Chart';
    import Player from '~/components/Video/Player';
    import Statistics from '~/components/Video/Statistics';
    import VideoRepository from '~/repositories/VideoRepository';

    export default {
        components: { Chart, Statistics, Player },
        validate({params}) {
            return /^[\w_-]+$/.test(params.id)
        },
        async asyncData({params, error}) {
            const video = await VideoRepository.show(params.id, ['spam_comments']);

            return {video};
        },
        head() {
            return {
                title: this.video.title,
                description: this.video.description
            }
        }
    }
</script>