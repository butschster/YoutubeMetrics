<template>
    <div class="container mt-5">
        <header>

            <h3>Модерация каналов</h3>
        </header>

        <ul class="list-unstyled mt-5">
            <Channel
                    class="bg-white box-shadow"
                    :channel="channel"
                    v-for="channel in channels"
                    :key="channel.id"
                    v-on:bot="hide"
                    v-on:verified="hide"
            />
        </ul>
    </div>
</template>

<script>
    import Channel from '~/components/Channel/Moderation/Channel';

    export default {
        components: {Channel},
        async asyncData({app}) {
            let channels = await app.$channelRepository.reported();

            channels = _.map(channels, (channel) => {
                channel.comments = [];
                return channel;
            });

            return {channels}
        },
        methods: {
            hide(channel) {
                this.channels = this.channels.filter((c) => {
                    return c.id != channel.id;
                });
            }
        },
        head() {
            return {
                title: 'Модерация каналов - BotsMeter',
            }
        }
    }
</script>