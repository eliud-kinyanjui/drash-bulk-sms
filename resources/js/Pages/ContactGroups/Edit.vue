<template>
    <Head title="Edit Contact Group" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <BackLink />
                <h1 class="text-center">Edit Contact Group</h1>
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Enter Name" v-model="form.name" autofocus>
                        <span v-if="form.errors.name" v-text="form.errors.name" class="text-danger text-sm"></span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">Save Changes</button>
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
            form: this.$inertia.form({
                name: this.contactGroup.name,
            })
        };
    },

    methods: {
        submit() {
            this.form.patch(route('contactGroups.update', { contactGroupUuid: this.contactGroup.uuid}));
        }
    }
};
</script>
