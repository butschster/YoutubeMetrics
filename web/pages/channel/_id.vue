<template>
    <section class="container mt-5">
        <header id="channel-header" class="card rounded-0 text-white" :class="`channel-type-${channel.type}`">

            <div class="cover" :style="{'backgroundImage': `url(${channel.links.thumb})`}" v-if="channel.links.thumb"></div>
            <div class="cover bg-dark" v-else></div>

            <div class="card-img-overlay d-flex justify-content-center">
                <div class="align-self-center text-center">
                    <h1 class="card-title">{{ channel.name }}</h1>
                    <h3>{{ channel.type }}</h3>

                    <div>
                        <span class="badge badge-light">ID: <strong>{{ channel.id }}</strong></span>
                    </div>

                    <div class="btn-group my-4" role="group">
                        <a class="btn btn-outline-light" :href="channel.links.youtube" target="_blank">
                            <i class="fab fa-youtube fa-fw fa-lg"></i> Канал
                        </a>
                        <a class="btn btn-outline-light" :href="channel.links.t30" target="_blank">
                            <i class="fab fa-lg fa-fw fa-searchengin"></i> Поиск комментариев
                        </a>

                        <button class="btn btn-danger" @click="report()">
                            <i class="fas fa-bug"></i>
                            Пожаловаться
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="bg-primary py-3 text-center text-white">
            <Statistics :data="channel.stat" />
        </div>

        <Chart :id="channel.id"/>
        <Videos :id="channel.id" class="mt-5" />
    </section>
</template>

<script>

    import Videos from '~/components/Channel/Videos';
    import Chart from '~/components/Channel/Chart';
    import Statistics from '~/components/Channel/Statistics';
    import Repository from '~/repositories/ChannelRepository';

    export default {
        components: {Chart, Statistics, Videos},
        validate({params}) {
            return /^[\w_-]+$/.test(params.id)
        },
        async asyncData({params, error}) {
            const channel = await Repository.show(params.id);

            return {channel};
        },
        methods: {
            async report() {
                try {
                    await Repository.report(this.channel.id)
                } catch (e) {
                    console.log(e)
                }
            }
        },
        head() {
            return {
                title: this.channel.name
            }
        }
    }
</script>