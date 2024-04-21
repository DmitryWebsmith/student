<template>
    <div class="q-pa-md q-gutter-sm">
        <form :action="route('export.to.pdf.group', {group_id: group_id})" method="get">
            <q-btn color="primary" label="PDF" type="submit"/>
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
