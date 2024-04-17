<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>Список задач</h6>
                    </div>

                    <div class="relative overflow-x-auto p-6">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Класс
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Тест
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Дата и время начала сдачи
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Дата и время окончания сдачи
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Действие
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="task in tasks" :key="task.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <Link :href="route('show.group', task.group.id)">{{ task.group.name }}</Link>
                                    </th>
                                    <td class="px-6 py-4">
                                        <Link :href="route('show.test', task.test.id)">{{ task.test.name }}</Link>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ task.start_time }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ task.end_time }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <Link :href="route('show.task.results', task.id)">Результаты</Link>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="q-pa-md q-gutter-sm">
                            <form :action="route('add.task')">
                                <q-btn color="primary" label="Добавить задачу" type="submit"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import ShowTask from "@/Pages/Teacher/Tasks/ShowTask.vue";

export default {
    name: "List",
    components: { Layout, Link, ShowTask },
    props: {
        tasks: Object,
    },
}
</script>

<style scoped>

</style>
