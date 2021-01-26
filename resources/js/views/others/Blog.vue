<template>
    <div>

        <div class="hero is-medium has-background-pattern">

            <div class="hero-body">
                <div class="container">

                    <div class="columns is-multiline">

                        <div class="column is-12 is-6-desktop is-offset-3-desktop has-text-centered">
                            <h1 class="title t-black t-1 t-bold">Contact Us</h1>
                            <p class="subtitle t-white">Need some help / information</p>

                            <div class=" has-text-centered">
                                <a class="t-bold button is-text bg-white no-decoration"
                                   href="mailto:support@jobs233.com">Send us an email <span
                                    class="ml-2"><b-icon
                                    icon="arrow-right"/></span></a>
                            </div>


                        </div>
                    </div>

                </div>

            </div>


        </div>


        <div class="jb-main-section-wrapper-alt">

            <div class="section">
                <div class="container">



                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Contact",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Contact Us',
            meta: [
                {
                    name: 'description',
                    content: `Need to make some inquiries? Feel free to send us an email or submit a request`
                }
            ]
        },
        data() {
            return {
                userType: null,
                email: '',
                subject: '',
                description: '',

            }
        }
    }
</script>

<style scoped>

</style>
