<template>

    <Head title="Send Message" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <div class="text-center mt-5">
                    <h1>Send Message</h1>
                    <p>
                        to <Link :href="route('contactGroups.show', { contactGroupUuid: contactGroup.uuid })" class="text-decoration-none">{{ contactGroup.name }}</Link>
                        ({{ contactGroup.total_contacts }} contacts)
                    </p>
                </div>
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea rows="5" id="message" name="message" class="form-control" placeholder="Enter your message here..." v-model="form.message" autofocus></textarea>
                        <span v-if="form.errors.message" v-text="form.errors.message" class="text-danger text-sm"></span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        contactGroup: Object
    },

    data() {
        return {
            form: this.$inertia.form({
                message: '',
            })
        };
    },

    methods: {
        submit() {
            this.form.post(route('contactGroups.messages.store', { contactGroupUuid:  this.contactGroup.uuid }));
        }
    }
};
</script>
