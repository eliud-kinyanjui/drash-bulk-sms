<template>
    <Head title="Delete Contact Group" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <BackLink />
                <div class="text-center">
                    <h1>Delete Contact Group?</h1>
                    <p>Name: <b>{{ contactGroup.name }}</b></p>
                </div>
                <form @submit.prevent="submit">
                    <button type="submit" class="btn btn-danger w-100" :disabled="form.processing">Delete Contact Group</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import BackLink from './Shared/BackLink.vue';

export default {
    components: { BackLink },

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
