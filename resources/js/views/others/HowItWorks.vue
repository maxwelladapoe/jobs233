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
