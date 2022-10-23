<template>
    <Head title="Welcome" />

    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-2 fw-bold mb-4">Bulk SMS, Simplified.</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">
                Simply create your contact group(s) and add some contacts,
                <br>
                load your credit and send your SMS!
            </p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <Link :href="route('register')" class="btn btn-primary btn-lg px-4 gap-3">Get started for free</Link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        env: Object
    }
}
</script>
