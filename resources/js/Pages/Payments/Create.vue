<template>
    <Head title="New Payment" />

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-4">
                <h1 class="text-center">New Payment</h1>
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input id="amount" name="amount" type="number" class="form-control" placeholder="Enter Amount" v-model="form.amount" autofocus>
                        <span v-if="form.errors.amount" v-text="form.errors.amount" class="text-danger text-sm"></span>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Enter Phone" v-model="form.phone">
                        <span v-if="form.errors.phone" v-text="form.errors.phone" class="text-danger text-sm"></span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">Send Payment Request</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: this.$inertia.form({
                amount: '',
                phone: '',
            })
        };
    },

    methods: {
        submit() {
            this.form.post(route('payments.store'));
        }
    }
};
</script>
