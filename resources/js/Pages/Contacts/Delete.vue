<template>
    <Head title="Delete Contact" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class="text-center mt-5">
                    <h1>Delete Contact?</h1>
                    <p>in
                        <Link :href="route('contactGroups.show', { contactGroupUuid: contactGroup.uuid })" class="text-decoration-none">
                            {{ contactGroup.name }}
                        </Link>
                    </p>
                    <p>Name: <b>{{ contact.name }}</b></p>
                    <p>Phone: <b>{{ contact.phone }}</b></p>
                </div>
                <form @submit.prevent="submit">
                    <button type="submit" class="btn btn-danger w-100" :disabled="form.processing">Delete Contact</button>
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
            form: this.$inertia.form()
        };
    },

    methods: {
        submit() {
            this.form.delete(route('contactGroups.contacts.destroy', {
                contactGroupUuid: this.contactGroup.uuid,
                contactUuid: this.contact.uuid,
            }));
        }
    }
};
</script>
