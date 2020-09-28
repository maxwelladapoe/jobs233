<template>
    <div class="jb-notifications bg-ash-light shadow">
        <div class="jb-notifications-header b-bottom">
            <p class="t-mont t-bold">
                Notifications
            </p>
            <div class="btn bg-orange">Mark All As Read</div>


        </div>

        <div class="js-notifications-wrapper">
            <div class="jb-notification">
                <div class="container">
                    <div class="row">
                        <div class="col-md-1">
                            <i class="fa fa-envelope t-orange icon"></i>
                        </div>
                        <div class="col-md-11">
                            <p class="title t-bold">You have a new unread message </p>
                            <p class="from t-mont">From <span class="t-bold">Maxwell Adapoe</span>
                            </p>
                            <p class="time t-orange">sent 2hrs ago</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="jb-notification">
                <div class="container">
                    <div class="row">
                        <div class="col-md-1">
                            <i class="fa fa-money-bill-alt t-orange icon"></i>
                        </div>
                        <div class="col-md-11">
                            <p class="title t-bold t-mont">You have a new unread message </p>

                        </div>
                    </div>
                </div>

            </div>
            <div class="jb-notification">
                <div class="container">

                    <div class="row">
                        <div class="col-md-1">
                            <i class="fa fa-cog  t-orange icon"></i>
                        </div>
                        <div class="col-md-11">
                            <p class="title t-bold t-mont">Kindly provide all your profile
                                information</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jb-notification">

                <div class="container">
                    <div class="row">
                        <div class="col-md-1">
                            <i class="fa fa-cog t-orange icon"></i>
                        </div>
                        <div class="col-md-11">
                            <p class="title t-bold t-mont">Set your security question </p>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: "dash-notification",
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            })
        },
    }
</script>

<style scoped>

</style>
