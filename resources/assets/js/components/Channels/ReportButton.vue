<template>
    <button class="btn btn-danger" @click="report()">
        <i class="fas fa-bug"></i>
        Пожаловаться
    </button>
</template>

<script>
    export default {
        props: {
            id: {
                required: true,
                type: String
            }
        },
        methods: {
            report() {
                this.$swal({
                    title: 'Вы уверены, что он бот?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Да, это бот!',
                    cancelButtonText: 'Отмена'
                }).then((result) => {
                    if (result.value) {
                        this.sendReport();
                    }
                })
            },
            async sendReport() {
                try {
                    let response = await axios.post(`/api/channel/abuse`, {channel_id: this.id});
                } catch (e) {
                }
            },
        }
    }
</script>