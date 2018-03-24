<template>
    <button class="btn btn-danger" @click="report()">
        <i class="fas fa-fire-extinguisher"></i>
        Не бот
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
                    title: 'Вы уверены, что он не бот?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Да, это не бот!',
                    cancelButtonText: 'Отмена'
                }).then((result) => {
                    if (result.value) {
                        this.sendReport();
                    }
                })
            },
            async sendReport() {
                try {
                    await axios.post(`/api/channel/${this.id}/moderate`);
                } catch (e) {
                }
            },
        }
    }
</script>