<template>
    <Head title="Message Details" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h1>Message Details</h1>
                <div class="row">
                    <div class="col-6">
                        <p>Message: <br> <b><i>{{ message.message }}</i></b></p>
                    </div>
                    <div class="col-6">
                        <p>
                            Sent to {{ message.total_sent }} contacts
                            in
                            <Link v-if="!message.contact_group.deleted_at" :href="route('contactGroups.show', { contactGroupUuid: message.contact_group.uuid })" class="text-decoration-none">{{ message.contact_group.name }}</Link>
                            <span v-else>{{ message.contact_group.name }}</span>
                            <br>
                            Cost: KES {{ message.total_cost }}
                            <br>
                            <small>Sent {{ message.created_at }}</small>
                        </p>
                    </div>
                </div>
                <DataTable :data="tableData" class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Number</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from 'datatables.net-vue3';
import DataTableBs5 from 'datatables.net-bs5';

DataTable.use(DataTableBs5);

export default {
    components: {
        DataTable,
    },

    props: {
        message: Object,
    },

    data() {
        return {
            tableData: [],
        };
    },

    created() {
        this.message.message_details.forEach((value, index) => {
            this.tableData.push([
                ++index,
                value.at_number,
                value.at_cost,
                value.at_status,
            ]);
        });
    }
};
</script>

<style scoped>
@import 'datatables.net-bs5';
</style>
