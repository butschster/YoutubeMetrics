<template>
    <div>
        <Navbar />

        <main>
            <nuxt/>
        </main>

        <FooterBlock />
    </div>
</template>

<script>
    import FooterBlock from './_partials/Footer';
    import Navbar from './_partials/Navbar';

    export default {
        components: {FooterBlock, Navbar}
    }
</script>