<template>
    <div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-2" v-for="channel in channels">
                <div class="box-shadow bg-white p-4">
                    <div class="media">
                        <img :src="channel.thumb" style="width: 40px" class="rounded-circle mr-3"/>
                        <div class="media-body align-self-center">
                            <p class="mb-0">
                                <a :href="channel.link" class="font-weight-700">{{ channel.name }}</a>
                            </p>
                            <div class="text-muted font-size-10">
                                <i class="fas fa-users mr-2"></i>
                                {{ channel.subscribers }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                channels: [],
                loading: false
            };
        },
        mounted() {
            this.load();
        },
        methods: {
            async load() {
                this.loading = true;

                try {
                    let response = await axios.get('/api/channels/followed');
                    this.channels = response.data.data;
                } catch (e) {
                }

                this.loading = false;
            }
        }
    }
</script>
