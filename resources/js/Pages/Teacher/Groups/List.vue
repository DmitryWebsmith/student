<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>Список классов</h6>
                    </div>
                    <div v-for="group in groups" :key="group.id"
                         class="pl-6 py-2 text-gray-900 dark:text-gray-100">
                        <Link :href="route('show.group',group.id)">{{ group.name }}</Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <AddGroup />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import AddGroup from "@/Pages/Teacher/Groups/Partials/AddGroup.vue";

export default {
    name: "List",
    components: { Link, Layout, AddGroup },
    props: {
        groups: Object
    }
}
</script>

<style scoped>

</style>
