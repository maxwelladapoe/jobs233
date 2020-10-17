<template>
    <div class="jb-notifications bg-ash-light ">
        <div class="jb-notifications-header b-bottom">
            <p class="t-mont t-bold">
                Notifications
            </p>
            <div class="btn bg-orange">Mark All As Read</div>

        </div>

        <div class="js-notifications-wrapper">


            <template v-for="notification in notifications">

                <template v-if="notification.type===`App\\Notifications\\MessageSentNotification`">
                    <div class="jb-notification">
                        <div class="notification-icon">
                           <b-icon-envelope/>
                        </div>
                        <div class="notification-details">
                            <span class="title m-0 t-bold">You have a new unread message </span> <br>
                            <span class=" t-mont">From <span class="t-bold">{{notification.data.sender}}</span>
                                <span
                                    class="time t-orange">sent <timeago
                                    :datetime="notification.data.message.created_at" :auto-update="60"/></span>
                            </span>

                        </div>

                    </div>
                </template>

            </template>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: "dash-notification",
        data() {
            return {
                notifications: []
            }
        },
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            })
        },
        beforeMount() {
            this.getUnreadNotifications()
        },
        methods: {
            getUnreadNotifications() {
                axios.get('/notifications/?category=unread').then(({data}) => {
                    this.notifications = data.notifications
                    console.log(data)
                })
            }
        }
    }
</script>

<style scoped>

</style>
