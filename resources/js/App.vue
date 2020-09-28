<template>
    <div>
        <div >
            <jb-nav/>
            <router-view/>
            <jb-footer/>
        </div>

<!--        <div v-if="!$auth.ready()">-->
<!--            Loading ...-->
<!--        </div>-->
    </div>
</template>

<script>

    import Nav from './components/navbar/Nav'
   import Footer from './components/Footer'

    export default {

        data: function () {
            return {
               // user: this.$auth.user()
            }
        },
        components: {
           jbNav: Nav,
           jbFooter: Footer,
        }

    }
</script>

<style lang="scss">
    @import "../sass/jbmain";
    @import "../sass/quotes";
</style>
