<template>
    <div class="jb-notifications bg-ash-light ">
        <div class="jb-notifications-header b-bottom">
            <p class="t-mont t-bold">
                Notifications
            </p>
            <template>
                <b-button class="btn bg-orange" @click="markAllAsRead">Mark All As Read</b-button>

            </template>

        </div>

        <div class="js-notifications-wrapper">

            <template v-if="notifications.length>0">
                <template v-for="notification in notifications">

                    <template v-if="notification.type===`App\\Notifications\\MessageSentNotification`">
                        <div class="jb-notification">
                            <div class="notification-icon">
                                <b-icon icon="mail"/>
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
            </template>

            <template v-else>
                <div class="px-3 pt-1">
                    <p class="t-6">There are no new notifications</p>

                </div>
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
            },
            markAllAsRead() {
                axios.post('/notifications/mark_all_as_read').then(({data}) => {
                    this.notifications = [];
                })
            }
        }
    }
</script>

<style scoped>

</style>
