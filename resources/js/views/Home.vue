<!--suppress ALL -->
<template>
    <div>

        <jb-modal/>

        <div class="jb-alert-notification" v-if="alert" :class="`has-background-${alert.type}`">
            <div class="container">
                <div class="jb-notification-wrap">
                    <div class="alert-message">{{ alert.message }}</div>
                    <div class="close">
                        <button type="button" aria-label="Close notification" class="delete" @click="close"></button>
                    </div>
                </div>

            </div>

        </div>

        <jb-slider/>

        <div class="jb-main-section-wrapper no-margin-bottom">

            <div class="jb-section " style="position: relative">

                <div class="section no-padding-margin-top-bottom">

                    <div class="container ">
                        <div class="columns is-mobile  is-multiline is-vcentered">
                            <div class="column is-12-mobile is-6-desktop">
                                <h1 class="title t-bold t-orange t-mont">Get more done, <br>hire a freelancer</h1>
                                <p class="t-meri t-normal">Speed up your workflow by hiring an experienced freelancer in
                                    any field.
                                    Post your projects and get bids from freelancers.
                                </p>
                                <p class="t-meri t-normal">
                                    We have freelancers who are experts in graphic design, web design, mobile app
                                    development,
                                    software development, architecture, photography and so much more. Whatever your
                                    needs,
                                    there
                                    will
                                    be a freelancer to get it done.</p>
                            </div>

                            <div class="column is-12-mobile is-offset-1-desktop is-5-desktop">

                                <!--                                <div class="jb-player-wrapper">-->
                                <!--                                    <div class="jb-player-overlay"></div>-->

                                <!--                                    <img src="/images/play.png" class="jb-play-icon"/>-->
                                <!--                                    <img src="/images/img2.webp" class="jb-section-img">-->
                                <!--                                </div>-->

                                <div class="jb-square-images">
                                    <div>



                                    <div class="square has-border">
                                        <img src="/images/square1.jpg"/>
                                    </div>
                                    <div class="square has-border has-offset">
                                        <img src="/images/square2.jpg"/>
                                    </div>
                                    <div class="square has-offset-2 is-small has-background-grey">
                                        <div>
                                            <p class="t-white t-mont t-bold ">Engage a network of trusted
                                                freelancers</p>
                                        </div>

                                    </div>

                                </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>


            </div>


            <div class="jb-section-small bg-orange">


                <div class="container">

                    <div class="text-center contents">

                        <template v-if="user && profileType ==='work'">

                            <p class="t-bold  t-mont mr-3 mb-3 ">Need a flexible job? Register as a freelancer</p>

                            <router-link :to="{name:'Projects'}" class="button bg-black has-text-white ml-3">Start
                                working
                            </router-link>

                        </template>
                        <template v-else-if="user && (profileType ==='hire'|| profileType ==='work&hire') ">

                            <p class="t-bold  t-mont mr-3 mb-3 ">Need something completed?</p>
                            <router-link :to="{name:'createProject'}"
                                         class="button bg-black has-text-white ml-3">Post it
                            </router-link>

                        </template>
                        <template v-else>
                            <p class="t-bold  t-mont mr-3 mb-3 ">Need a flexible job? Register as a freelancer</p>
                            <router-link :to="{name:'SignUp'}" class="button bg-black has-text-white ml-3">Register to
                                Work
                            </router-link>
                        </template>


                    </div>

                </div>

            </div>

            <div class="jb-section  jb-player-wrapper">

                <div class="jb-video-bg" style="background-image: url('/images/video.jpg')"></div>
                <div class="jb-player-overlay">
                </div>


                <div class="section no-padding-margin-top-bottom">
                    <div class="container">

                        <div class="jb-with-video">

                            <div class="jb-video-details">
                                <div class="jb-section-text t-white t-bold t-mont">

                                    <div> Get things done
                                        in just a few steps.
                                        <br> Its simple! Here is how.
                                    </div>
                                </div>
                                <div class="jb-play-btn cursor-pointer" @click="isVideoModalActive=!isVideoModalActive">
                                    <img src="/images/play.png" class="jb-play-icon2"/>
                                </div>

                                <b-modal v-model="isVideoModalActive">
                                    <div class="video is-4by3">
                                        <video class="jb-video" src="/videos/how_it_works_simple1.WebM" controls
                                               autoplay/>
                                    </div>
                                </b-modal>


                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <div class="jb-section jb-projects">
                <div class="section">
                    <div class="container">
                        <div class="">
                            <h1 class="t-bold  t-mont title">Get your project started</h1>
                            <br>
                            <div class="columns is-multiline is-mobile is-centered">
                                <div class="column is-6-mobile is-3-tablet is-3-desktop ">
                                    <img class="jb-projects-img" src="/images/icons/programming.svg">
                                    <p class="t-bold jb-project-title  ">Programming & Tech</p>
                                </div>
                                <div class="column  is-6-mobile is-3-tablet is-3-desktop ">
                                    <img class="jb-projects-img" src="/images/icons/graphic-design.svg">
                                    <p class="t-bold jb-project-title  ">Graphic Design</p>
                                </div>
                                <div class="column  is-6-mobile is-3-tablet is-3-desktop ">
                                    <img class="jb-projects-img" src="/images/icons/video.svg">
                                    <p class="t-bold jb-project-title ">Video & Animation</p>
                                </div>
                                <div class="column  is-6-mobile is-3-tablet is-3-desktop ">
                                    <img class="jb-projects-img" src="/images/icons/business.svg">
                                    <p class="t-bold jb-project-title  ">Business</p>
                                </div>
                                <div class="column  is-6-mobile is-3-tablet is-3-desktop ">
                                    <img class="jb-projects-img" src="/images/icons/social-media.svg">
                                    <p class="t-bold jb-project-title ">Digital Marketing</p>
                                </div>
                                <div class="column  is-6-mobile is-3-tablet is-3-desktop ">
                                    <img class="jb-projects-img" src="/images/icons/translation.svg">
                                    <p class="t-bold jb-project-title ">Writing & Translation</p>
                                </div>
                            </div>
                            <br>
                            <router-link :to="{name:'Categories'}" class="button bg-black has-text-white">View
                                all
                            </router-link>

                        </div>
                    </div>
                </div>

            </div>


            <div class="jb-section no-margin-bottom  has-background-grey-dark">
                <div class="section">
                    <div class="container">
                        <div class="columns is-multiline is-vcentered">
                            <div class="column is-5-desktop t-white ">

                                <p class="t-bold t-3 t-mont">Talented and experienced freelancers just a click away</p>


                                <p class="t-bold  t-mont mt-5">A friendly budget for the best of
                                    Jobs</p>
                                <p>Find high-quality services at every price point. No hourly rates, just project-based
                                    pricing.</p>


                                <p class="t-bold  t-mont mt-5">Quality work done on time</p>
                                <p> Find the right freelancer to begin working on your project within minutes.</p>

                                <p class="t-bold  t-mont mt-5">Secured payments, every time</p>
                                <p>Always know what you'll pay upfront. Your payment isn't released until you approve
                                    the work.</p>

                            </div>
                            <div class="column is-6-desktop is-offset-1-desktop">
                                <img src="/images/crisp-feedback-white.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="jb-section-small no-margin-top  bg-orange">

                <div class="container">

                    <div class="text-center contents">
                        <p class="t-bold t-mont mr-3 mb-3 ">Convinced? Hire a freelancer</p>

                        <router-link :to="{name:'createProject'}" class="button bg-black ml-3 has-text-white">Hire
                        </router-link>


                    </div>

                </div>

            </div>


        </div>

    </div>
</template>

<script>

import Slider from '../components/Slider';
import Modal from '../components/Modal';
import Quote from '../components/Quote';
import {mapGetters} from "vuex";

export default {
    metaInfo: {
        // if no subcomponents specify a metaInfo.title, this title will be used
        title: 'Jobs 233 - A freelance market place',
        titleTemplate: false,
        meta: [
            {
                name: 'description',
                content:
                    `A freelance marketplace that makes it easy for clients and designers, developers, content developers
                 to colaborate and get things done. It is  aimed at bringing your creative projects to life at your budget.`
            }
        ]
    },

    data() {
        return {
            isVideoModalActive: false,
            alert: null,
            quotes: [
                {
                    id: 1,
                    title: '"We accomplish a lot more for \nless."',
                    text:
                        'With Jobs 233 you are always a step ahead with our bidding system you are able to hire the right person that meets your need within your budget.',
                    author: 'Peter Smith',
                    authorPosition: 'CEO & Founder Office 360',
                },
                {
                    id: 2,
                    title: '"Branding is important "',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque cupiditate dolores enim, ex incidunt rerum ullam! Autem ipsum magnam odit ',
                    author: 'Joseph Smith',
                    authorPosition: 'CEO & Founder Max int',
                },
                {
                    id: 3,
                    title: '"Build with Ease "',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque cupiditate dolores enim, ex incidunt rerum ullam! Autem ipsum magnam odit ',
                    author: 'Joseph Smith',
                    authorPosition: 'CEO & Founder Max int',
                }
            ]
            ,
            showSignUp: false,
            currentQuoteNumber: 0,
            timer: null,
        }
    },
    mounted() {
        this.startRotation()


        if (this.$route.name === 'EmailVerified' || this.$route.name === 'EmailAlreadyVerified') {

            this.alert = {};
            if (this.$route.name === 'EmailAlreadyVerified') {
                this.alert.message = "Your email has already been verified";
                this.alert.type = "success";
            } else {
                this.alert.message = "Your email has successfully been verified";
                this.alert.type = "success";
            }

            this.$router.replace({name: 'Home'});
        }

    },
    methods: {

        close() {
            this.alert = null;
        },
        startRotation() {
            this.timer = setInterval(this.showNextQuote, 12000);
            console.log('started');
        },
        stopRotation() {
            console.log('paused');
            clearInterval(this.timer);
        },
        showNextQuote() {

            var quotesLength = this.quotes.length;

            //find the current visible quote

            if (this.currentQuoteNumber < (quotesLength - 1)) {
                this.currentQuoteNumber += 1;
            } else {
                this.currentQuoteNumber = 0;
            }
        },
        showPreviousQuote() {
            var quotesLength = this.quotes.length;
            if (this.currentQuoteNumber <= 0) {
                this.currentQuoteNumber = this.quotes.length - 1;
            } else {
                this.currentQuoteNumber -= 1;
            }
        }
    },
    components: {
        jbSlider: Slider,
        jbModal: Modal,
        jbQuote: Quote,
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            profileType: 'auth/profileType',
        }),
    }

}
</script>

<style lang="scss">
</style>
