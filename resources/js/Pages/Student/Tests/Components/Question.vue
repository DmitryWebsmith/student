<template>
    <div class="q-pa-sm">
        <div class="row">
            <div>Вопрос: {{ question.question }}</div>
        </div>
        <table>
            <tr v-for="answer in question.answers">
                <template v-if="answer.type === 'text'">
                    <td>Ответ:</td>
                    <td style="width: 800px;">
                        <input v-model="text" class="block w-full"/>
                    </td>
                </template>
                <template v-if="answer.type === 'checkbox'">
                    <td>Ответ: {{ answer.answer }}</td>
                    <td>
                        <input type="checkbox" :value="answer.id" v-model="checkbox">
                    </td>
                </template>
                <template v-if="answer.type === 'radiobutton'">
                    <td>Ответ: {{ answer.answer }}</td>
                    <td>
                        <input type="radio" :value="answer.id" v-model="radio">
                    </td>
                </template>
            </tr>
        </table>
    </div>
</template>

<script>
import { useQuasar } from 'quasar'

export default {
    name: "Question",
    props: {
        question: Object,
        student: Object
    },
    emits: ['response'],
    mounted() {
        for (let key in this.question.student_answers) {
            if (this.question.student_answers.hasOwnProperty(key)) {
                if (this.question.student_answers[key]['student_id'] !== this.student.id) {
                    continue
                }

                if (this.question.student_answers[key]['type'] === 'checkbox' && this.question.student_answers[key]['truth'] === 1) {
                    this.checkbox.push(this.question.student_answers[key]['answer_id']);
                }

                if (this.question.student_answers[key]['type'] === 'radiobutton' && this.question.student_answers[key]['truth'] === 1) {
                    this.radio = this.question.student_answers[key]['answer_id'];
                }

                if (this.question.student_answers[key]['type'] === 'text') {
                    this.text = this.question.student_answers[key]['text'];
                }
            }
        }
    },
    data() {
        return {
            radio: null,
            text: null,
            checkbox: [],
            $q: useQuasar(),
        }
    },
    methods: {
        showNotify(message) {
            this.$q.notify({
                message: message,
                color: 'primary',
                // avatar: 'https://cdn.quasar.dev/img/boy-avatar.png',
                actions: [
                    { icon: 'close', color: 'white', round: true, handler: () => { /* ... */ } }
                ]
            })
        },
        postStudentAnswer(data) {
            axios.post(route('store.student.answer'), data)
                .then((res) => {
                    if (res.data.testPassed === true) {
                        this.$emit('response', true)
                    } else {
                        this.$emit('response', false)
                    }

                    if (res.data.message !== null && res.data.message.length > 0) {
                        this.showNotify(res.data.message)
                    }
                })
                .catch((error) => {
                    if (error.response) {
                        // alert(error.response.data.message);
                    }
                });
        }
    },
    watch: {
        radio(oldData, newData) {
            this.postStudentAnswer(
                {
                    student_id: this.student.id,
                    question_id: this.question.id,
                    answer: this.radio
                }
            )
        },
        text(oldData, newData) {
            this.postStudentAnswer(
                {
                    student_id: this.student.id,
                    question_id: this.question.id,
                    answer: this.text
                }
            )
        },
        checkbox(oldData, newData) {
            this.postStudentAnswer(
                {
                    student_id: this.student.id,
                    question_id: this.question.id,
                    answer: this.checkbox
                }
            )
        },
    }
}
</script>

<style scoped>
TABLE {
    background: white; /* Цвет фона таблицы */
    color: black; /* Цвет текста */
}

TD, TH {
    background: white; /* Цвет фона ячеек */
    padding: 7px; /* Поля вокруг текста */
    border: 0px solid black; /* Параметры рамки */
}
</style>
