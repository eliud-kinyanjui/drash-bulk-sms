<template>
    <Head title="View Contact Group" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1>Contacts in {{ contactGroup.name }}</h1>
                <Link :href="route('contactGroups.contacts.create', { contactGroupUuid: contactGroup.uuid })" class="btn btn-primary">
                    <i class="fa-sharp fa-solid fa-plus"></i>
                    Add Contact
                </Link>
                <div class="row mt-3">
                    <div class="col-12 col-md-3" v-for="contact in contacts" :key="contact.uuid">
                        <div class="card m-2">
                            <div class="card-body">
                                <h3>{{ contact.name }}</h3>
                                <p>{{ contact.phone }}</p>
                            </div>
                            <div class="card-footer text-end">
                                <Link :href="route('contactGroups.contacts.edit', { contactGroupUuid: contactGroup.uuid, contactUuid: contact.uuid })" class="card-link" title="Edit Contact">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </Link>
                                <Link :href="route('contactGroups.contacts.delete', { contactGroupUuid: contactGroup.uuid, contactUuid: contact.uuid })" class="card-link text-danger" title="Delete Contact">
                                    <i class="fa-solid fa-trash"></i>
                                </Link>
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
        contactGroup: Object,
        contacts: Object,
    }
};
</script>
