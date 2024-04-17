<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-gray-900 dark:text-gray-100">
                    Добавить задачу
                </div>
                <div class="p-3 text-gray-900 dark:text-gray-100">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Выбор теста</label>

                </div>


            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NewTaskComponent",
    props: ['tests'],
    mounted() {
        console.log(this.tests)
    },
    data() {
        return {
            dateTimeValue: null,
            selectTest: null,
            test: null,
            form: {
                name: '',
                region: '',
                date1: '',
                date2: '',
                delivery: false,
                type: [],
                resource: '',
                desc: '',
            }
        }
    },
    methods: {
        onSubmit() {
            console.log(this.form)
        }
    }
}
</script>

<style scoped>

</style>
