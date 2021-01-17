<template>
    <div>
        <v-idle @idle="inactiveUserAction" :wait="600" :duration="3600" hidden :loop="true"/>

        <div>
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
    import axios from "axios";
    import {mapActions, mapGetters} from "vuex";


    export default {
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Jobs233',
            // all titles will be injected into this template
            titleTemplate: '%s - Jobs233'
        },
        data: function () {
            return {
                isInactive: false,
                userActivityThrottlerTimeout: null,
                userActivityTimeout: null,

            }
        },
        components: {
            jbNav: Nav,
            jbFooter: Footer,
        },
        methods: {

            ...mapActions({
                logOut: 'auth/logOut',
                refresh: 'auth/refresh',
            }),



            inactiveUserAction() {

                //check if the session is still active
                this.refresh();

                //check if the authentication is still available
                if (!this.authenticated) {
                    this.logOut();
                    this.$router.push('/login');
                }

            }
        },


        created() {

            if (this.authenticated) {
                Echo.join('jobs233_ymiutkyihzrihztnzwar')
                    .here(e => {

                    })
                    .listen('UserOnline', (e) => {
                        // console.log(e.user);
                    })
                    .listen('UserOffline', (e) => {
                        //console.log(e.user);
                    });
            }

        },
        beforeMount() {

        },
        beforeDestroy() {

        },
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            }),

        },


    }
</script>

<style lang="scss">
    /*@import "../sass/jbmain";*/
    @import "../sass/quotes";
</style>
