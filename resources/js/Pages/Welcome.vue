<template>
    <Head title="Welcome" />

    <div class="container">
        <div class="row vh-100 align-items-center">
            <div class="col-12 text-center">
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
