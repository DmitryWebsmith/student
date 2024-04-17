<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 pt-6 text-gray-900 dark:text-gray-100 text-body1">
                        Класс: {{ student.group.name }} <br>
                        Ученик: {{ student.first_name }} {{ student.last_name }} <br>
                        Результаты пройденных тестов
                    </div>

                    <div class="relative overflow-x-auto p-6">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Тест
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Оценка
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ответы
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Дата сдачи теста
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Категория
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="Object.keys(results).length > 0">
                                <tr v-for="result in results" :key="result.test_id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ result.test_name }}
                                    </th>
                                    <th class="px-6 py-4 text-weight-regular">
                                        {{ result.score }}
                                    </th>
                                    <th class="px-6 py-4 text-weight-regular">
                                        <Link
                                            :href="route('student.statistics.test.result', {test_id: result.test_id})">
                                            Просмотр
                                        </Link>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ result.pass_date }}
                                    </td>
                                    <th class="px-6 py-4 text-weight-regular">
                                        {{ result.category_name }}
                                    </th>
                                </tr>
                            </template>
                            <template v-if="Object.keys(tasks).length === 0">
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4" colspan="5">
                                        Нет пройденных тестов.
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedStudentLayout.vue';
import { Link } from '@inertiajs/vue3';
// import ShowTask from "@/Pages/Teacher/Tasks/ShowTask.vue";

export default {
    name: "List",
    components: { Layout, Link },
    props: {
        tasks: Object,
        student: Object,
        results: Object,
    },
}
</script>

<style scoped>

</style>
