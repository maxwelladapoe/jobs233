<template>

    <div class="jb-slider">


        <b-carousel :arrow="false" :animated="'fade'" :interval="10000" :pause-info="false" :indicator="false">
            <b-carousel-item v-for="(carousel, i) in carousels" :key="i">
                <section class="hero">
                    <div class="hero-bg">
                        <div class="overlay bg-black"></div>


                        <div class="jb-slider-video-wrap is-hidden-mobile">
                            <video autoplay muted loop class="slider-video" >
                                <source src="/videos/slider.mp4" type="video/mp4">
                            </video>

                        </div>
                        <img :src="carousel.image" alt="slider1" class="carousel-image is-hidden-desktop">

                    </div>
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title t-white t-1" v-html="carousel.mainText"></h1>
                            <p class=" subtitle t-meri t-white" v-html="carousel.subText"></p>
                            <router-link :to="{name:'SignUp'}" class="button is-white is-outlined">Register to work</router-link>

                        </div>

                    </div>

                </section>
            </b-carousel-item>
        </b-carousel>

    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                carousels: [
                    {
                        mainText: 'Be your <br>Own Boss', subText: 'Work as a freelancer using your existing skill set',
                        color: 'primary', image: '/images/img1.webp'
                    },
                ]
            }
        }
    }
</script>

<style scoped lang="scss">
</style>
