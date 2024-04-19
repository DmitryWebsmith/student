<template>
    <div class="q-pa-md q-gutter-sm">
        <q-btn color="primary" label="Добавить ученика" @click="show"/>
    </div>
    <q-dialog ref="dialog">
        <q-card class="q-dialog-plugin">
            <q-card-section>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Форма добавления ученика в класс
                </h2>

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <label for="first_name">Имя:</label>
                        <input id="first_name" v-model="first_name" class="mt-2 block w-full" />
                        <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>

                    <div class="mt-4">
                        <label for="last_name">Фамилия:</label>
                        <input id="last_name" v-model="last_name" class="mt-2 block w-full" />
                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>

                    <div class="mt-4">
                        <label for="email">Login:</label>
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

export default {
    components: { InputError },
    props: {
        group_id: Number
    },
    mounted() {
        this.form = useForm({
            first_name: '',
            last_name: '',
            email: '',
            password: this.generatePassword(6),
            group_id: this.group_id,
        })
    },
    data() {
        return {
            form: null,
            first_name: null,
            last_name: null,
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
            this.form.post(route('store.student'), {
                onFinish: () => {
                    this.first_name = '';
                    this.last_name = '';
                    this.form.reset('first_name', 'last_name', 'email', 'password')
                    this.onCloseClick()
                }
            });
        },
        fillOutEmail(text) {
            axios.post(route('transliterate'), {text: text})
                .then((res) => {
                    this.form.email = res.data.transliterated_text
                })
                .catch((errorMsg) => {
                    alert(errorMsg);
                })
        },
        generatePassword(len) {
            let chars = 'abdehkmnpswxz123456789';
            let str = '';
            for (let i = 0; i < len; i++) {
                let pos = Math.floor(Math.random() * chars.length);
                str += chars.substring(pos,pos+1);
            }
            return str;
        }
    },
    watch: {
        first_name(oldValue, newValue) {
            this.form.first_name = this.first_name

            if (newValue === null) {
                return 0
            }

            let text = ''
            if (this.last_name !== null && this.last_name.length > 0) {
                text = this.first_name + '-' + this.last_name //+ '@excellent-student.ru'
            } else {
                text = this.first_name //+ '@excellent-student.ru'
            }

            this.fillOutEmail(text)
        },
        last_name(oldValue, newValue) {
            this.form.last_name = this.last_name

            if (newValue === null) {
                return 0
            }

            let text = ''
            if (this.first_name !== null && this.first_name.length > 0) {
                text = this.first_name + '-' + this.last_name //+ '@excellent-student.ru'
            } else {
                text = this.last_name //+ '@excellent-student.ru'
            }

            this.fillOutEmail(text)
        }
    }
}
</script>
