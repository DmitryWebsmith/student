<template>
    <div class="q-pa-md q-gutter-sm">
        <q-btn color="purple" label="Удалить категорию" @click="show"/>
    </div>
    <q-dialog ref="dialog">
        <q-card class="q-dialog-plugin">
            <q-card-section>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Пожалуйста, подтвердите удаление.
                </h3>

                <form @submit.prevent="submit">
                    <q-card-actions align="right">
                        <q-btn color="primary" label="Удалить" type="submit" />
                        <q-btn color="primary" label="Закрыть" @click="onCloseClick" />
                    </q-card-actions>
                </form>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script>
import { useForm } from '@inertiajs/vue3'

export default {
    props: {
        category_id: Number
    },
    mounted() {
        this.form = useForm({
            category_id: this.category_id
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
            this.form.delete(route('delete.category'), {
                onSuccess: () => this.onCloseClick()
            });
        }

    }
}
</script>
