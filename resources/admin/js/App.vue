<template>
    <div>
        <v-idle @idle="inactiveUserAction" :wait="600" :duration="1800" hidden :loop="true"/>

        <div>
            <jb-nav/>
            <router-view/>
            <jb-footer/>
        </div>


    </div>
</template>

<script>



    import Footer from './components/Footer'
    import axios from "axios";
    import {mapActions, mapGetters} from "vuex";
    import AdminUserNav from "./components/navbar/AdminUserNav";


    export default {
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Jobs 233',
            // all titles will be injected into this template
            titleTemplate: '%s - Jobs 233'
        },
        data: function () {
            return {
                isInactive: false,
                userActivityThrottlerTimeout: null,
                userActivityTimeout: null,

            }
        },
        components: {
            jbNav: AdminUserNav,
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
</style>
