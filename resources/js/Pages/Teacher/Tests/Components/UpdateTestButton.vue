<script>
import {router} from '@inertiajs/vue3'
export default {
    name: "UpdateTestButton",
    props: {
        id: Number,
    },
    methods: {
        showUpdateTestPage() {
            router.get(route('show.update.test.page', {id: this.id}))
        }
    }
}
</script>

<template>
    <q-btn color="primary" label="Изменить тест" @click="showUpdateTestPage"/>
</template>

<style scoped>

</style>
