<template>

    <div class="h-100">
        <DashNav/>

        <div class="jb-main-section-wrapper">
            <div class="container jb-messaging-area">
                <div class="row">

                    <div class="col-12 col-md-5 col-lg-3 " :class="showChatArea?'hide-on-mobile':'display-on-mobile'">

                        <div class="jb-chat-list">

                            <div class="search-box">
                                <b-form-group>
                                    <b-form-input placeholder="Search"></b-form-input>
                                </b-form-group>
                            </div>

                            <ul class="jb-chat-users-list">

                                <template v-for="contact in contacts">
                                    <li v-if="contact" class="jb-chat-user"
                                        @click="changeSelectedMessages(contact)">
                                        <div class="user">
                                            <div class="img-wrap">
                                                <div class="online-status"
                                                     :class="contact.is_online?'active':''"></div>
                                                <img :src="contact.profile.picture" alt="" class="rounded-circle"
                                                     width="40">
                                            </div>
                                            <div class="user-details">
                                                <div class="name-time">
                                                    <span>{{contact.name}}</span> <span
                                                    class="text-right small ml-auto">10 mins</span></div>
                                                <div class="last-message t-6">
                                                    {{truncate('Lorem ipsum dolor sit amet edfdfx elit',38)}}
                                                </div>
                                            </div>
                                        </div>

                                    </li>
                                </template>


                            </ul>


                        </div>


                    </div>

                    <div class="col-12 col-md-7 col-lg-9  "
                         :class="showChatArea?'display-on-mobile':'hide-on-mobile'">

                        <div class="jb-main-chat-area">

                            <div class="jb-chat-header">

                                <div>
                                    <span class="t-1 text-success"> <b-icon-arrow-left-circle-fill
                                        @click="showChatArea=!showChatArea" class="d-md-none cursor-pointer"/></span>
                                </div>

                                <div>
                                    <div class="message-sender-image-wrap">

                                        <template v-if="selectedContact">
                                            <img v-if="selectedContact" :src="selectedContact.profile.picture"
                                                 alt=""
                                                 class="rounded-circle message-sender-image" width="50">

                                            <span v-if="selectedContact"
                                                  class="name ml-2">{{selectedContact.name}} </span>

                                        </template>


                                    </div>
                                </div>

                            </div>

                            <div class="jb-chat-box" ref="jbChatBox">
                                <ul class="jb-chat-messages" v-if="">
                                    <template v-for="message in messages">

                                        <!--sender-->
                                        <li class="jb-message" v-if="message.user_id === user.id">

                                            <div class="right">

                                                <div class="message-description">

                                                    {{message.message}}

                                                    <div class="footer">
                                                        <span class="t-6">
                                                            <timeago
                                                                :datetime="message.created_at" :auto-update="60"/>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div v-if="user" class="message-sender-image-wrap">
                                                    <img :src="user.profile.picture"
                                                         class="rounded-circle message-sender-image" width="40">
                                                </div>
                                            </div>

                                        </li>


                                        <!--receiver-->

                                        <li class="jb-message" v-else>

                                            <div class="left">
                                                <div v-if="message.user" class="message-sender-image-wrap">
                                                    <img :src="message.user.profile.picture"
                                                         class="rounded-circle message-sender-image" width="40">
                                                </div>
                                                <div class="message-description">

                                                    {{message.message}}
                                                    <div class="footer">
                                                         <span class="t-6">
                                                        <timeago
                                                            :datetime="message.created_at" :auto-update="60"/>
                                                         </span>
                                                    </div>
                                                </div>

                                            </div>

                                        </li>
                                    </template>
                                </ul>
                            </div>

                            <div class="jb-chat-input">

                                <ValidationObserver v-slot="{handleSubmit}" ref="sendMessageForm">
                                    <b-form @submit.prevent="handleSubmit(sendMessage)">
                                        <validation-provider
                                            persist
                                            name="additional details"
                                            :rules="{ required: true, min: 3, max:2000}"
                                            v-slot="validationContext">

                                            <b-form-invalid-feedback id="message-live-feedback">
                                                {{validationContext.errors[0] }}
                                            </b-form-invalid-feedback>


                                            <b-input-group>

                                                <b-form-textarea no-resize rows="2"
                                                                 v-model="messageDetails.message"
                                                                 :state="getValidationState(validationContext)"
                                                                 placeholder="Type your message..."
                                                                 aria-describedby="message-live-feedback"></b-form-textarea>
                                                <b-input-group-append>
                                                    <b-button type="submit" variant="success">Send</b-button>
                                                </b-input-group-append>
                                            </b-input-group>

                                        </validation-provider>
                                    </b-form>
                                </ValidationObserver>

                            </div>

                        </div>

                    </div>


                </div>

            </div>


        </div>
    </div>


</template>

<script>
    import DashNav from "../../components/navbar/DashNav";
    import InfiniteLoading from 'vue-infinite-loading';
    import {mapGetters} from "vuex";
    import axios from "axios";

    export default {
        name: "AllMessages",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Dashboard',
        },
        components: {
            DashNav,
            InfiniteLoading,
        },
        data() {
            return {
                selectedChat: null,
                showChatArea: false,
                messageDetails: {
                    message: '',
                    receiver_id: ''
                },

                messages: [],
                contacts: [],
                selectedContact: {
                    profile: {
                        picture: ''
                    }
                },
                currentPage: 1,
                lastPage: null,
            }
        },

        beforeCreate() {
            axios.get('messages/contacts').then(({data}) => {
                this.contacts = data.contacts;

                this.changeSelectedMessages(this.contacts[0]);

                this.scrollChatBoxDown();
            })
        },
        methods: {


            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n - 1) + '&hellip;' : str;
            },


            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },

            changeSelectedMessages(contact) {
                this.selectedContact = contact;
                this.showChatArea = true;

                this.messageDetails.receiver_id = contact.id;

                //getMessages
                axios.get(`messages/${contact.id}/getAll`).then(
                    ({data}) => {
                        this.currentPage = data.messages.current_page;
                        this.lastPage = data.messages.last_page;
                        this.messages = data.messages.data.reverse();
                    }
                ).catch(

                );


            },

            sendMessage() {
                axios.post('/messages', this.messageDetails).then(({data}) => {
                    this.messageDetails.message = '';
                    this.$refs.sendMessageForm.reset();
                    this.messages.push(data.message);

                    //push the scrollbar to the bottom

                }).catch((errorsRes) => {
                    this.$refs.sendMessageForm.setErrors({...errorsRes.response.data.errors})
                });
            },

            scrollChatBoxDown() {
                this.$refs.jbChatBox.scrollTop = this.$refs.jbChatBox.scrollHeight;
            }
        },

        updated() {
            this.scrollChatBoxDown();
        },


        created() {

            Echo.join('jobs233_ymiutkyihzrihztnzwar')
                .listen('UserOnline', (e) => {
                    let contact = this.contacts.find((contact) => {
                        return contact.id = e.user.id
                    });

                    if (contact) {
                        contact.is_online = e.user.is_online
                    }
                })
                .listen('UserOffline', (e) => {
                    let contact = this.contacts.find((contact) => {
                        return contact.id = e.user.id
                    });
                    if (contact) {
                        contact.is_online = e.user.is_online
                    }
                });


            Echo.private('jobs233_messaging.' + this.user.id)
                .listen('MessageSent', (e) => {
                    //this.activeFriend=e.message.user_id;
                    this.messages.push(e.message);

                    //this.allMessages.push(e.message)
                    //setTimeout(this.scrollToEnd,100);
                })

        },

        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            }),

        },

        watch: {}


    }
</script>

<style scoped>

</style>
