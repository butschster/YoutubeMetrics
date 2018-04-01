<template>
    <div class="row">
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.views }}</div>
            <small>Просмотров</small>
        </div>
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.likes }}</div>
            <small>Лайки</small>
        </div>
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.dislikes }}</div>
            <small>Дизлайки</small>
        </div>
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.comments }}</div>
            <small>Комментарии</small>
        </div>
        <div class="col-sm">
            <div class="font-size-30 font-weight-300">{{ data.spam_comments }}</div>
            <small>Спам</small>
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