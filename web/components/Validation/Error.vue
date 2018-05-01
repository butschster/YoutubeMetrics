<template>
    <div class="invalid-feedback" v-if="errors.email">
        {{ errors.email[0] }}
    </div>
</template>

<script>
    export default {
        name: "Error"
    }
</script>