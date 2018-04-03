<template>
    <div>
        <div v-if="authenticated">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <strong class="navbar-text mr-3">
                    Комментарии
                </strong>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <nuxt-link class="nav-link" :to="{name: 'channel-id-comments', params: {id}}">
                            Автор
                        </nuxt-link>
                    </li>
                    <li class="nav-item">
                        <nuxt-link class="nav-link" :to="{name: 'channel-id-spam', params: {id}}">
                            Спам
                        </nuxt-link>
                    </li>
                </ul>
            </nav>
        </div>


        <div v-else class="alert box-shadow bg-info text-white mt-3" role="alert">
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