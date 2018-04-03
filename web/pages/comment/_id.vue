<template>
    <section class="container">
       <div class="box-shadow">
           <blockquote class="blockquote mt-5 mb-0 bg-white p-5">
               <p class="font-size-12">{{ comment.text }}</p>
               <footer class="blockquote-footer">
                   <small class="text-muted">
                       Написал {{ comment.channel.name }}
                   </small>
               </footer>
           </blockquote>

           <header id="comment-header" class="bg-success text-white">
               <div class="d-flex justify-content-center">
                   <div class="align-self-center text-center">
                       <div class="btn-group my-4" role="group">
                           <nuxt-link class="btn btn-outline-light" :to="{name: 'channel-id', params: {id: comment.channel.id}}">
                               <img :src="comment.channel.links.thumb" class="rounded-circle mr-2" width="20px"/> {{ comment.channel.name }}
                           </nuxt-link>

                           <a class="btn btn-outline-light" :href="comment.links.youtube" target="_blank">
                               <i class="fab fa-youtube fa-lg"></i> Посмотреть на youtube
                           </a>
                       </div>
                   </div>
               </div>
           </header>
           <Chart :id="comment.id" />
       </div>
    </section>
</template>

<script>
    import Chart from '~/components/Comments/Chart';
    export default {
        components: {Chart},
        validate({params}) {
            return /^[\w_-]+$/.test(params.id)
        },
        async asyncData({app, params, error}) {
            const comment = await app.$commentRepository.show(params.id);

            return {comment};
        },
        head() {
            return {
                title: 'Комментарий'
            }
        }
    }
</script>