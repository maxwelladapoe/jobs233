<template>
    <div>

        <div class="hero is-medium has-background-pattern-white">

            <div class="hero-body">
                <div class="container">

                    <div class="columns is-multiline">

                        <div class="column is-12">
                            <h1 class="title t-white t-1 t-bold">Our Blog</h1>
                            <p class="subtitle t-white">News & Articles</p>

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
            title: 'Blog',
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
