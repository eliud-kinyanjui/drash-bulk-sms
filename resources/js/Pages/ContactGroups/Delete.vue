<template>
    <Head title="Delete Contact Group" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class="text-center">
                    <h1 class="mt-5 text-danger">Delete Contact Group?</h1>
                    <h3>Name: <b>{{ contactGroup.name }}</b></h3>
                </div>
                <form @submit.prevent="submit">
                    <button type="submit" class="btn btn-danger w-100" :disabled="form.processing">Delete Contact Group</button>
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
            form: this.$inertia.form()
        };
    },

    methods: {
        submit() {
            this.form.delete(route('contactGroups.destroy', { contactGroupUuid: this.contactGroup.uuid}));
        }
    }
};
</script>
