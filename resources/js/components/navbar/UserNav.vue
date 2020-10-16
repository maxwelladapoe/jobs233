<template>
    <header>

        <nav class="navbar navbar-expand-lg bg-black navbar-dark">
            <div class="container pt-3  px-3 p-lg-0">

                <a class="navbar-brand" href="/"><img src="/images/logowhite.png" alt="Jobs 233 logo"></a>
                <button class="navbar-toggler " type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse bg-black " id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item">
                            <router-link class="nav-link text-white" :to="{name:'HowItWorks'}">How it Works
                            </router-link>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item nav-item-special">

                            <div>

                                <div class="jb-profile-btn-image">
                                    <img class="rounded-circle" :src="user.profile.picture"/>
                                </div>
                                <div class="jb-profile-btn-name">
                                <span class="t-mont t-bold t-white">{{user.name}}
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
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>
</template>

<script>

    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: "user-nav",


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
            })
        }
    }
</script>

<style scoped>

</style>
