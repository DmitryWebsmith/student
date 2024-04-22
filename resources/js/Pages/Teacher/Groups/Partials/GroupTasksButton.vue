<template>
    <div class="q-pa-md q-gutter-sm">
        <form :action="route('show.group.tasks', {group_id: group_id})" method="get">
            <q-btn color="primary" label="Задачи класса" type="submit"/>
        </form>
    </div>
</template>

<script>
export default {
    name: "GroupTasksButton",
    props: {
        group_id: Number
    }
}
</script>

<style scoped>

</style>
