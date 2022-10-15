<template>
    <Head title="Payments" />

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Payments</h1>
                <div v-if="flash.status" class="alert alert-dismissible fade show" :class="flash.status.type" role="alert">
                    {{ flash.status.message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <Link :href="route('payments.create')" class="btn btn-primary mb-3">
                    <i class="fa-sharp fa-solid fa-plus"></i>
                    Create Payment
                </Link>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Receipt #</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(payment, index) in payments" :key="payment.id">
                            <th scope="row">{{ ++index }}</th>
                            <td>{{ payment.receipt }}</td>
                            <td>{{ payment.phone}}</td>
                            <td>KES {{ payment.amount}}</td>
                            <td>{{ payment.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        flash: Object,
        payments: Object,
    }
};
</script>
