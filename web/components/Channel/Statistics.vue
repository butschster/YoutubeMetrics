<template>
    <div class="row">
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.views }}</div>
            <small>Просмотры</small>
        </div>
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.subscribers }}</div>
            <small>Подписчики</small>
        </div>
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.comments }}</div>
            <small>Комментарии</small>
        </div>
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.bot_comments }}</div>
            <small>Комментари от ботов</small>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                required: true,
                type: Object
            }
        }
    }
</script>