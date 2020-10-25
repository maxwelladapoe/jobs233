<template>

    <div class="jb-slider">
        <div class="jb-slider-img" v-for="image in sliderImages">

            <img :src="image" alt="slider1">
            <div class="jb-overlay"></div>
            <div class="jb-slider-text">
                <div class="container">
                    <h1 class="t-meri">Be your <br>Own Boss</h1>
                    <p class="t-meri">Work as a freelancer using your existing skill set</p>
                    <router-link :to="{name:'SignUp'}" class="btn bg-orange">Register to work</router-link>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                sliderImages: ['/images/img1.webp']
            }
        }
    }
</script>

<style scoped lang="scss">
</style>
