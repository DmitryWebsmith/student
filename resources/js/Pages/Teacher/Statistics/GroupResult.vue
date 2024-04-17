<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>
                            Класс: <Link :href="route('show.group', task.group.id)">{{ task.group.name }}</Link>&nbsp&nbsp
                            Тест: <Link :href="route('show.test', task.test.id)">{{ task.test.name }}</Link>
                        </h6>
                    </div>

                    <div class="relative overflow-x-auto p-6">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" style="text-align: center">
                                    Ученик
                                </th>
                                <th scope="col" class="px-6 py-3" style="text-align: center">
                                    Правильные ответы
                                </th>
                                <th scope="col" class="px-6 py-3" style="text-align: center">
                                    Всего вопросов
                                </th>
                                <th scope="col" class="px-6 py-3" style="text-align: center">
                                    Оценка
                                </th>
                                <th scope="col" class="px-6 py-3" style="text-align: center">
                                    Действие
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="student in students" :key="student.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" style="text-align: center">
                                    {{ student.name }}
                                </th>
                                <td class="px-6 py-4" style="text-align: center">
                                    {{ student.result.correctAnswers }}
                                </td>
                                <td class="px-6 py-4" style="text-align: center">
                                    {{ student.result.questionNumbers }}
                                </td>
                                <td class="px-6 py-4" style="text-align: center">
                                    {{ student.result.score }}
                                </td>
                                <td class="px-6 py-4" style="text-align: center">
                                    <Link
                                        :href="route('show.student.result.stat', {student_id: student.result.id, test_id: student.result.test_id})">
                                        Результаты
                                    </Link>
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
// import ShowTask from "@/Pages/Teacher/Tasks/ShowTask.vue";

export default {
    name: "List",
    components: { Layout, Link },
    props: {
        task: Object,
        students: Object,
    },
}
</script>

<style scoped>

</style>
