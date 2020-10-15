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
    import {mapGetters} from "vuex";

    export default {
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Jobs233',
            // all titles will be injected into this template
            titleTemplate: '%s - Jobs233'
        },
        data: function () {
            return {
                // user: this.$auth.user()
            }
        },
        components: {
            jbNav: Nav,
            jbFooter: Footer,
        },

        created() {

            if (this.authenticated) {
                Echo.join('jobs233_ymiutkyihzrihztnzwar')
                    .here(e => {

                    })
                    .listen('UserOnline', (e) => {
                        console.log( e.user);
                    })
                    .listen('UserOffline', (e) => {
                        console.log (e.user);
                    });
            }

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
    @import "../sass/jbmain";
    @import "../sass/quotes";
</style>
