<template>
    <header class="bg-black pt-3">
        <div class="container  pb-3">
            <b-navbar spaced transparent>


                <template slot="brand">
                    <router-link to="/"><img src="/images/logowhite.png" alt="Jobs 233 logo"></router-link>
                </template>
                <template slot="start">
                    <b-navbar-item>
                        <router-link :to="{name:'HowItWorks'}">How it Works</router-link>
                    </b-navbar-item>
                    <b-navbar-item>
                        <router-link :to="{name:'Projects'}">Browse Projects</router-link>
                    </b-navbar-item>
                    <template v-if="profileType ==='hire' || profileType ==='work&hire'">
                        <b-navbar-item>
                            <router-link to="#" class="button is-outlined is-primary">Hire</router-link>
                        </b-navbar-item>
                    </template>

                    <template v-if="profileType ==='work' || profileType ==='work&hire'">
                        <b-navbar-item class="button is-outlined is-primary">
                            <router-link to="#" class=" button bg-orange ">Work</router-link>
                        </b-navbar-item>
                    </template>

                </template>

                <template slot="end">


                    <div class=" nav-item-special">

                        <div>

                            <div class="jb-profile-btn-image">

                                <img class="is-rounded" style="border-radius: 50%" :src="user.profile.picture"/>
                            </div>
                            <div class="jb-profile-btn-name">
                                <span class="t-white t-meri">{{user.name}}
                                    <b-icon icon="caret-down-fill"/>
                                </span>
                            </div>
                        </div>

                        <div class="jb-hover-dropdown-wrapper">

                            <div class="container-fluid  p-0">
                                <div class="row w-100">
                                    <div class="col-6 col-md-6">
                                        <div class="links text-left">
                                            <router-link class="" :to="{name:'Messages'}"><i
                                                class="fas fa-envelope"></i> Messages
                                            </router-link>
                                            <a class="" href="#"><i class="fas fa-bell"></i> Notifications</a>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <div class="links text-right">
                                            <router-link to="/dashboard">Dashboard</router-link>
                                            <router-link class="" :to="{name:'EditProfile'}"><i
                                                class="fas fa-user"></i>
                                                My Profile
                                            </router-link>
                                            <a class="" href="#">Accounts & Settings</a>
                                            <a class="" href="" @click.prevent="logout">Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </template>

            </b-navbar>
        </div>

        <div class="jb-dash-nav bg-ash">
            <div class="container">
                <div class="jb-dash-links">
                    <router-link :to="{name:'Dashboard'}" class="jb-dash-link t-white ">My Dashboard</router-link>

                    <template v-if="profileType ==='hire' || profileType ==='work&hire'">
                        <router-link :to="{name:'Projects',query:{owner:'me'}}" href="#" class="jb-dash-link t-white ">
                            My Projects
                        </router-link>

                    </template>
                    <template v-if="profileType ==='work' || profileType ==='work&hire'">
                        <router-link :to="{name:'Projects',query:{assigned_to:'me'}}" href="#"
                                     class="jb-dash-link t-white ">
                            My Assigned Projects
                        </router-link>
                    </template>

                    <a href="#" class="jb-dash-link t-white ">Wallet</a>
                    <router-link :to="{name:'Messages'}" class="jb-dash-link t-white ">Messages</router-link>
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
                this.logOut();

                this.$router.push('/login');
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
