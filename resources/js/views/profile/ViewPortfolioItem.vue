<template>


    <div class="jb-main-section-wrapper">

        <div class="jb-section">

            <div class="section ">
                <div class="container ">

                    <div class="columns is-multiline">

                        <div class="column is-12 is-10-desktop is-offset-1-desktop">

                            <div class="columns is-multiline">


                                <div class="column is-12 is-7-desktop">

                                    <b-carousel-list :autoplay="false" arrow :arrow-hover="false"
                                                     class="custom-carousel-list"
                                                     indicator-position="is-bottom" indicator-style="boxes"
                                                     @change="changeSelectedItem($event)"
                                                     v-model="selectedPortfolioItemIndex"
                                                     :items-to-show="1" :items-to-list="1" :draggable="true"
                                                     :data="portfolioItems" style="box-shadow: none">

                                        <template #item="list">
                                            <figure class="custom-image-container">
                                                <img :src="list.cover_image">
                                            </figure>
                                        </template>

                                    </b-carousel-list>


                                </div>


                                <div class="column is-12 is-4-desktop is-offset-1-desktop">

                                    <p class="t-3 t-bold " v-if="selectedPortfolioItem">{{
                                            selectedPortfolioItem.name
                                        }}</p>

                                    <div class=" media mt-3" v-if="viewUser">
                                        <figure>
                                            <div class="jb-dash-profile-img">
                                                <b-image v-if="viewUser.profile"
                                                         :rounded="true"
                                                         class="rounded-circle" style="width: 60px"
                                                         :src="viewUser.profile.picture"
                                                />
                                            </div>
                                        </figure>

                                        <div class="media-content details">
                                            <div class="jb-dash-profile-name">
                                                <p class=" mb-3 ml-1" style="line-height: 60px">
                                            <span class="t-bold is-block">by <span class="t-orange">
                                                {{ viewUser.name }}</span></span>
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <template
                                        v-if="selectedPortfolioItem && selectedPortfolioItem.skills_and_tools">
                                        <p class="t-6 t-meri mt-3 t-bold mb-3">Skills & tools used:</p>
                                        <b-taglist class="">
                                            <b-tag type="is-success" v-for="(skillsTools,index) in
                                selectedPortfolioItem.skills_and_tools.split(',')" :key="index">
                                                {{ skillsTools }}
                                            </b-tag>
                                        </b-taglist>
                                    </template>

                                    <hr>

                                    <p class="t-5" v-if="selectedPortfolioItem">{{
                                            selectedPortfolioItem.description
                                        }}</p>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>


            </div>


        </div>

    </div>
</template>

<script>
export default {
    name: "ViewPortfolioItem",
    metaInfo() {
        // if no subcomponents specify a metaInfo.title, this title will be used

        return {
            title: "Portfolio"
        }

    },
    props: {
        portfolioItemId: {
            required: true
        },
        userId: {
            required: true
        }
    },
    data() {
        return {
            userWithPortfolioItems: {},
            viewUser: {},
            portfolioItems: [],
            gallery: false,
            selectedPortfolioItemIndex: null,
        }
    },
    mounted() {

        axios.get(`/${this.userId}/portfolio`).then(({data}) => {
            console.log(data);
            this.viewUser = data.user;
            this.portfolioItems = data.portfolio_items;


            let index = this.portfolioItems.findIndex(portfolioItem => {

                return portfolioItem.id == this.portfolioItemId
            })

            this.selectedPortfolioItemIndex = index;

        })


    },
    methods: {
        getImgUrl(value) {
            value += 50
            return `https://picsum.photos/id/10${value}/1230/500`
        },
        switchGallery(value) {
            this.gallery = value
            return document.documentElement.classList.remove('is-clipped')
        },

        changeSelectedItem(value) {
            this.selectedPortfolioItemIndex = value;

            this.$router.replace({
                name: 'ViewPortfolioItem',
                params: {user: this.userId, portfolio: this.selectedPortfolioItem.id}
            })
        }
    },
    computed: {
        selectedPortfolioItem() {
            let portfolioItem = this.portfolioItems[this.selectedPortfolioItemIndex];
            return portfolioItem;
        }
    }
}
</script>

<style scoped>

</style>
