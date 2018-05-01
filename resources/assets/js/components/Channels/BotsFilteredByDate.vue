<template>
    <div>
        <h3>Боты зарегистрированные {{ date }}</h3>

        <ul class="list-unstyled channels">
            <channel
                    class="bg-white box-shadow channel"
                    :channel="channel"
                    v-for="channel in channels"
                    :key="channel.id"
                    v-on:verified="hide"
            ></channel>
        </ul>
    </div>
</template>

<script>
    import Channel from './_partials/Channel';

    export default {
        components: {Channel},
        props: {
            date: {
                required: true
            }
        },
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
                    let response = await axios.get(`/api/bots/created/${this.date}`);
                    this.channels = _.map(response.data.data, (channel) => {
                        channel.comments = [];
                        return channel;
                    });
                } catch (e) {}

            },

            hide(channel) {
                this.channels = this.channels.filter((c) => {
                    return c.id != channel.id;
                });
            }
        }
    }
</script>