<template>
    <div class="p-3 text-center" v-if="tags.length">
        <nuxt-link v-for="tag in tags" :to="tagLink(tag)" :key="tag.id"
           class="badge badge-light text-primary font-weight-100">{{ tag.name }}
        </nuxt-link>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                required: true,
                type: String
            }
        },
        data() {
            return {
                tags: []
            }
        },
        mounted() {
            this.loadTags();
        },
        methods: {
            async loadTags() {
                try {
                    this.tags = await this.$videoRepository.tags(this.id);
                } catch (e) {

                }
            },
            tagLink(tag) {
                return {name: 'tag-name', params: {name: tag.name}}
            }
        },
    }
</script>