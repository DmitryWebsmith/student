<template>
    <Layout>
        Задача: {{ task }}
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="q-pa-md q-gutter-sm">
                            <DeleteTask :id="task.id" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteTask from "@/Pages/Teacher/Tasks/DeleteTask.vue";

export default {
    name: "ShowTask",
    components: { Layout, DeleteTask },
    props: {
        task: Object
    }
}
</script>

<style scoped>

</style>
