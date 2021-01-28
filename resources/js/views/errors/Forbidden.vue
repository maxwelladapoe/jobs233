<template>

    <div class="jb-main-section-wrapper ">

        <div class="section has-text-centered ">
            <div class="container">
                <p class="t-1 t-bold">403</p>
                <p class="t-bold t-3">Access Denied</p>
                <p class="">Sorry, you do not have the permission to access this page</p>
                <p class="mb-5">If you feel this is a mistake please contact <a href="mailto:support@jobs233.com">
                    support</a>
                    </p>

                <router-link to="/" >
                    <b-button type="is-primary">Go Home</b-button>
                </router-link>
            </div>

        </div>


    </div>
</template>

<script>
    export default {

        name: "Forbidden",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: '403 Forbidden',

        },
    }
</script>

<style scoped>

</style>
