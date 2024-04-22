<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>
                            Список пройденных тестов класса <Link :href="route('show.group', group.id)">{{ group.name }}</Link>
                        </h6>
                    </div>

                    <div class="relative overflow-x-auto p-6">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Категория
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
                                <th class="px-6 py-4 text-weight-regular">
                                    {{ task.test.category.name }}
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
                                    <Link :href="route('show.group.result', task.id)">Результаты</Link>
                                </td>
                            </tr>

                            </tbody>
                        </table>
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
    components: { Layout, Link },
    props: {
        tasks: Object,
        group: Object,
    },
}
</script>

<style scoped>

</style>
