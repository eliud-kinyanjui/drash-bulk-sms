<template>
    <Head title="Payments" />

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Payments</h1>
                <div v-if="flash.status" class="alert alert-dismissible fade show text-center" :class="flash.status.type" role="alert">
                    {{ flash.status.message }}
                </div>
                <DataTable
                    :data="tableData"
                    :options="{
                         'columnDefs': [{
                            'targets': [1, 4],
                            'orderable': false,
                        }]
                    }"
                    class="table"
                >
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Receipt #</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Amount</th>
                            <th scope="col">
                                <Link :href="route('payments.create')" class="btn btn-sm btn-primary">
                                <i class="fa-sharp fa-solid fa-plus"></i>
                                New Payment
                                </Link>
                            </th>
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
        auth: Object,
        payments: Object,
        flash: Object,
    },

    data() {
        return {
            tableData: [],
        };
    },

    created() {
        this.payments.forEach((value, index) => {
            this.tableData.push([
                ++index,
                value.receipt,
                value.phone,
                value.amount,
                `Received ${value.created_at}`,
            ]);
        });

        Echo.private(`users.${this.auth.user.uuid}`)
            .listen('MpesaCallbackSaved', (e) => {
                let payment = e.payment;

                this.payments.unshift(payment);

                this.flash.status = {
                    'type': 'alert-success',
                    'message': `Payment amount of KES ${payment.amount} received successfully from ${payment.phone}. Happy texting!`,
                };
            });
    }
};
</script>

<style>
@import 'bootstrap';
@import 'datatables.net-bs5';
</style>
