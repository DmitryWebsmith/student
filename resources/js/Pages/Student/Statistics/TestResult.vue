<template>
    <Layout>
        <Head title="Результат" />
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 pt-6 text-gray-900 dark:text-gray-100 text-body1">
                        Класс: {{ student.group.name }} <br>
                        Ученик: {{ student.first_name }} {{ student.last_name }} <br>
                        Категория: {{ test.category.name }} <br>
                        Тест: {{ test.name }}
                    </div>
                    <div class="relative overflow-x-auto p-6">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                            style="width: 500px">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th style="width: 50%">Ответ учащегося</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="question in questions" :key="question.id" class="bg-white border-b">
                                <td
                                    class="px-6 py-4 vertical-top"
                                    :style="getStyle(question.id)"
                                >
                                    <StudentAnswers
                                        :student="student"
                                        :question="question" />
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
import Layout from '@/Layouts/AuthenticatedStudentLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import StudentAnswers from "@/Pages/Student/Statistics/components/StudentAnswers.vue";

export default {
    name: "List",
    components: { Head, Layout, Link, StudentAnswers },
    props: {
        test: Object,
        questions: Object,
        student: Object,
        result: Object,
    },
    data () {
        return {}
    },
    methods: {
        getStyle(questionId) {
            if (questionId in this.result.questions) {
                if (this.result.questions[questionId] === true) {
                    return "color: green"
                }
            }

            return "color: red"
        }
    }
}
</script>

<style scoped>

</style>
