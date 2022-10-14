<template>
    <Head title="Messages" />

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Messages</h1>
                <Link :href="route('messages.create')" class="btn btn-primary mb-3">
                    <i class="fa-regular fa-paper-plane"></i>
                    Send Message
                </Link>
                <div class="row">
                    <div class="col-12 col-md-4" v-for="message in messages" :key="message.uuid">
                        <div class="card border border-primary">
                            <div class="card-header">
                                {{ message.at_response }}
                                <br>
                                Contact Group:
                                <Link v-if="!message.contact_group.deleted_at" :href="route('contactGroups.show', { contactGroupUuid: message.contact_group.uuid })" class="text-decoration-none">{{ message.contact_group.name }}</Link>
                                <span v-else>{{ message.contact_group.name }}</span>
                            </div>
                            <div class="card-body">
                                <i>{{ message.message }}</i>
                            </div>
                            <div class="card-footer text-end">
                                <Link :href="route('messages.show', { messageUuid: message.uuid})" class="text-decoration-none">View Details</Link>
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
        messages: Object
    }
}
</script>
