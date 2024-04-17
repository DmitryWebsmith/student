<template>
    <div v-show="testNameVisibility">
        <label>Название теста</label>
        <input v-model="testName" type="text" class="mt-1 block w-full"/>
    </div>

    <div class="mt-6" v-show="addQuestionButtonVisibility">
        <button
            @click="addNewQuestion"
            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
            Добавить вопрос
        </button>
    </div>

    <div class="mt-6" v-show="questionVisibility">
        <label>Вопрос</label>
        <input v-model="question" type="text" class="mt-1 block w-full"/>
    </div>

    <div class="mt-6" v-show="choosingAnswerOption">
        <label>Добавить Ответ. Возможные варианты ответа: текстовое поле, одиночный выбор, множественный
            выбор</label><br><br>
        <button
            @click="addTextAnswer"
            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
            Текстовое поле
        </button>
        &nbsp
        <button
            @click="showRadioButtonAnswer"
            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
            Одиночный выбор
        </button>
        &nbsp
        <button
            @click="showCheckBoxAnswer"
            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
            Множественный выбор
        </button>
        &nbsp
    </div>

    <div class="mt-6" v-show="textAnswerVisibility">
        <label>Ответ</label>
        <input v-model="textAnswer" type="text" class="mt-1 block w-full"/>
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
                    <input type="radio" v-model="answer.truth">
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
        </button>&nbsp
        <button
            @click="addNewQuestion"
            class="bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded btn btn-blue">
            Добавить новый вопрос
        </button>
    </div>

</template>

<script>
let id = 0
export default {
    name: "AddComponent",
    data() {
        return {
            testId: 1,
            questionId: 1,
            answerId: 1,
            testName: null,
            question: null,
            textAnswer: null,
            checkBoxAnswers: [
                { id: id++, text: '', truth: true },
                { id: id++, text: '', truth: false },
                { id: id++, text: '', truth: false },
            ],
            radioButtonAnswers: [
                { id: id++, text: '', truth: true },
                { id: id++, text: '', truth: false },
                { id: id++, text: '', truth: false },
            ],
            addQuestionButtonVisibility: false,
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
        postMultipleAnswer(type) {
            let data
            if (type === 'checkbox') {
                data = {
                    question_id: this.questionId,
                    type: type,
                    answers: this.checkBoxAnswers,
                }
            }
            if (type === 'radiobutton') {
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
            this.checkBoxAnswers.push({ id: id++, text: '', truth: false })
        },
        removeCheckBoxAnswer(answer) {
            this.checkBoxAnswers = this.checkBoxAnswers.filter((t) => t !== answer)
        },
        addRadioButtonAnswer() {
            this.radioButtonAnswers.push({ id: id++, text: '', truth: false })
        },
        removeRadioAnswer(answer) {
            this.radioButtonAnswers = this.radioButtonAnswers.filter((t) => t !== answer)
        },
        addNewQuestion() {
            this.testNameVisibility = false
            this.addQuestionButtonVisibility = false
            this.finishVisibility = false
            this.textAnswerVisibility = false
            this.questionVisibility = true
        },
        addTextAnswer() {
            this.questionVisibility = false
            this.choosingAnswerOption = false
            this.textAnswerVisibility = true
        },
        showCheckBoxAnswer() {
            this.questionVisibility = false
            this.choosingAnswerOption = false
            this.checkBoxAnswerVisibility = true
        },
        showRadioButtonAnswer() {
            this.questionVisibility = false
            this.choosingAnswerOption = false
            this.radioButtonAnswerVisibility = true
        },
        completeTestElement(testElement, elementId) {
            axios.post('/test/complete-test-element', {
                test_element: testElement,
                element_id: elementId
            })
                .then((res) => {
                    if (testElement === 'question') {
                        this.question = null
                    }
                    if (testElement === 'answer') {
                        this.textAnswer = null
                    }
                })
                .catch((error) => {
                    if (error.response) {
                        alert(error.response.data.message);
                    }
                });
        },
        completeTestCreation() {
            this.textAnswerVisibility = false
            location.href = `/test/${this.testId}`;
        },
    },
    watch: {
        testNameVisibility(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.completeTestElement('test', this.testId)
            }
        },
        questionVisibility(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.completeTestElement('question', this.questionId)
            }
        },
        textAnswerVisibility(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.completeTestElement('answer', this.answerId)
            }
        },
        testName(newValue, oldValue) {
            if (newValue.length === 0) {
                this.addQuestionButtonVisibility = false;
            }
            if (newValue !== oldValue && newValue.length > 0) {
                axios.post('/test/save-test-name', {
                    test_id: this.testId,
                    test_name: this.testName
                })
                    .then((res) => {
                        this.testId = res.data.testId
                        this.addQuestionButtonVisibility = true
                    })
                    .catch((error) => {
                        if (error.response) {
                            alert(error.response.data.message);
                        }
                    });
            }
        },
        question(newValue, oldValue) {
            if (newValue !== null && newValue.length === 0) {
                this.choosingAnswerOption = false;
            }
            if (newValue !== oldValue && newValue !== null && newValue.length > 0) {
                axios.post('/test/save-test-question', {
                    test_id: this.testId,
                    question_id: this.questionId,
                    test_question: this.question,
                })
                    .then((res) => {
                        this.questionId = res.data.questionId
                        this.choosingAnswerOption = true;
                    })
                    .catch((error) => {
                        if (error.response) {
                            alert(error.response.data.message);
                        }
                    });
            }
        },
        textAnswer(newValue, oldValue) {
            if (newValue !== null && newValue.length > 0) {
                this.finishVisibility = true;
            } else {
                this.finishVisibility = false;
            }
            if (newValue !== oldValue && newValue !== null && newValue.length > 0) {
                axios.post('/test/save-text-answer', {
                    question_id: this.questionId,
                    answer_id: this.answerId,
                    answer: this.textAnswer,
                })
                    .then((res) => {
                        this.answerId = res.data.answerId
                    })
                    .catch((error) => {
                        if (error.response) {
                            alert(error.response.data.message);
                        }
                    });
            }
        },
    },
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
