<template>
    <Layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div v-show="testNameVisibility">
                            <div class="q-gutter-md pb-3">
                                <q-select outlined v-model="category" :options="categoryOptions"
                                          label="Выбор категории"/>
                            </div>

                            <label>Название теста</label>
                            <input v-model="testName" type="text" class="mt-1 block w-full"/>

                            <div class="mt-6">
                                <button
                                    @click="storeTestNameAndAddNewQuestion"
                                    class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                    Добавить вопрос
                                </button>
                            </div>
                        </div>

                        <div class="mt-6" v-show="questionVisibility">
                            <label>Вопрос</label>
                            <input v-model="question" type="text" class="mt-1 block w-full"/>
                            <div class="mt-6">
                                <label>Добавить Ответ. Возможные варианты ответа: текстовое поле, одиночный выбор,
                                    множественный
                                    выбор</label><br><br>
                                <button
                                    @click="addTextAnswerAndStoreQuestion"
                                    class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                    Текстовое поле
                                </button>
                                &nbsp
                                <button
                                    @click="showRadioButtonAnswerAndStoreQuestion"
                                    class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                    Одиночный выбор
                                </button>
                                &nbsp
                                <button
                                    @click="showCheckBoxAnswerAndStoreQuestion"
                                    class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                    Множественный выбор
                                </button>
                                &nbsp
                            </div>
                        </div>

                        <div class="mt-6" v-show="textAnswerVisibility">
                            <label>Ответ</label>
                            <input v-model="textAnswer" type="text" class="mt-1 block w-full"/>
                            <div class="mt-6">
                                <button
                                    @click="storeTextAnswer"
                                    class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                    Сохранить
                                </button>
                            </div>
                        </div>

                        <div class="mt-6" v-show="checkBoxAnswerVisibility">
                            <label>Ответ</label>
                            <table style="width: 100%">
                                <tr v-for="answer in checkBoxAnswers" :key="answer.id">
                                    <td style="width: 90%">
                                        <input type="text" v-model="answer.text" class="mt-1 block w-full"/>
                                    </td>
                                    <td style="width: 5%; text-align: right">
                                        <input type="checkbox" v-model="answer.truth">
                                    </td>
                                    <td style="width: 5%; text-align: right">
                                        <button
                                            @click="removeCheckBoxAnswer(answer)"
                                            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                            X
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <table class="mt-6">
                                <tr>
                                    <td>
                                        <button
                                            @click="addCheckBoxAnswer"
                                            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                            Добавить дополнительный ответ
                                        </button>
                                    </td>
                                    <td>
                                        <button
                                            @click="postMultipleAnswer('checkbox')"
                                            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                            Сохранить ответ
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-6" v-show="radioButtonAnswerVisibility">
                            <label>Ответ</label>
                            <table style="width: 100%">
                                <tr v-for="answer in radioButtonAnswers" :key="answer.id">
                                    <td style="width: 90%">
                                        <input type="text" v-model="answer.text" class="mt-1 block w-full"/>
                                    </td>
                                    <td style="width: 5%; text-align: right">
                                        <input type="radio" :checked="answer.truth" :value="answer.id" v-model="radio">
                                    </td>
                                    <td style="width: 5%; text-align: right">
                                        <button
                                            @click="removeRadioAnswer(answer)"
                                            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                            X
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <table class="mt-6">
                                <tr>
                                    <td>
                                        <button
                                            @click="addRadioButtonAnswer"
                                            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                            Добавить дополнительный ответ
                                        </button>
                                    </td>
                                    <td>
                                        <button
                                            @click="postMultipleAnswer('radiobutton')"
                                            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                            Сохранить ответ
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-6" v-show="finishVisibility">
                            <button
                                @click="completeTestCreation"
                                class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                Завершить создание теста
                            </button>
                            &nbsp
                            <button
                                @click="addNewQuestion"
                                class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
                                Добавить новый вопрос
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';

let id = 0

export default {
    name: "AddComponent",
    components: {Layout},
    props: {
        categories: Object
    },
    mounted() {
        for (let key in this.categories) {
            this.categoryOptions.push({
                label: this.categories[key]['name'],
                value: this.categories[key]['id'],
            })
        }
    },
    data() {
        return {
            testId: 1,
            questionId: 1,
            answerId: 1,
            category: null,
            testName: null,
            question: null,
            textAnswer: null,
            radio: null,
            categoryOptions: [],
            checkBoxAnswers: [
                {id: id++, text: '', truth: false},
                {id: id++, text: '', truth: false},
                {id: id++, text: '', truth: false},
            ],
            radioButtonAnswers: [
                {id: id++, text: '', truth: false},
                {id: id++, text: '', truth: false},
                {id: id++, text: '', truth: false},
            ],
            testNameVisibility: true,
            questionVisibility: false,
            choosingAnswerOption: false,
            textAnswerVisibility: false,
            checkBoxAnswerVisibility: false,
            radioButtonAnswerVisibility: false,
            finishVisibility: false,
        }
    },
    methods: {
        multipleAnswerValidation(answerObject) {
            let answerChecked = false
            for (let key in answerObject) {
                if (answerObject.hasOwnProperty(key)) {
                    if (answerObject[key].text.length === 0) {
                        alert("Все поля вариантов ответа должны быть заполнены.")
                        return false
                    }
                    if (answerObject[key].truth) {
                        answerChecked = true;
                    }
                }
            }
            if (answerChecked === false) {
                alert("Один из ответов должен быть помечен верным.")
                return false
            }
            return true
        },
        postMultipleAnswer(type) {
            let data
            if (type === 'checkbox') {
                if (!this.multipleAnswerValidation(this.checkBoxAnswers)) {
                    return null
                }
                data = {
                    question_id: this.questionId,
                    type: type,
                    answers: this.checkBoxAnswers,
                }
            }
            if (type === 'radiobutton') {
                if (!this.multipleAnswerValidation(this.radioButtonAnswers)) {
                    return null
                }
                data = {
                    question_id: this.questionId,
                    type: type,
                    answers: this.radioButtonAnswers,
                }
            }
            axios.post('/test/save-multiple-answer', data)
                .then((res) => {
                    if (type === 'checkbox') {
                        for (let index = 0; index < this.checkBoxAnswers.length; ++index) {
                            this.checkBoxAnswers[index]['text'] = '';
                            this.checkBoxAnswers[index]['truth'] = false;
                        }
                        this.checkBoxAnswerVisibility = false
                    }
                    if (type === 'radiobutton') {
                        for (let index = 0; index < this.radioButtonAnswers.length; ++index) {
                            this.radioButtonAnswers[index]['text'] = '';
                            this.radioButtonAnswers[index]['truth'] = false;
                        }
                        this.radioButtonAnswerVisibility = false
                    }
                    this.finishVisibility = true
                })
                .catch((error) => {
                    if (error.response) {
                        alert(error.response.data.message);
                    }
                });
        },
        addCheckBoxAnswer() {
            this.checkBoxAnswers.push({id: id++, text: '', truth: false})
        },
        removeCheckBoxAnswer(answer) {
            this.checkBoxAnswers = this.checkBoxAnswers.filter((t) => t !== answer)
        },
        addRadioButtonAnswer() {
            this.radioButtonAnswers.push({id: id++, text: '', truth: false})
        },
        removeRadioAnswer(answer) {
            this.radioButtonAnswers = this.radioButtonAnswers.filter((t) => t !== answer)
        },
        storeTestNameAndAddNewQuestion() {
            if (this.category === null) {
                alert('Пожалуйста, выберите категорию.')
                return null
            }
            if (this.testName === null) {
                alert('Пожалуйста, введите название теста.')
                return null
            }
            axios.post('/test/save-test-name', {
                test_id: this.testId,
                category_id: this.category.value,
                name: this.testName
            })
                .then((res) => {
                    this.testId = res.data.testId
                    this.testNameVisibility = false
                    this.finishVisibility = false
                    this.textAnswerVisibility = false
                    this.questionVisibility = true
                })
                .catch((error) => {
                    if (error.response) {
                        alert(error.response.data.message);
                    }
                });
        },
        addNewQuestion() {
            this.testNameVisibility = false
            this.finishVisibility = false
            this.textAnswerVisibility = false
            this.questionVisibility = true
        },
        storeQuestion() {
            if (this.question === null) {
                alert('Пожалуйста, введите вопрос')
                return null
            }
            axios.post('/test/save-test-question', {
                test_id: this.testId,
                question_id: this.questionId,
                test_question: this.question,
            })
                .then((res) => {
                    this.questionId = res.data.questionId
                    this.choosingAnswerOption = true
                    this.question = null
                })
                .catch((error) => {
                    if (error.response) {
                        alert(error.response.data.message);
                    }
                });
        },
        storeTextAnswer() {
            if (this.textAnswer === null) {
                alert('Пожоалуйста, введите ответ')
                return null
            }
            axios.post('/test/save-text-answer', {
                question_id: this.questionId,
                answer_id: this.answerId,
                answer: this.textAnswer,
            })
                .then((res) => {
                    this.answerId = res.data.answerId
                    this.textAnswerVisibility = false
                    this.finishVisibility = true
                    this.textAnswer = null
                })
                .catch((error) => {
                    if (error.response) {
                        alert(error.response.data.message);
                    }
                });
        },
        addTextAnswerAndStoreQuestion() {
            if (this.storeQuestion() === null) {
                return null
            }
            this.questionVisibility = false
            this.choosingAnswerOption = false
            this.textAnswerVisibility = true
        },
        showCheckBoxAnswerAndStoreQuestion() {
            if (this.storeQuestion() === null) {
                return null
            }
            this.questionVisibility = false
            this.choosingAnswerOption = false
            this.checkBoxAnswerVisibility = true
        },
        showRadioButtonAnswerAndStoreQuestion() {
            if (this.storeQuestion() === null) {
                return null
            }
            this.questionVisibility = false
            this.choosingAnswerOption = false
            this.radioButtonAnswerVisibility = true
        },
        completeTestCreation() {
            this.textAnswerVisibility = false
            location.href = `/test/${this.testId}`;
        },
    },
    watch: {
        radio(oldValue, newValue) {
            for (let key in this.radioButtonAnswers) {
                if (this.radioButtonAnswers.hasOwnProperty(key)) {
                    if (this.radioButtonAnswers[key]['id'] === this.radio) {
                        this.radioButtonAnswers[key]['truth'] = true
                    }
                }
            }
        }
    }
}
</script>

<style scoped>
.btn {
    @apply py-2 px-4 rounded;
}

.btn-blue {
    @apply bg-blue-500 text-white;
}

.btn-blue:hover {
    @apply bg-blue-700;
}
</style>
