<template>
    <Head title="Send Message" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <h1 class="text-center mt-5">Send Message</h1>
                <div v-if="flash.status" class="alert alert-dismissible fade show text-center" :class="flash.status.type" role="alert">
                    {{ flash.status.message }}
                </div>
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label for="contact_group" class="form-label">Contact Group</label>
                        <select id="contact_group" name="contact_group" class="form-control" v-model="form.contact_group">
                            <option value="">Select</option>
                            <template v-for="group in contactGroups" :key="group.uuid">
                                <option :value="group.id" v-if="group.total_contacts">{{ group.name }} ({{ group.total_contacts }} contacts)</option>
                            </template>
                        </select>
                        <span v-if="form.errors.contact_group" v-text="form.errors.contact_group" class="text-danger text-sm"></span>
                    </div>
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
        flash: Object,
        contactGroups: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                contact_group: '',
                message: '',
            })
        };
    },

    methods: {
        submit() {
            this.form.post(route('messages.store'));
        }
    }
};
</script>
