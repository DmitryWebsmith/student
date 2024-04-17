<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>Список категорий</h6>
                    </div>
                    <div v-for="category in categories" :key="category.id"
                         class="pl-6 py-2 text-gray-900 dark:text-gray-100">
                        <Link :href="route('show.category', category.id)">{{ category.name }}</Link>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <StoreCategory />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import StoreCategory from "@/Pages/Teacher/Categories/StoreCategory.vue";

export default {
    name: "List",
    props: {
        categories: Object
    },
    components: { Layout, Link, StoreCategory }
}
</script>

<style scoped>

</style>
