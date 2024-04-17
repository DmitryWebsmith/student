<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>Список тестов</h6>
                    </div>
                    <div v-for="test in tests" :key="test.id"
                         class="pl-6 py-2 text-gray-900 dark:text-gray-100">
                        <Link :href="route('show.test', test.id)">{{ test.name }}</Link>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="get" :action="route('add.test')">
                            <q-btn color="primary" label="Добавить тест" type="submit"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: "List",
    props: {
        tests: Object
    },
    components: { Layout, Link }
}
</script>

<style scoped>

</style>
