<template>

    <div>

        <div class="hero is-medium has-background-pattern">

            <div class="hero-body">
                <div class="container">

                    <div class="columns is-multiline is-vcentered">
                        <div class="column ">
                            <h1 class="title t-black t-1 t-bold">How Jobs 233 works</h1>
                            <p class="subtitle t-white">Getting something done is easy.
                                <br> In a few steps you can get
                                started with you projects</p>

                            <router-link :to="{name:'Projects'}">
                                <b-button type="is-black">Get Started</b-button>
                            </router-link>

                        </div>
                        <div class="column">
                            <div class="jb-player-wrapper">
                                <div class="jb-player-overlay"></div>

                                <div class="jb-play-btn cursor-pointer" @click="isVideoModalActive=!isVideoModalActive">
                                    <img src="/images/play.png" class="jb-play-icon"/>
                                </div>



                                <img src="/images/img2.webp" class="jb-section-img">
                            </div>
                        </div>
                    </div>



                </div>

            </div>


        </div>


        <div class="jb-main-section-wrapper-alt">

            <div class="section">
                <div class="container">
                    <b-tabs position="is-centered" class="block">
                        <b-tab-item label="Hire">
                            <!--text here-->


                            <div class="columns is-multiline is-mobile mt-5">
                                <div class="column is-12 has-text-centered">
                                    <p class="t-2 t-meri t-bold">Need some work done?</p>
                                    <p class="mt-3">Post it and have our creatives work on it. Its that simple.
                                        <br> There
                                        is always a creative to meet your needs.</p>
                                    <div>

                                        <router-link :to="{name:'createProject'}">
                                            <b-button class="button mt-3">Post a project</b-button>
                                        </router-link>


                                    </div>
                                </div>
                            </div>


                            <div class="columns is-multiline is-mobile mt-5">
                                <div class="column is-12-touch is-6-desktop has-text-centered is-offset-3-desktop">
                                    <p class="mt-3">
                                        Give us the details of what you need completed, our creatives will get it
                                        done on time, cheaper and better. We work within your budget
                                    </p>
                                </div>
                            </div>


                            <div class="columns is-multiline is-mobile mt-5">

                                <div class="column is-12-touch is-4-desktop">
                                    <div class="columns is-mobile">
                                        <div class="column is-2">
                                            <b-image src="/images/commerse/shopping-list.svg"/>
                                        </div>
                                        <div class="column is-10">
                                            <p class="t-bold t-4">Post the project for free</p>
                                            <p>Posting your project is free. Describe your project, provide the
                                                necessary
                                                items to get a creative started. Provide an estimated deadline and
                                                budget</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="column is-12-touch is-4-desktop">

                                    <div class="columns is-mobile">
                                        <div class="column is-2">
                                            <b-image src="/images/commerse/confirm.svg"/>
                                        </div>
                                        <div class="column is-10">
                                            <p class="t-bold t-4">Select your preferred Bid</p>
                                            <p>As soon as you are done posting you should begin to receive bids from
                                                creatives. Browse the portfolios of prospective creatives and award your
                                                project to your preferred creative.
                                            </p></div>
                                    </div>


                                </div>
                                <div class="column is-12-touch is-4-desktop">
                                    <div class="columns is-mobile">
                                        <div class="column is-2">
                                            <b-image src="/images/commerse/money-bag.svg"/>
                                        </div>
                                        <div class="column is-10">
                                            <p class="t-bold t-4">Get it completed & Pay</p>
                                            <p>Pay using our fast stable and secure portal. We act as an intermediary
                                                ensuring you are satisfied before funds are released</p>

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </b-tab-item>
                        <b-tab-item label="Get Hired">

                            <div class="columns is-multiline is-mobile mt-5">
                                <div class="column is-12 has-text-centered">
                                    <p class="t-2 t-meri t-bold">Got some skills?</p>
                                    <p class="mt-3">You can find a wide range of projects that match your skills.
                                        <br>Complete your profile and let us know your skills so we can easily
                                        direct employers to you</p>
                                    <div>
                                        <router-link :to="{name:'Projects'}">
                                            <b-button class="button mt-3">Browse projects</b-button>
                                        </router-link>
                                    </div>
                                </div>
                            </div>


                            <div class="columns is-multiline is-mobile mt-5">
                                <div class="column is-12-touch is-6-desktop has-text-centered is-offset-3-desktop">
                                    <p class="mt-3">

                                        Collaborate with your clients anywhere, anytime, anyplace and get notified on
                                        the latest projects that meet your skills.
                                    </p>
                                </div>
                            </div>


                            <div class="columns is-multiline is-mobile mt-5">

                                <div class="column is-12-touch is-4-desktop">
                                    <div class="columns is-mobile">
                                        <div class="column is-2">
                                            <b-image src="/images/commerse/profile.svg"/>
                                        </div>
                                        <div class="column is-10">
                                            <p class="t-bold t-4">Create your profile</p>
                                            <p>Sign up and provide your skills, upload a profile picture and upload
                                                your portfolio</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="column is-12-touch is-4-desktop">

                                    <div class="columns is-mobile">
                                        <div class="column is-2">
                                            <b-image src="/images/commerse/bid.svg"/>
                                        </div>
                                        <div class="column is-10">
                                            <p class="t-bold t-4">Browse projects & Bid</p>
                                            <p>Browse through the available jobs according to your skills or
                                                preferred category. Bids on jobs you can complete within the
                                                deadlines provided. Tell them why you're the best person for this job.
                                            </p></div>
                                    </div>


                                </div>
                                <div class="column is-12-touch is-4-desktop">
                                    <div class="columns is-mobile">
                                        <div class="column is-2">
                                            <b-image src="/images/commerse/wallet.svg"/>
                                        </div>
                                        <div class="column is-10">
                                            <p class="t-bold t-4">Complete & get payed</p>
                                            <p>Once your bid is approved, get hired, complete the project and get
                                                payed the agreed amount.</p>

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </b-tab-item>
                        <b-tab-item label="FAQS"></b-tab-item>
                    </b-tabs>

                </div>
            </div>
        </div>



        <b-modal v-model="isVideoModalActive">
            <div class="video is-4by3">
                <video class="jb-video" src="/videos/how_it_works_simple1.WebM" controls
                       autoplay/>
            </div>
        </b-modal>
    </div>

</template>

<script>
export default {
    name: "HowItWorks",
    metaInfo: {
        // if no subcomponents specify a metaInfo.title, this title will be used
        title: 'How It Works',
    },
    data(){
        return{
            isVideoModalActive:false
        }
    }
}
</script>

<style scoped>

</style>
