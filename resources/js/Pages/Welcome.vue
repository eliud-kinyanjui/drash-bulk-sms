<template>
    <Head title="Welcome" />

    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="py-5"></div>
                <div class="py-5"></div>
                <h1>Welcome to {{ env.APP_NAME }}</h1>
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
