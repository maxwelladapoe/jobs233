<template>


    <div class="jb-main-section-wrapper">

        <div class="jb-section" v-if="viewUser">

            <div class="section no-padding-margin-top-bottom">
                <div class="container ">

                    <div class="jb-profile-cover">

                        <img class="bg-cover" :src="viewUser.profile.cover_image"/>


                        <div class="profile">
                            <div class="profile-picture">
                                <img class="image" :src="viewUser.profile.picture"/>
                            </div>

                            <div class="profile-details">
                                <p class="has-text-white has-text-shadow">
                                    <span class="t-mont t-bold t-5">{{viewUser.name}}</span>
                                    <br>
                                    <span class="t-mont t-6">{{viewUser.username}}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="columns is-multiline">

                        <div class="column is-12 is-3-desktop">
                            <div class="mt-3">
                                <div class=" t-bold">Skills</div>
                                <template v-if="viewUser.skills.length > 0">

                                    <b-taglist>
                                        <b-tag v-for="skill in viewUser.skills" v-bind:key="skill.id">{{skill
                                            .name}}
                                        </b-tag>
                                    </b-taglist>
                                </template>

                                <template v-else>
                                    <p class="t-6">No information on skills provided</p>
                                </template>


                            </div>
                        </div>
                        <div class="column is-12 is-9-desktop">

                            <div class="jb-profile-details">

                                <div>
                                    <div class=" t-bold">Bio</div>
                                    <div class="jb-profile-bio">

                                        <template v-if="viewUser.profile.bio ===''">
                                            <p class="t-normal t-meri">{{viewUser.profile.bio}}</p>

                                        </template>

                                        <template v-else>
                                            <p class="t-6">No bio information provided</p>
                                        </template>
                                    </div>
                                </div>


                                <div>
                                    <div class=" t-bold">Portfolio</div>

                                    <div class="jb-profile-portfolio">

                                        <div class="columns">


                                            <div v-for="portfolioItem in viewUser.portfolio"
                                                 v-bind:key="portfolioItem.id"
                                                 class="column is-4">
                                                <div class="card">
                                                    <div class="card-image">
                                                        <figure class="image is-4">
                                                            <img :src="portfolioItem.cover_image"
                                                                 alt="Placeholder image">
                                                        </figure>
                                                    </div>
                                                    <div class="card-content">
<!--                                                        <div class="media">-->
<!--                                                            <div class="media-left">-->
<!--                                                                <figure class="image is-48x48">-->
<!--                                                                    <img-->
<!--                                                                        src="https://bulma.io/images/placeholders/96x96.png"-->
<!--                                                                        alt="Placeholder image">-->
<!--                                                                </figure>-->
<!--                                                            </div>-->
<!--                                                            <div class="media-content">-->
<!--                                                                <p class="title is-4">John Smith</p>-->
<!--                                                                <p class="subtitle is-6">@johnsmith</p>-->
<!--                                                            </div>-->
<!--                                                        </div>-->


                                                        <div class="content">
                                                            <p >
                                                                <span class="t-bold">
                                                                    {{portfolioItem.name}}
                                                                </span>

                                                                <br>
                                                                <span>
                                                                     {{portfolioItem.description}}
                                                                </span>
                                                               </p>


                                                            <span class="t-6 t-bold">Skills & Tools</span>

                                                            <b-taglist>
                                                                <template v-for="skill in
                                                                portfolioItem.skills_and_tools.split(',')">

                                                                    <b-tag type="is-success" class="mr-1">{{skill}}</b-tag>

                                                                </template>
                                                            </b-taglist>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="column is-3-desktop"></div>

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
            })

        }
    }
</script>

<style scoped>

</style>
