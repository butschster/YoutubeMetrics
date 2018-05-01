<template>
    <div class="row followed-channels" v-if="channels">

        <div class="col-lg-4 col-md-6 col-sm-12 mb-2" v-for="channel in channels" :key="channel.id">

            <div class="media channel box-shadow bg-white p-4">
                <img :src="channel.links.thumb" class="channel-thumb rounded-circle mr-3"/>

                <div class="media-body align-self-center">
                    <p class="mb-0">
                        <nuxt-link :to="{ name: 'channel-id', params: { id: channel.id } }" class="font-weight-700">{{ channel.name }}</nuxt-link>
                    </p>
                    <div class="text-muted font-size-10">
                        <i class="fas fa-users mr-2"></i>
                        {{ channel.subscribers }}
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
                channels: []
            };
        },
        mounted() {
            this.load();
        },
        methods: {
            async load() {
                try {
                    this.channels = await this.$channelRepository.followed();
                } catch (e) {

                }
            }
        }
    }
</script>

<style lang="scss">
    .followed-channels {
        .channel {
            .channel-thumb {
                width: 40px;
            }
        }
    }
</style>