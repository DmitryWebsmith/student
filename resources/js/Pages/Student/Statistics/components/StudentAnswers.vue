<template>
    Вопрос: {{ question.question }}
    <table>
        <tr v-for="answer in studentAnswers">
            <template v-if="answer.type === 'text'">
                <td class="p-1">Ответ:</td>
                <td class="p-1">{{ answer.text }}</td>
            </template>
            <template v-if="answer.type === 'checkbox'">
                <td class="p-1">Ответ:</td>
                <td class="p-1">{{ answer.answer.answer }}</td>
            </template>
            <template v-if="answer.type === 'radiobutton'">
                <td class="p-1">Ответ:</td>
                <td class="p-1">{{ answer.answer.answer }}</td>
            </template>
        </tr>
        <template v-if="Object.keys(studentAnswers).length === 0">
            <tr>
                <td class="p-1">
                    Нет ответа.
                </td>
            </tr>
        </template>
    </table>
</template>

<script>
export default {
    name: "Question",
    props: {
        task: Object,
        question: Object,
        student: Object,
    },
    computed: {
        studentAnswers: function () {
            return this.question.student_answers.filter((studentAnswer) => studentAnswer.student_id === this.student.id && studentAnswer.task_id === this.task.id)
        },
    },
}
</script>

<style scoped>

</style>
