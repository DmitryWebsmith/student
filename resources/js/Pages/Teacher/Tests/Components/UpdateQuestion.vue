<template>
    <table style="width: 100%">
        <tr>
            <td class="p-1" style="width: 5%">Вопрос:</td>
            <td class="p-1" style="width: 90%">
                <input
                    v-model="questionModel"
                    @input="updateText(question.id, questionModel, 'question')"
                    type="text"
                    class="mt-1 block w-full"/>
            </td>
            <td class="p-1" style="width: 5%">
                <button
                    @click="removeQuestion(question.id)"
                    class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                    X
                </button>
            </td>
        </tr>
        <tr v-for="(answer, index) in question.answers" :key="index">
            <td class="p-1" style="width: 5%">Ответ:</td>

            <td class="p-1" v-if="answer.type === 'text'">
                <input
                    v-model="answerText"
                    @input="updateText(question.answers[index].id, answerText, 'answer')"
                    type="text"
                    class="mt-1 block w-full"/>
            </td>

            <template v-if="answer.type === 'checkbox'">
                <td class="p-1" style="width: 90%">
                    <input
                        v-model="question.answers[index].answer"
                        @input="updateText(question.answers[index].id, question.answers[index].answer, 'answer')"
                        type="text"
                        class="mt-1 block w-full"
                    />
                </td>
                <td class="p-1" style="width: 5%">
                    <input type="checkbox" :id="answer.id" :value="answer.id" v-model="checkList">
                </td>
            </template>

            <template v-if="answer.type === 'radiobutton'">
                <td class="p-1" style="width: 90%">
                    <input
                        v-model="question.answers[index].answer"
                        @input="updateText(question.answers[index].id, question.answers[index].answer, 'answer')"
                        type="text"
                        class="mt-1 block w-full"
                    />
                </td>
                <td class="p-1" style="width: 5%">
                    <input type="radio" :checked="answer.truth" :value="answer.id" v-model="radio">
                </td>
            </template>
        </tr>
    </table>
</template>

<script>
import { router } from '@inertiajs/vue3'

export default {
    name: "Question",
    props: {
        question: Object
    },
    data() {
        return {
            questionModel: this.question.question,
            radio: null,
            answerText: null,
            checkList: [],
        }
    },
    mounted() {
        if (this.question.answers[0].type === 'text') {
            this.answerText = this.question.answers[0].answer
        }

        if (this.question.answers[0].type === 'checkbox') {
            this.question.answers.forEach((answer) => {
                if (answer.truth === 1) {
                    this.checkList.push(answer.id)
                }
            });
        }
    },
    methods: {
        removeQuestion(questionId) {
            this.postRequest('/test/question/'+questionId, {})
            router.reload({})
        },
        updateText(id, text, type) {
            if (text.length === 0) {
                alert("Текстовое поле не должно быть пустым")
                return null
            }

            let data = {
                type: 'answer',
                id: id,
                text: text
            }

            if (type === 'question') {
                data = {
                    type: 'question',
                    id: id,
                    text: text
                }
            }

            this.postRequest('/test/update-text', data)
        },
        postRequest(address, data) {
            axios.post(address, data)
                .catch((error) => {
                    if (error.response) {
                        alert(error.response.data);
                    }
                });
        },
    },
    watch: {
        checkList(newValue, oldValue) {
            this.postRequest('/test/update-right-answers', {right_answers: newValue})
        },
        radio(newValue, oldValue) {
            this.postRequest('/test/update-right-answers', {right_answers: [newValue]})
        },
    }
}
</script>

<style scoped>

</style>
