<template>
    <div>
        <h3>Модерация каналов</h3>

        <ul class="list-unstyled">
            <channel
                    class="bg-white box-shadow"
                    :channel="channel"
                    v-for="channel in channels"
                    :key="channel.id"
                    v-on:bot="hide"
                    v-on:normal="hide"
            ></channel>
        </ul>
    </div>
</template>

<script>
    import Channel from './Moderation/Channel';

    export default {
        components: {Channel},
        data() {
            return {
                channels: [],
            }
        },
        mounted() {
            this.load();
        },
        methods: {
            async load() {

                try {
                    let response = await axios.get('/api/channel/reported');
                    this.channels = _.map(response.data.data, (channel) => {
                        channel.comments = [];
                        return channel;
                    });
                } catch (e) {}

            },

            async hide(channel) {
                this.channels = this.channels.filter((c) => {
                    return c.id != channel.id;
                });
            }
        }
    }
</script>