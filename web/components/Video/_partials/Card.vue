<template>
    <div :class="size">
        <div class="card mb-4 border-0 box-shadow">
            <nuxt-link class="card-subtitle mb-2" :to="videoLink">
                <img class="card-img-top" :src="video.links.thumb">
            </nuxt-link>
            <div class="card-body">
                <nuxt-link class="card-subtitle mb-2" :to="videoLink">
                    {{ video.title }}
                </nuxt-link>
            </div>
            <div class="card-footer bg-white">
                <div class="small d-flex justify-content-between align-self-end">
                    <nuxt-link :to="channelLink">
                        <img :src="video.channel.links.thumb" class="rounded-circle mr-2" width="25px">
                        {{ video.channel.name }}
                    </nuxt-link>
                    <span class="text-muted">{{ video.created_at | moment("from", true) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "video-card",
        props: {
            video: Object,
            size: {
                type: String,
                default: 'col-md-4'
            }
        },
        computed: {
            videoLink() {
                return { name: 'video-id', params: { id: this.video.id } }
            },
            channelLink() {
                return { name: 'channel-id', params: { id: this.video.channel.id } }
            }
        }
    }
</script>