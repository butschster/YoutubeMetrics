<template>
    <div>
        <iframe class="video-player" width="100%"
                :src="`https://www.youtube.com/embed/${id}?rel=0&amp;showinfo=0`"
                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
</template>

<script>
    export default {
        props: {
            id: String
        }
    }
</script>