<template>

    <div>

        <div class="hero is-medium has-background-primary">

            <div class="hero-body">
                <div class="container">

                    <div class="columns is-multiline">
                        <div class="column ">
                            <h1 class="title t-black t-1 t-bold">How Jobs 233 works</h1>
                            <p class="subtitle t-white">Getting something done is easy.
                                <br> In just a few steps you can get
                                started with you projects</p>
                            <b-button type="is-black">Get Started</b-button>
                        </div>
                        <div class="column">
                            <div class="jb-player-wrapper">
                                <div class="jb-player-overlay"></div>

                                <img src="/images/play.png" class="jb-play-icon"/>
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
                                    <p class="mt-3">Just post it and have our creatives work on it. Its that simple.
                                        <br> There
                                        is always a creative to meet your needs.</p>
                                    <div>
                                        <b-button class="button mt-3">Post a project</b-button>
                                    </div>
                                </div>
                            </div>


                            <div class="columns is-multiline is-mobile mt-5">
                                <div class="column is-12-touch is-6-desktop has-text-centered is-offset-3-desktop">
                                    <p class="mt-3">
                                        Just give us the details of what you need completed, our creatives will get it
                                        done on time, cheaper and better. We work within your budget
                                    </p>
                                </div>
                            </div>


                            <div class="columns is-multiline is-mobile mt-5">

                                <div class="column is-4-desktop">
                                    <div class="columns">
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
                                <div class="column is-4-desktop">

                                    <div class="columns">
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
                                <div class="column is-4-desktop">
                                    <div class="columns">
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
                        <b-tab-item label="Get Hired"></b-tab-item>
                        <b-tab-item label="FAQS"></b-tab-item>
                    </b-tabs>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "HowItWorks",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'How It Works',
        },
    }
</script>

<style scoped>

</style>
