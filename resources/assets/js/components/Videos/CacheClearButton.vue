<template>
    <button class="btn" @click="clear()">
        <i class="fas fa-sync"></i>
        Сбросить кеш
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
            clear() {
                this.$swal({
                    title: 'Вы уверены, что хотите сбросить кеш?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Да!',
                    cancelButtonText: 'Отмена'
                }).then((result) => {
                    if (result.value) {
                        this.send();
                    }
                })
            },
            async send() {
                try {
                    let response = await axios.delete(`/api/video/${this.id}/comments/cache`);
                    this.$swal('Кеш успешно сброшен');
                } catch (e) {
                }
            },
        }
    }
</script>