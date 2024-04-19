<template>
    <div class="q-pa-md q-gutter-sm">
        <q-btn color="primary" label="Редактировать данные ученика" @click="show"/>
    </div>
    <q-dialog ref="dialog">
        <q-card class="q-dialog-plugin">
            <q-card-section>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Форма обновления данных ученика
                </h2>

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <label for="first_name">Имя:</label>
                        <input id="first_name" v-model="form.first_name" class="mt-2 block w-full" />
                        <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>

                    <div class="mt-4">
                        <label for="last_name">Фамилия:</label>
                        <input id="last_name" v-model="form.last_name" class="mt-2 block w-full" />
                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>

                    <div class="mt-4">
                        <label for="email">Email:</label>
                        <input id="email" v-model="form.email" class="mt-2 block w-full" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <label for="password">Пароль:</label>
                        <input id="password" v-model="form.password" class="mt-2 block w-full" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <q-card-actions align="right" class="mt-4">
                        <q-btn color="primary" label="Сохранить" type="submit" />
                        <q-btn color="primary" label="Закрыть" @click="onCloseClick" />
                    </q-card-actions>
                </form>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script>
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: { InputError },
    props: {
        student: Object,
        user: Object
    },
    mounted() {
        this.form = useForm({
            first_name: this.student.first_name,
            last_name: this.student.last_name,
            email: this.user.email,
            password: this.student.password,
            student_id: this.student.id,
        });
    },
    data() {
        return {
            form: null
        }
    },
    methods: {
        show () {
            this.$refs.dialog.show()
        },
        onCloseClick () {
            this.$refs.dialog.hide()
        },
        submit() {
            this.form.patch(route('update.student'), {
                onSuccess: () => {
                    Inertia.get(route('show.student', this.student.id))
                    this.onCloseClick()
                    this.form.reset('first_name', 'last_name', 'email', 'password')
                }
            });
        }

    }
}
</script>
