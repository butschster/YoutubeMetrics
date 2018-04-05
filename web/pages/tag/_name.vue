<template>
    <section class="container">
        <h1 class="bg-primary p-3 text-center text-white my-5 ">
            <small class="font-size-12">{{ $t('tag.title.search') }}</small> {{ tag.name }}
        </h1>

        <Videos :tag="tag.name"/>
    </section>
</template>

<script>
    import Videos from '~/components/Tag/Videos';

    export default {
        components: {Videos},
        validate({params}) {
            return /^[a-zA-Zа-яА-Я-_]+$/u.test(params.name)
        },
        async asyncData({app, params, error}) {
            const tag = await app.$tagRepository.show(params.name);
            return {tag};
        },
        head() {
            return {
                title: `${this.$t('tag.title.search')} - ${this.tag.name}`
            }
        }
    }
</script>