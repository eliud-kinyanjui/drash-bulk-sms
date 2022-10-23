<template>
    <Head title="Home" />

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <div class="py-5"></div>
                <h1>Welcome home, {{ auth.user.firstName }}.</h1>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-3">
                <div class="card border border-dark">
                    <div class="card-body">
                        <div class="text-center">
                            Contact Groups <br>
                            <span class="display-6">{{ stats.contactGroups }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border border-dark">
                    <div class="card-body">
                        <div class="text-center">
                            Messages <br>
                            <span class="display-6">{{ stats.messages }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class="text-center">
                            Credit <br>
                            <span class="display-6">KES {{ auth.user.credit }}</span>
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
        auth: Object,
        stats: Object,
    }
}
</script>
