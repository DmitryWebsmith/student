<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>Список тестов категории {{ category.name }} </h6>
                    </div>
                    <div v-for="test in category.tests"
                         class="px-6 mb-4 text-gray-900 dark:text-gray-100">
                        <Link :href="route('show.test', test.id)">{{ test.name }}</Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900 dark:text-gray-100">
                        <q-card-section>
                            <q-card-actions align="left">
                                <DeleteCategory :category_id = category.id></DeleteCategory>
                            </q-card-actions>
                        </q-card-section>
                    </div>
                </div>
            </div>
        </div>

    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import {Link} from "@inertiajs/vue3";
import DeleteCategory from './DeleteCategory.vue'

export default {
    name: "ShowCategory",
    components: { Layout, Link, DeleteCategory },
    props: {
        category: Object
    }
}
</script>

<style scoped>

</style>
