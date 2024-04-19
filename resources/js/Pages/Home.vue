<template>
    <Head title="Добро пожаловать" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Логин" />

                        <TextInput
                            id="email"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Пароль" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600">Запомнить</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Вход
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
import {Head, Link, useForm} from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    components: { Head, Link, useForm, Checkbox, InputError, InputLabel, PrimaryButton, TextInput },
    props: {
        canResetPassword: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    },
    data() {
        return {
            form: useForm({
                email: '',
                password: '',
                remember: false,
            }),
        }
    },
    methods: {
        submit () {
            this.form.post(route('login'), {
                onFinish: () => form.reset('password'),
            });
        }
    }
}
</script>
