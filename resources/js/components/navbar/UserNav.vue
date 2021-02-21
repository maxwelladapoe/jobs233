<template>
    <header class="bg-black pt-3">
        <div class="container  pb-3">
            <b-navbar type="is-black" spaced class="user-nav">


                <template slot="brand">
                    <b-navbar-item tag="router-link" to="/dashboard">
                        <img src="/images/logowhite.png" alt="Jobs 233 logo">
                    </b-navbar-item>
                </template>
                <template slot="start">
                    <b-navbar-item tag="router-link" :to="{name:'HowItWorks'}">
                        How it Works
                    </b-navbar-item>
                    <b-navbar-item tag="router-link" :to="{name:'Projects'}">Browse Projects
                    </b-navbar-item>


                </template>

                <template slot="end">


                    <b-navbar-dropdown hoverable collapsible right boxed>

                        <template slot="label">
                            <div class="nav-item-special-label">
                                <template>
                                    <div class="jb-profile-btn-image">
                                        <b-image :rounded="true" :src="user.profile.picture"/>
                                    </div>
                                    <div class="jb-profile-btn-name">
                                <span class="t-meri ml-2">{{ user.name }}
                                </span>
                                    </div>
                                </template>

                            </div>
                        </template>


                        <b-navbar-item class="no-padding" tag="div">

                            <div class=" nav-item-special">
                                <section class="">
                                    <div class="columns is-multiline">
                                        <div class="column is-12 is-5-desktop">

                                            <b-navbar-item class=" has-text-left pl-0 pr-0"
                                                           tag="router-link" :to="{name:'Messages'}">
                                                <div style="width: 100%">
                                                    <span class="mr-2"><b-icon icon="forum" size="is-small"/> </span>
                                                    Messages
                                                </div>

                                            </b-navbar-item>

                                            <b-navbar-item tag="div"
                                                           class=" has-text-left pl-0 pr-0">
                                                <div style="width: 100%">
                                                <span class="mr-2">
                                                    <b-icon icon="bell" size="is-small"/>
                                                </span>
                                                    Notifications

                                                </div>
                                            </b-navbar-item>

                                        </div>

                                        <div class="column is-12 is-7-desktop">


                                            <b-navbar-item to="/dashboard"
                                                           class=" has-text-left-touch has-text-right pl-0 pr-0"
                                                           tag="router-link">
                                                <div style="width: 100%">
                                                           <span class="mr-2">
                                                    <b-icon icon="view-dashboard" size="is-small"/>
                                                </span>
                                                    Dashboard
                                                </div>

                                            </b-navbar-item>


                                            <b-navbar-item :to="{name:'EditProfile'}"
                                                           class=" has-text-left-touch has-text-right pl-0 pr-0"
                                                           tag="router-link">
                                                <div style="width: 100%">
                                                     <span class="mr-2">
                                                    <b-icon icon="account" size="is-small"/>
                                                </span>
                                                    My Profile
                                                </div>
                                            </b-navbar-item>


                                        </div>

                                        <div class="column is-12 ">

                                            <hr class=" mb-0">
                                            <b-navbar-item href="#" @click.prevent="logout"
                                                           class=" has-text-left-touch has-text-right pl-0 pr-0"
                                                           tag="a">
                                                <div style="width: 100%">
                                                     <span class="mr-2">
                                                    <b-icon icon="logout-variant" size="is-small"/>
                                                </span>
                                                    Logout
                                                </div>
                                            </b-navbar-item>

                                        </div>

                                    </div>
                                </section>

                            </div>


                        </b-navbar-item>

                    </b-navbar-dropdown>

                </template>

            </b-navbar>

        </div>

        <div class="jb-dash-nav bg-ash">

            <div class="section no-padding-margin-top-bottom">


                <div class="container">
                    <div class="jb-dash-links">

                        <div>
                            <router-link :to="{name:'Dashboard'}" class="jb-dash-link t-white ">
                                <span class=" jb-nav-link-icon"> <b-icon icon="view-dashboard" size="is-small"/> </span>
                                <span class="jb-nav-link-text">Dashboard</span>
                            </router-link>
                        </div>
                        <template v-if="profileType ==='hire' || profileType ==='work&hire'">

                            <div>
                                <router-link :to="{name:'Projects',query:{owner:'me'}}"
                                             class="jb-dash-link t-white ">
                                <span class=" jb-nav-link-icon"> <b-icon icon="briefcase-variant-outline"
                                                                         size="is-small"/>
                                </span> <span class="jb-nav-link-text">My Projects</span>
                                </router-link>
                            </div>

                            <div>
                                <router-link :to="{name:'Account'}"
                                             class="jb-dash-link t-white ">
                                <span class=" jb-nav-link-icon"> <b-icon icon="cash-multiple" size="is-small"/>
                                </span> <span class="jb-nav-link-text">Account</span>
                                </router-link>
                            </div>

                        </template>
                        <template v-if="profileType ==='work' || profileType ==='work&hire'">
                            <div>
                                <router-link :to="{name:'Projects',query:{assigned_to:'me'}}" href="#"
                                             class="jb-dash-link t-white ">
                                    <span class="jb-nav-link-icon"> <b-icon icon="briefcase-variant-outline"
                                                                            size="is-small"/> </span>
                                    <span class="jb-nav-link-text"> Assigned
                                    Projects</span>
                                </router-link>
                            </div>
                            <div>
                                <router-link :to="{name:'Wallet'}"
                                             class="jb-dash-link t-white ">
                                    <span class="jb-nav-link-icon"> <b-icon icon="cash-multiple"
                                                                            size="is-small"/> </span>
                                    <span class="jb-nav-link-text">Wallet</span>
                                </router-link>
                            </div>


                        </template>
                        <div>
                            <router-link :to="{name:'Messages'}" class="jb-dash-link t-white ">
                                <span class=" jb-nav-link-icon"> <b-icon icon="chat" size="is-small"/> </span>
                                <span class="jb-nav-link-text"> Messages</span>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
</template>

<script>

import {mapGetters, mapActions} from 'vuex';
import DashNav from "./DashNav";

export default {
    name: "user-nav",
    components: {DashNav},
    methods: {

        ...mapActions({
            logOut: 'auth/logOut'
        }),
        logout() {
            this.logOut().then(() => {
                this.$router.push('/login');
            });


        }
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            profileType: 'auth/profileType',
        })
    }
}
</script>

<style scoped>

</style>
