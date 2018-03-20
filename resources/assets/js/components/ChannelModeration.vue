<template>
    <div>
        <h3>Модерация каналов</h3>

        <ul class="list-unstyled" v-for="channel in channels">
            <li class="media p-4 mb-3 border">
                <div class="d-flex mr-3">
                    <a :href="channel.link" target="_blank">
                        <img class="rounded-circle" width="40px" height="40px" :src="channel.thumb">
                    </a>
                </div>
                <div class="media-body mt-2">
                    <div class="d-flex justify-content-between">
                        <h5 class="font-weight-600">
                            <a :href="channel.link" target="_blank">{{ channel.name }}</a>
                        </h5>
                        <div>
                            <button class="btn btn-danger" @click="markAsBot(channel)">
                                <i class="fas fa-ban"></i> Бот
                            </button>
                            <button class="btn btn-sm btn-success" @click="markAsNormal(channel)">
                                <i class="fas fa-check"></i> Человек
                            </button>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
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
                    this.channels = response.data.data;
                } catch (e) {}

            },

            async markAsBot(channel) {
                try {
                    await axios.delete(`/api/channel/${channel.id}/moderate`);
                    this.channels = this.channels.filter((c) => {
                        return c.id != channel.id;
                    });
                } catch (e) {}
            },

            async markAsNormal(channel) {
                try {
                    await axios.post(`/api/channel/${channel.id}/moderate`);
                    this.channels = this.channels.filter((c) => {
                        return c.id != channel.id;
                    });
                } catch (e) {}
            }
        }
    }
</script>