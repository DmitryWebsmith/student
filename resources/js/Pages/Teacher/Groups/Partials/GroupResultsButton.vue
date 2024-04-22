<template>
    <div class="q-pa-md q-gutter-sm">
        <form :action="route('show.group.results', {group_id: group_id})" method="get">
            <q-btn color="primary" label="Результаты класса" type="submit"/>
        </form>
    </div>
</template>

<script>
export default {
    name: "ExportStudentsToPdf",
    props: {
        group_id: Number
    }
}
</script>

<style scoped>

</style>
