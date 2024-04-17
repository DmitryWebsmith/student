<template>
    Вопрос: {{ question.question }}
    <table>
        <tr v-for="answer in question.answers">
            <template v-if="answer.type === 'text'">
                <td class="p-1">Ответ:</td>
                <td class="p-1">{{ answer.answer }}</td>
            </template>
            <template v-if="answer.type === 'checkbox'">
                <td class="p-1">Ответ:</td>
                <td class="p-1">{{ answer.answer }}</td>
                <td class="p-1"><input type="checkbox" :checked="answer.truth"></td>
            </template>
            <template v-if="answer.type === 'radiobutton'">
                <td class="p-1">Ответ:</td>
                <td class="p-1">{{ answer.answer }}</td>
                <td class="p-1"><input type="radio" :checked="answer.truth" :value="answer.id" v-model="radio"></td>
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
