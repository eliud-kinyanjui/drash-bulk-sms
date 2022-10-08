<template>
    <Head title="Contact Groups" />

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Contact Groups</h1>
                <Link :href="route('contactGroups.create')" class="btn btn-primary mb-3">
                    <i class="fa-sharp fa-solid fa-plus"></i>
                    Create Contact Group
                </Link>
                <div class="row">
                    <div class="col-12 col-md-4" v-for="group in contactGroups" :key="group.uuid">
                        <div class="card m-2">
                            <div class="card-body">
                                <div class="text-end">
                                    <Link :href="route('contactGroups.edit', { contactGroupUuid: group.uuid })" class="card-link" title="Edit Group">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </Link>
                                    <Link :href="route('contactGroups.delete', { contactGroupUuid: group.uuid })" class="card-link text-danger" title="Delete Group">
                                        <i class="fa-solid fa-trash"></i>
                                    </Link>
                                </div>
                                <h1 class="mb-0">{{ group.name }}</h1>
                                <hr>
                                <p>0 Contacts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        contactGroups: Object
    }
}
</script>
