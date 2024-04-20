<template>
    <Layout>
        <Head title="Кабинет учащегося" />
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 pb-3 pt-6 text-gray-900 dark:text-gray-100">
                        <h6>Здравствуй, {{ student.first_name }} {{ student.last_name }}</h6>
                    </div>
                    <div class="px-6 pb-3">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="px-6 text-gray-900 dark:text-gray-100">
                                    <h6>Список тестов</h6>
                                </div>

                                <div class="relative overflow-x-auto p-6">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Тест
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Действие
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Начало сдачи
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Окончание сдачи
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="Object.keys(tasks).length > 0">
                                                <tr v-for="task in tasks" :key="task.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td class="px-6 py-4">
                                                        {{ task.test.name }}
                                                    </td>
                                                    <template v-if="passedTest(task)">
                                                        <td class="px-6 py-4">
                                                            Тест пройден
                                                        </td>
                                                    </template>
                                                    <template v-if="!passedTest(task)">
                                                        <td class="px-6 py-4">
                                                            <q-btn
                                                                color="primary"
                                                                label="Пройти тест"
                                                                @click="passTest(task)"/>
                                                        </td>
                                                    </template>
                                                    <td class="px-6 py-4">
                                                        {{ task.start_time }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ task.end_time }}
                                                    </td>
                                                </tr>
                                            </template>
                                            <template v-if="Object.keys(tasks).length === 0">
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td class="px-6 py-4" colspan="4">
                                                        Нет доступных для сдачи тестов.
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedStudentLayout.vue'
import {Head, router} from '@inertiajs/vue3'
import { useQuasar } from 'quasar'

export default {
    name: "index",
    props: {
        student: Object,
        tasks: Object,
        current_time: String,
        message: String,
    },
    components: {Head, Layout },
    data () {
        return {
            $q: useQuasar(),
        }
    },
    mounted() {
        if (this.message !== null && this.message.length > 0) {
            this.showNotify(this.message)
        }
    },
    methods: {
        passedTest(task) {
            if (task.test_passed === null || task.test_passed === undefined) {
                return false
            }

            let testPassedList = task.test_passed

            for (let key in testPassedList) {
                if (testPassedList.hasOwnProperty(key)) {
                    let testPassed = testPassedList[key]
                    if (testPassed.hasOwnProperty('student_id') && testPassed.hasOwnProperty('task_id')) {
                        if (testPassed.student_id === this.student.id && testPassed.task_id === task.id) {
                            return true
                        }
                    }
                }
            }

            return false
        },
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
        passTest(task) {
            router.reload({})
            if (!this.isItTimeToPassTest(task)) {
                let message = "Тест можно пройти с "+task.start_time+" до "+task.end_time+". Текущее время "+this.current_time
                this.showNotify(message)
                return null
            }
            router.get(route('student.pass.test.index'),
                {
                    task_id: task.id,
                }
            )
        },
        isItTimeToPassTest(task) {
            let currentTime = (new Date(this.current_time)).getTime();
            let taskStartTime = (new Date(task.start_time)).getTime();
            let taskEndTime = (new Date(task.end_time)).getTime();

            if (currentTime >= taskStartTime && currentTime < taskEndTime) {
                return true
            }

            return false
        }
    }
}
</script>

<style scoped>

</style>
