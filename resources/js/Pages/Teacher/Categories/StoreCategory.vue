<template>
    <div class="q-pa-md q-gutter-sm">
        <q-btn color="primary" label="Добавить категорию" @click="show"/>
    </div>
    <q-dialog ref="dialog">
        <q-card class="q-dialog-plugin">
            <q-card-section>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Добавить категорию
                </h2>

                <form @submit.prevent="submit">
                    <input v-model="form.name" class="mt-6 block w-full" placeholder="Название категории"/>
                    <InputError class="mt-2" :message="form.errors.name" />
                    <q-card-actions align="right">
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
    components: {InputError},
    mounted() {
        this.form = useForm({
            name: ''
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
            this.form.post(route('store.category'), {
                onFinish: () => this.form.reset('name'),
                onSuccess: () => this.onCloseClick()
            });
        }

    }
}
</script>
