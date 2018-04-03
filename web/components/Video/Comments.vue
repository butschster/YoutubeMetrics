<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <strong class="navbar-text mr-3">
                Комментарии
            </strong>
            <ul class="navbar-nav">
                <li class="nav-item" v-if="authenticated">
                    <nuxt-link class="nav-link" :to="{name: 'video-id-comments', params: {id}}">
                        Все
                    </nuxt-link>
                </li>
                <li class="nav-item">
                    <nuxt-link class="nav-link" :to="{name: 'video-id-spam', params: {id}}">
                        Только спам
                    </nuxt-link>
                </li>
            </ul>
        </nav>

        <div v-if="!authenticated" class="alert box-shadow bg-info text-white mt-3" role="alert">
            <div class="media">
                <span class="d-flex mr-3">
                    <i class="fas fa-2x fa-info-circle"></i>
                </span>
                <span class="media-body align-self-center">
                     Просмотр всех комментариев и модерация доступны только после регистрации.
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                required: true
            }
        },
    }
</script>