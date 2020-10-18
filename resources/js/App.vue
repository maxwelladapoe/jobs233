<template>
    <div>
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

    const INACTIVE_USER_TIME_THRESHOLD = 3600000;
    const USER_ACTIVITY_THROTTLER_TIME = 900000;
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

            activateActivityTracker() {
                window.addEventListener("mousemove", this.resetUserActivityTimeout);
                window.addEventListener("scroll", this.resetUserActivityTimeout);
                window.addEventListener("keydown", this.resetUserActivityTimeout);
                window.addEventListener("resize", this.resetUserActivityTimeout);
            },
            resetUserActivityTimeout() {
                clearTimeout(this.userActivityTimeout);
                this.userActivityTimeout = setTimeout(() => {
                    this.inactiveUserAction();
                }, INACTIVE_USER_TIME_THRESHOLD);

            },
            userActivityThrottler() {
                if (!this.userActivityThrottlerTimeout) {
                    this.userActivityThrottlerTimeout = setTimeout(() => {
                        this.resetUserActivityTimeout();

                        clearTimeout(this.userActivityThrottlerTimeout);
                        this.userActivityThrottlerTimeout = null;
                    }, USER_ACTIVITY_THROTTLER_TIME);
                }
            },
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
            this.activateActivityTracker();
        },
        beforeDestroy() {
            window.removeEventListener("mousemove", this.userActivityThrottler);
            window.removeEventListener("scroll", this.userActivityThrottler);
            window.removeEventListener("keydown", this.userActivityThrottler);
            window.removeEventListener("resize", this.userActivityThrottler);

            clearTimeout(this.userActivityTimeout);
            clearTimeout(this.userActivityThrottlerTimeout);
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
