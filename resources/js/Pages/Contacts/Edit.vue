<template>

    <Head title="Edit Contact" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <div class="text-center mt-5">
                    <h1>Edit Contact</h1>
                    <p>in <Link :href="route('contactGroups.show', { contactGroupUuid: contactGroup.uuid })" class="text-decoration-none">{{ contactGroup.name }}</Link></p>
                </div>
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Enter Name" v-model="form.name" autofocus>
                        <span v-if="form.errors.name" v-text="form.errors.name" class="text-danger text-sm"></span>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Enter Phone" v-model="form.phone">
                        <span v-if="form.errors.phone" v-text="form.errors.phone" class="text-danger text-sm"></span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        contactGroup: Object,
        contact: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.contact.name,
                phone: this.contact.phone,
            })
        };
    },

    methods: {
        submit() {
            this.form.patch(route('contactGroups.contacts.update', {
                contactGroupUuid: this.contactGroup.uuid,
                contactUuid: this.contact.uuid,
            }));
        }
    }
};
</script>
