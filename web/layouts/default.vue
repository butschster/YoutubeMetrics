<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <nuxt-link class="navbar-brand" to="/">
                    <img src="/images/logo.png" />
                </nuxt-link>

                <Navbar />
            </div>
        </nav>

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