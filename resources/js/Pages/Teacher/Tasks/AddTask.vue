<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>Добавить задачу</h6>
                    </div>
                    <div class="pl-6 py-2 text-gray-900 dark:text-gray-100">
                        <div class="q-pa-sm" style="max-width: 600px">
                            <div class="q-gutter-md">
                                <q-select outlined v-model="form.group" :options="groupOptions" label="Выбор класса"/>
                            </div>
                            <InputError class="mt-2" :message="form.errors.group" />
                        </div>
                        <div class="q-pa-sm" style="max-width: 600px">
                            <div class="q-gutter-md">
                                <q-select outlined v-model="category" :options="categoryOptions"
                                          label="Выбор категории"/>
                            </div>
                            <InputError class="mt-2" :message="form.errors.category" />
                        </div>
                        <div class="q-pa-sm" style="max-width: 600px">
                            <div class="q-gutter-md">
                                <q-select outlined v-model="form.test" :options="testOptions" label="Выбор теста"/>
                            </div>
                            <InputError class="mt-2" :message="form.errors.test" />
                        </div>
                        <div class="q-pa-sm" style="max-width: 600px">
                            <div class="py-2 text-gray-900 dark:text-gray-100">
                                Выбор даты и времени начала сдачи теста.
                                <template v-if="form.date_time_start !== ''">Выбрана дата {{ form.date_time_start }}</template>
                            </div>
                            <table>
                                <tr>
                                    <td>
                                        <div class="q-gutter-md row items-start">
                                            <q-date v-model="form.date_time_start" mask="YYYY-MM-DD HH:mm" color="purple"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="q-gutter-md row items-start">
                                            <q-time v-model="form.date_time_start" mask="YYYY-MM-DD HH:mm" color="purple"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <InputError class="mt-2" :message="form.errors.date_time_start" />
                        </div>
                        <div class="q-pa-sm" style="max-width: 600px">
                            <div class="py-2 text-gray-900 dark:text-gray-100">
                                Выбор даты и времени окончания сдачи теста.
                                <template v-if="form.date_time_end !== ''">Выбрана дата {{ form.date_time_end }}</template>
                            </div>
                            <table>
                                <tr>
                                    <td>
                                        <div class="q-gutter-md row items-start">
                                            <q-date v-model="form.date_time_end" mask="YYYY-MM-DD HH:mm" color="purple"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="q-gutter-md row items-start">
                                            <q-time v-model="form.date_time_end" mask="YYYY-MM-DD HH:mm" color="purple"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <InputError class="mt-2" :message="form.errors.date_time_end" />
                        </div>
                        <div class="q-pa-sm" style="max-width: 600px">
                            <div class="q-pa-md">
                                <q-badge color="secondary">
                                    Длительность сдачи теста: {{ form.duration }} минут
                                </q-badge>

                                <q-slider v-model="form.duration" :min="10" :max="60" color="green"/>
                                <InputError class="mt-2" :message="form.errors.duration" />
                            </div>
                        </div>
                        <div class="q-pa-sm" style="max-width: 600px">
                            <form @submit.prevent="submit">
                                <q-card-actions align="right">
                                    <q-btn color="primary" label="Сохранить" type="submit"/>
                                </q-card-actions>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';

export default {
    name: "AddTask",
    components: { Layout, InputError, useForm},
    props: {
        groups: Object,
        categories: Object,
        tests: Object,
    },
    mounted() {
        for (let key in this.groups) {
            this.groupOptions.push({
                label: this.groups[key]['name'],
                value: this.groups[key]['id'],
            })
        }
        for (let key in this.categories) {
            this.categoryOptions.push({
                label: this.categories[key]['name'],
                value: this.categories[key]['id'],
            })
        }
    },
    data() {
        return {
            form: useForm({
                group: '',
                category: '',
                test: '',
                date_time_start: '',
                date_time_end: '',
                duration: '',
            }),
            groupOptions: [],
            categoryOptions: [],
            testOptions: [],
            category: null,
        }
    },
    methods: {
        submit() {
            this.form.category = this.category
            this.form.post(route('store.task'), {})
        }
    },
    watch: {
        category(newValue, oldValue) {
            if (newValue !== oldValue) {
                axios.post('/get-tests-by-category', {category_id: newValue.value})
                    .then((res) => {
                        this.testOptions = []
                        for (let key in res.data.tests) {
                            this.testOptions.push({
                                label: res.data.tests[key]['name'],
                                value: res.data.tests[key]['id'],
                            })
                        }
                    })
                    .catch((errorMsg) => {
                        alert(errorMsg);
                    })
            }
        }
    }
}
</script>

<style scoped>

</style>
