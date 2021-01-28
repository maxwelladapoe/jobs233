<template>

    <div class="jb-main-section-wrapper ">

        <div class="section has-text-centered ">
            <div class="container">
                <p class="t-1 t-bold t-orange">OOPS!</p>
                <p class="t-bold t-3"> 404 - Page Not Found</p>
                <p class="mb-5">We are sorry for the inconvenience. <br> The page you are trying to access  does not
                    exist or has been deleted</p>

                <router-link to="/" >
                    <b-button type="is-primary">Go Back Home</b-button>
                </router-link>
            </div>

        </div>


    </div>
</template>

<script>
    export default {

        name: "404 Not Found",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: '403 Forbidden',

        },
    }
</script>

<style scoped>

</style>
