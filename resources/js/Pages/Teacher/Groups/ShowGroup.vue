<template>
    <Layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h6>Список учеников класса {{ group.name }} </h6>
                    </div>
                    <div v-for="student in students"
                         class="px-6 mb-4 text-gray-900 dark:text-gray-100">
                        <Link :href="route('show.student', student.id)">{{ student.first_name }} {{ student.last_name }}</Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900 dark:text-gray-100">
                        <q-card-section>
                            <q-card-actions align="left">
                                <AddStudent :group_id = group.id></AddStudent>
                                <DeleteGroup :group_id = group.id></DeleteGroup>
                                <RenameGroup :group_id = group.id />
                                <ExportStudentsToPdf :group_id = group.id />
                            </q-card-actions>
                        </q-card-section>
                    </div>
                </div>
            </div>
        </div>

    </Layout>
</template>

<script>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import AddStudent from '@/Pages/Teacher/Groups/Partials/AddStudent.vue';
import DeleteGroup from "@/Pages/Teacher/Groups/Partials/DeleteGroup.vue";
import ExportStudentsToPdf from "@/Pages/Teacher/Groups/Partials/ExportStudentsToPdf.vue";
import RenameGroup from "@/Pages/Teacher/Groups/Partials/RenameGroup.vue";

export default {
    name: "ShowGroup",
    components: {ExportStudentsToPdf, Layout, AddStudent, DeleteGroup, Link, RenameGroup },
    props: {
        group: Object,
        students: Object
    }
}
</script>

<style scoped>

</style>
