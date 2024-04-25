<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>Данные ученика</h6>
                    </div>
                    <div class="px-6 py-2 text-gray-900 dark:text-gray-100">
                        ФИО: {{ student.first_name }} {{ student.last_name }}
                    </div>
                    <div class="px-6 py-2 text-gray-900 dark:text-gray-100">
                        Класс: <Link :href="route('show.group', student.group.id)">{{ student.group.name }}</Link>
                    </div>
                    <div class="px-6 py-2 text-gray-900 dark:text-gray-100">
                        Логин: {{ user.email }}
                    </div>
                    <div class="px-6 py-2 text-gray-900 dark:text-gray-100">
                        Пароль: {{ student.password }}
                    </div>
                    <div class="px-6 py-2 text-gray-900 dark:text-gray-100">
                        Ссылка для входа ученика в кабинет:
                        <q-btn class="glossy" color="teal" size="13px" label="Копировать" @click="copy"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <q-card-section>
                        <q-card-actions align="left">
                            <UpdateStudent
                                :student = student
                                :user = user>
                            </UpdateStudent>
                            <DeleteStudent :student_id = student.id></DeleteStudent>
                        </q-card-actions>
                    </q-card-section>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateStudent from "@/Pages/Teacher/Students/partials/UpdateStudent.vue";
import DeleteStudent from "@/Pages/Teacher/Students/partials/DeleteStudent.vue";
import { Link } from '@inertiajs/vue3';

export default {
    name: "ShowStudent",
    components: { Layout, UpdateStudent, DeleteStudent, Link },
    props: {
        student: Object,
        user: Object,
        url: String
    },
    data() {
        return {
            linkForAuth: this.url+'/login-by-link?email='+this.user.email+'&password='+this.student.password
        }
    },
    methods: {
        copy() {
            try {
                navigator.clipboard.writeText(this.linkForAuth)
            } catch (e) {
                throw e
            }
        }
    }
}
</script>

<style scoped>

</style>
