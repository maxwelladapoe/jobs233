<template>

    <div class="jb-slider">


        <b-carousel :arrow="false" :animated="'fade'" :interval="15000" :pause-info="false" :indicator="false">
            <b-carousel-item v-for="(carousel, i) in carousels" :key="i">
                <section class="hero">
                    <div class="hero-bg">
                        <div class="overlay bg-black"></div>


                        <div class="jb-slider-video-wrap is-hidden-mobile" v-if="carousel.video">
                            <video autoplay muted loop class="slider-video" >
                                <source :src="carousel.video" type="video/mp4">
                            </video>

                        </div>
                        <img :src="carousel.image" alt="slider1" class="carousel-image" :class="{
                             'is-hidden-desktop':carousel.video }">

                    </div>
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title t-white t-2" v-html="carousel.mainText"></h1>
                            <p class=" subtitle t-meri t-white" v-if="carousel.subText" v-html="carousel.subText"></p>

                            <router-link :to="carousel.link" v-if="carousel.link" class="button is-white is-outlined">
                                {{carousel.linkText}}</router-link>

                        </div>

                    </div>

                </section>
            </b-carousel-item>
        </b-carousel>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        data: function () {
            return {
                carousels: [
                    {
                        mainText: 'Be your <br>own Boss', subText:
                            'Work as a freelancer using your existing skill set. <br>Choose from the wide array of projects available. <br>',
                        color: 'primary', image: '/images/img1.webp', video: '/videos/slider.mp4',
                        link:{name:'Projects'}, linkText:'Start working'
                    },
                    {
                        mainText: 'Find the perfect<br>creative for your<br>next project.',
                        subText: 'Whatever your needs, there will be a freelancer to get it done.',
                        color: 'primary', image: '/images/slider/3.jpg', link:{name:'createProject'},
                        linkText:'Post a project'
                    },
                ]
            }
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

<style scoped lang="scss">
</style>
