<template>
    <Head title="Message Details" />

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h1>Message Details</h1>
                <div class="row">
                    <div class="col-6">
                        <p>Message: <br> <b><i>{{ message.message }}</i></b></p>
                    </div>
                    <div class="col-6">
                        <p>
                            Summary: <b>{{ message.at_response }}</b>
                            <br>
                            Contact Group: <Link :href="route('contactGroups.show', { contactGroupUuid: message.contact_group.uuid })" class="text-decoration-none">{{ message.contact_group.name }}</Link>
                        </p>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Number</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(detail, index) in message.message_details" :key="detail.id">
                            <th scope="row">{{ ++index }}</th>
                            <td>{{ detail.at_number }}</td>
                            <td>{{ detail.at_cost}}</td>
                            <td>{{ detail.at_status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: Object,
    }
};
</script>
