<template>
    Вопрос: {{ question.question }}
    <table>
        <tr v-for="answer in question.student_answers">
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
    </table>
</template>

<script>
export default {
    name: "Question",
    props: {
        question: Object
    },
    data () {
        return {
            radio: null,
        }
    },
}
</script>

<style scoped>

</style>
