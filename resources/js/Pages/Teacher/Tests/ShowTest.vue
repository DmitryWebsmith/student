<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900 dark:text-gray-100">
                        <h6>Название теста: {{ test.name }} </h6>
                    </div>
                    <div v-for="question in questions" :key="question.id"
                         class="p-3 text-gray-900 dark:text-gray-100">
                        <Question :question="question" />
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <q-card-section>
                    <q-card-actions align="left">
                        <DeleteTest :id="test.id" />
                        <UpdateTestButton :id="test.id" />
                    </q-card-actions>
                </q-card-section>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteTest from "@/Pages/Teacher/Tests/Components/DeleteTest.vue";
import Question from "@/Pages/Teacher/Tests/Components/Question.vue";
import UpdateTestButton from "@/Pages/Teacher/Tests/Components/UpdateTestButton.vue";

export default {
    name: "ShowTest",
    props: {
        test: Object,
        questions: Object,
    },
    components: { Layout, DeleteTest, Question, UpdateTestButton }
}
</script>

<style scoped>

</style>
