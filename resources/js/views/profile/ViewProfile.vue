<template>


    <div class="jb-main-section-wrapper">

        <div class="jb-section" v-if="viewUser">


                <div class="container ">

                    <div class="jb-profile-cover"></div>

                    <div class="jb-profile-row">


                        <div class="columns ">
                            <div class="col-12 col-lg-3 pr-lg-5">
                                <div class="jb-profile-picture">
                                    <b-img fluid rounded
                                           :src="viewUser.profile.picture"></b-img>
                                </div>

                                <div class="mt-3">
                                    <p>
                                        <span class="t-mont t-bold t-5">{{viewUser.name}}</span>
                                        <br>
                                        <span class="t-mont t-6">{{viewUser.username}}</span>
                                    </p>

                                    <div class="t-6 jb-title-with-underline">
                                        <div class="title">Skills</div>
                                        <div class="underline"></div>
                                    </div>


                                </div>


                            </div>
                            <div class="col-lg-9">

                                <div class="jb-profile-details">
                                    <div class="t-6 jb-title-with-underline">
                                        <div class="title">Bio</div>
                                        <div class="underline"></div>
                                    </div>

                                    <div class="jb-profile-bio">
                                        <p class="t-normal t-meri">{{viewUser.profile.bio}}</p>
                                    </div>


                                    <div>
                                        <div class="t-6 jb-title-with-underline mt-5">
                                            <div class="title">Portfolio</div>
                                            <div class="underline"></div>
                                        </div>

                                        <div class="jb-profile-portfolio">


                                            <b-card-group columns>
                                                <b-card
                                                    title="Card title that wraps to a new line"
                                                    img-src="https://placekitten.com/g/400/450"
                                                    img-alt="Image"
                                                    img-top
                                                >
                                                    <b-card-text>
                                                        This is a wider card with supporting text below as a natural
                                                        lead-in
                                                        to
                                                        additional content.
                                                        This content is a little bit longer.
                                                    </b-card-text>
                                                </b-card>

                                                <b-card header="Quote">
                                                    <blockquote class="blockquote mb-0">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            Integer
                                                            posuere
                                                            erat a ante.</p>
                                                        <footer class="blockquote-footer">
                                                            Someone famous in <cite title="Source Title">Source
                                                            Title</cite>
                                                        </footer>
                                                    </blockquote>
                                                </b-card>

                                                <b-card title="Title" img-src="https://placekitten.com/500/350"
                                                        img-alt="Image"
                                                        img-top>
                                                    <b-card-text>
                                                        This card has supporting text below as a natural lead-in to
                                                        additional
                                                        content.
                                                    </b-card-text>
                                                    <b-card-text class="small text-muted">Last updated 3 mins ago
                                                    </b-card-text>
                                                </b-card>

                                                <b-card bg-variant="primary" text-variant="white">
                                                    <blockquote class="card-blockquote">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            Integer
                                                            posuere
                                                            erat a ante.</p>
                                                        <footer>
                                                            <small>Someone famous in <cite title="Source Title">Source
                                                                Title</cite></small>
                                                        </footer>
                                                    </blockquote>
                                                </b-card>

                                                <b-card>
                                                    <b-card-title>Title</b-card-title>
                                                    <b-card-text>
                                                        This card has supporting text below as a natural lead-in to
                                                        additional
                                                        content.
                                                    </b-card-text>
                                                    <b-card-text class="small text-muted">Last updated 3 mins ago
                                                    </b-card-text>
                                                </b-card>

                                                <b-card img-src="https://picsum.photos/400/400/?image=41"
                                                        img-alt="Image"
                                                        overlay></b-card>

                                                <b-card img-src="https://picsum.photos/400/200/?image=41"
                                                        img-alt="Image"
                                                        img-top>
                                                    <b-card-text>
                                                        This is a wider card with supporting text below as a natural
                                                        lead-in
                                                        to
                                                        additional content.
                                                        This card has even longer content than the first.
                                                    </b-card-text>
                                                    <template #footer>
                                                        <small class="text-muted">Footer Text</small>
                                                    </template>
                                                </b-card>
                                            </b-card-group>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3"></div>


                        </div>

                    </div>

                </div>


        </div>

    </div>
</template>

<script>
    export default {
        name: "ViewProfile",
        metaInfo() {
            // if no subcomponents specify a metaInfo.title, this title will be used

            return {
                title: this.username,
            }

        },
        props: {
            username: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                viewUser: ''
            }
        },
        mounted() {
            axios.get(`${this.username}`).then(({data}) => {
                this.viewUser = data.user[0];
                console.log(this.viewUser)
            })
        }
    }
</script>

<style scoped>

</style>
