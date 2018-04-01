<template>
    <section class="container mt-5">
        <Videos/>
        <FollowedChannels />
    </section>
</template>

<script>
    import Videos from '~/components/Video/ListWithPagination';
    import FollowedChannels from '~/components/Channel/Followed';

    export default {
        components: { Videos, FollowedChannels },
        head() {
            return {
                title: 'Hello world'
            }
        }
    }
</script>