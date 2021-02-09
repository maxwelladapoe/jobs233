<template>


    <div class="jb-main-section-wrapper">

        <div class="jb-section" v-if="viewUser">

            <div class="section ">
                <div class="container ">


                    <div class="columns is-multiline">

                        <div class="column is-12 is-8-desktop">
                            <div class="columns is-multiline">

                                <div class="column is-12 is-4-desktop">


                                    <div class="profile">
                                        <div class="profile-picture">
                                            <img class="image" :src="viewUser.profile.picture"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="column is-12 is-8-desktop">

                                    <div class="profile-details mb-4">
                                        <p class="t-bold t-4">{{ viewUser.name }}</p>
                                        <p class="t-orange">{{ viewUser.profile.title }}</p>
                                        <p class="t-6 mt-2 t-ash">
                                            Joined
                                            <timeago v-if='viewUser.created_at'
                                                     :datetime="viewUser.created_at" :auto-update="60"/>
                                        </p>


                                    </div>

                                    <div class="rating mb-5">
                                        <div class="t-bold t-6  mb-1">Rating</div>
                                        <b-rate v-model="viewUser.rating" size="is-normal" disabled type="is-primary"
                                                spaced></b-rate>
                                        <p class="t-6 t-orange" v-if="rate > 0">{{viewUser.rating}} by {{viewUser.rating_count}}</p>
                                        <p class="t-6 t-orange" v-else> No ratings yet</p>
                                    </div>

                                    <div class="buttons ">
                                        <b-button type="is-primary">
                                            <b-icon icon="message" class="mr-1" size="is-small"/>
                                            Send message
                                        </b-button>
                                    </div>


                                    <hr>
                                </div>
                                <div class="column is-12 is-4-desktop">
                                    <div class="">

                                        <template v-if="userSkills && userSkills.length > 0">

                                            <div class="t-bold t-6  mb-2">Skills</div>
                                            <b-taglist>
                                                <b-tag v-for="skill in userSkills" type="is-success"
                                                       v-bind:key="skill.id">
                                                    {{ skill }}
                                                </b-tag>
                                            </b-taglist>
                                        </template>

                                    </div>
                                </div>

                                <div class="column is-12 is-8-desktop">


                                    <div class="jb-profile-details">

                                        <div>
                                            <template v-if="viewUser.profile.bio">
                                                <div class="t-bold t-6 ">Bio</div>
                                                <div class="jb-profile-bio">
                                                    <p class="t-normal t-meri">{{ viewUser.profile.bio }}</p>
                                                </div>
                                            </template>
                                        </div>


                                        <div>
                                            <template v-if="viewUser.portfolio.length>0">
                                                <div class="t-bold t-6  mb-2">Portfolio</div>

                                                <div class="jb-profile-portfolio">

                                                    <div class="columns is-multiline is-mobile">


                                                        <div v-for="portfolioItem in viewUser.portfolio"
                                                             v-bind:key="portfolioItem.id"
                                                             class="column is-6-mobile is-4-desktop">

                                                            <router-link :to="{name:'ViewPortfolioItem',
                                        params:{userId:viewUser.id,portfolioItemId:
                                        portfolioItem.id}}">
                                                                <div class="card">
                                                                    <div class="card-image">
                                                                        <figure class="image is-4">
                                                                            <img :src="portfolioItem.cover_image"
                                                                                 alt="Placeholder image">
                                                                        </figure>
                                                                    </div>
                                                                </div>
                                                            </router-link>
                                                        </div>

                                                    </div>


                                                </div>

                                            </template>

                                        </div>
                                    </div>

                                </div>


                            </div>


                        </div>


                        <div class="column is-12 is-4-desktop">

                        </div>


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
            title: this.viewUser.name,
            userSkills: []
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
            viewUser: '',
            rate: 0,
            ratedByCount: 0,
        }
    },
    mounted() {
        axios.get(`${this.username}`).then(({data}) => {
            this.viewUser = data.user[0];

            if (data.user[0].skills) {
                this.userSkills = (data.user[0].skills.skills).split(',');
            }

        })

    }
}
</script>

<style scoped>

</style>
