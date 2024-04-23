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
                        <UpdateQuestion :question="question" />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateQuestion from "@/Pages/Teacher/Tests/Components/UpdateQuestion.vue";

export default {
    name: "ShowTest",
    props: {
        test: Object,
        questions: Object,
    },
    components: { Layout, UpdateQuestion }
}
</script>

<style scoped>

</style>
