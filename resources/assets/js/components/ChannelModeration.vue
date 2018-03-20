<template>
    <div>
        <h3>Модерация каналов</h3>

        <div class="card mb-3" v-for="channel in channels">
            <div class="card-body">
                <a class="card-title" :href="channel.link" target="_blank">
                    <i class="far fa-user-circle"></i> {{ channel.name }}
                </a>
            </div>

            <div class="card-footer">
                <button class="btn btn-danger" @click="markAsBot(channel)">
                    <i class="fas fa-ban"></i>
                </button>

                <button class="btn btn-success" @click="markAsNormal(channel)">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
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