<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 pb-3 text-gray-900 dark:text-gray-100">
                        <h6>Название теста: {{ test.name }} </h6>
                    </div>
                    <div v-for="question in questions" :key="question.id"
                         class="px-6 pb-3 text-gray-900 dark:text-gray-100">
                        <Question
                            @response="(msg) => testPassed = msg"
                            :task="task"
                            :question="question"
                            :student="student"/>
                    </div>
                    <div v-if="testPassed" class="px-6 pb-3 text-gray-900 dark:text-gray-100">
                        <q-btn color="primary" label="Завершить" @click="closeTest"/>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedStudentLayout.vue'
import Question from "@/Pages/Student/Tests/Components/Question.vue";
import { router } from '@inertiajs/vue3'

export default {
    props: {
        task: Object,
        test: Object,
        questions: Object,
        student: Object,
    },
    components: { Layout, Question },
    data() {
        return {
            testPassed: false
        }
    },
    methods: {
        closeTest() {
            let data = {
                student_id: this.student.id,
                task_id: this.task.id
            }
            axios.post(route('mark.test.passed'), data)
                .then((res) => {
                    router.get(route('student.dashboard'))
                })
                .catch((error) => {
                    if (error.response) {
                        // alert(error.response.data.message);
                    }
                });
        }
    }
}
</script>

<style lang="sass" scoped>

</style>
