<template>
    <header>

        <nav class="navbar navbar-expand-lg bg-black">
            <div class="container">

                <a class="navbar-brand" href="/"><img src="/images/logowhite.png" alt="Jobs 233 logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item">
                            <a class="nav-link " href="#">How it Works</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item nav-item-special bg-orange">
                            <div class="jb-profile-btn-image">
                                <img class="rounded-circle" :src="user.profile.picture" />
                            </div>
                            <div class="jb-profile-btn-name">
                                <p class="t-mont t-bold t-white">{{user.name}} <b-icon icon="caret-down-fill
"/></p>

                            </div>

                            <div class="jb-hover-dropdown-wrapper">

                                <div class="row">


                                    <div class="col-md-6">
                                        <div class="links text-left">
                                            <a class="" href="#"><i class="fas fa-envelope"></i> Messages</a>
                                            <a class="" href="#"><i class="fas fa-bell"></i> Notifications</a>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="links text-right">
                                            <router-link to="/dashboard">Dashboard</router-link>
                                            <a class="" href="#"><i class="fas fa-user"></i> My Profile</a>
                                            <a class="" href="#">Accounts & Settings</a>
                                            <a class="" href="" @click.prevent="logout">Logout</a>
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
            logout() {
               // this.$auth.logout()
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
