<template>

    <div class="jb-main-section-wrapper">

        <template v-if="!projectNotFound && project">
            <div class="jb-section">
                <div class="section no-padding-margin-top-bottom">
                    <div class="container">

                        <div class="columns is-multiline">
                            <div class="column is-8">


                                <p class="t-bold jb-project-title-big t-mont ">{{ project.title }}</p>

                                <p class="t-meri"> <span class="t-bold">
                                {{ project.category.name }}
                            </span>

                                    <span v-if="project.subcategory">> {{ project.subcategory.name }}</span>
                                </p>

                                <p class="t-mont jb-project-title-small t-bold t-orange">Description</p>
                                <div class="t-meri content" v-html="project.description"></div>

                                <p class="t-mont jb-project-title-small t-bold t-orange">Skills</p>
                                <h5>
                                    <template v-for="(skill,index) in project.skills.split(',')">
                                        <b-tag type="is-success" class="mr-1" v-bind:key="index">{{ skill }}</b-tag>
                                    </template>
                                </h5>


                                <template v-if="project.complexity">
                                    <p class="t-mont jb-project-title-small t-bold t-orange">Complexity</p>
                                    <p>{{ project.complexity }}</p>
                                </template>


                                <template v-if="project.tags">
                                    <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Tags</p>

                                    <h5>
                                        <template v-for="(tag,index) in project.tags.split(',')">


                                            <b-tag class="mr-1" type="is-success" v-bind:key="index">{{ tag }}</b-tag>

                                        </template>
                                    </h5>
                                </template>

                                <hr>
                                <p class="t-meri"><span>Deadline</span>
                                    <span></span>
                                    <timeago v-if='project.deadline' :datetime="project.deadline" :auto-update="60"/>
                                </p>
                                <hr>

                                <p class="t-mont jb-project-title-small t-bold t-orange">Activities on this Job</p>
                                <p class="t-meri m-0">Bids: {{ project.bids_count }}</p>
                                <p class="t-meri">Views: 0</p>


                                <hr>


                                <!-- Placed bids -->
                                <template v-if=" authenticated && user &&( project.user_id === user.id)">

                                    <!--if the project bids are available and the bids count is greater than zero -->
                                    <template v-if="project.bids && project.bids_count>0">
                                        <p>Recent Bids</p>

                                        <div class="jb-bids-wrap">

                                            <template v-for="(bid,index) in project.bids">

                                                <template v-if="(index+1)<=initialBidsToShow">

                                                    <div class="jb-bid"
                                                         :class="!bid.is_accepted && project.accepted_bid_id != null ? 'disabled':''"
                                                         v-bind:key="index">

                                                        <div class="top">
                                                            <div class="profile-details-wrap">
                                                                <router-link
                                                                    :to="{name:'ViewProfile',params:{username:bid.user.username}}">


                                                                    <div>
                                                                        <div class="media">

                                                                            <div class="media-left">
                                                                                <b-image class="" rounded
                                                                                         :src="bid.user.profile.picture"
                                                                                         alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="media-content">
                                                                                   <span
                                                                                       class="t-meri">{{
                                                                                           bid.user.name
                                                                                       }}</span>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </router-link>
                                                                <div>

                                                                </div>


                                                            </div>

                                                            <div class="bid-details-wrap">

                                                                <div>
                                                                    <p class="t-meri text-right">
                                                                        <timeago v-if='bid.created_at'
                                                                                 :datetime="bid.created_at"
                                                                                 :auto-update="60"/>
                                                                    </p>
                                                                    <p class="t-meri t-5">
                                                                        offer <span
                                                                        class="t-bold">{{
                                                                            bid.currency.symbol
                                                                        }} {{ bid.amount }}</span>
                                                                    </p>

                                                                </div>


                                                            </div>

                                                        </div>


                                                        <div class="bottom">
                                                            <div class="more-info-wrap">
                                                                <template v-if="bid.additional_details">


                                                                    <b-collapse :open="false"
                                                                                :aria-id="'content-'+bid.id+'-ally'"
                                                                                class="mt-1">
                                                                        <p :aria-controls="'content-'+bid.id+'-ally'"
                                                                           slot="trigger"
                                                                           class="t-orange t-6 text-right m-0"
                                                                           style="border: none; cursor: pointer">More
                                                                            info</p>


                                                                        <div class="text-right mt-0 p-0">
                                                                            <p>{{ bid.additional_details }}</p>
                                                                        </div>
                                                                    </b-collapse>

                                                                </template>
                                                            </div>

                                                        </div>

                                                        <div class="w-100 text-right mt-2">

                                                            <template
                                                                v-if="!bid.is_accepted && project.accepted_bid_id == null">
                                                                <div class="buttons">
                                                                    <router-link :to="{name:'ViewPortfolioItem',
                                                                    params:{userId:bid.user.id,portfolioItemId:null}}"
                                                                                 class="button is-primary is-outlined">
                                                                        View Portfolio
                                                                    </router-link>
                                                                    <b-button @click.prevent="acceptBid(bid.id)"
                                                                              type="is-success"
                                                                              class="ml-auto">
                                                                        Accept Bid
                                                                    </b-button>
                                                                </div>

                                                            </template>

                                                            <div v-if="bid.is_accepted"
                                                                 @click.prevent="acceptBid(bid.id)"
                                                                 class="ml-auto ">

                                                                <p class="text-success">
                                                                    <b-icon icon="check-circle" size="is-small"/>
                                                                    Accepted Bid
                                                                </p>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </template>

                                            </template>

                                            <b-button v-if=" project.bids_count > initialBidsToShow"
                                                      @click="initialBidsToShow =project.bids_count">View All
                                            </b-button>

                                        </div>


                                    </template>
                                </template>
                                <!-- Placed bids -->

                            </div>

                            <div class="column is-4">
                                <p class="t-mont jb-project-title-small t-bold t-orange">Budget</p>
                                <p class="t-meri t-4 t-bold">{{ project.currency.symbol }} {{ project.budget }}</p>

                                <hr>


                                <template v-if="authenticated && project.user.id === user.id">
                                    <router-link :to="{name:'MakeDeposit' ,params:{'project_id':project.id}}"
                                                 class="button is-primary">Make a
                                        deposit
                                        <b-icon icon="cash-plus" class="ml-2" size="is-small"/>
                                    </router-link>


                                    <hr>
                                </template>


                                <p class="t-mont jb-project-title-small t-bold t-orange">Created
                                    <timeago v-if="project.created_at" :datetime="project.created_at"
                                             :auto-update="60"/>
                                    by
                                </p>

                                <div class=" media t-meri mt-2">
                                    <figure class="media-left">

                                        <img :src="project.user.profile.picture" alt=""
                                             style="width: 50px; border-radius:50px">
                                    </figure>

                                    <div class="media-content">
                                        <router-link :to="{name:'ViewProfile', params:{'username':
                                        project.user.username}
                                        }">
                                             <span class="mr-auto"
                                                   v-if="authenticated && (user.id === project.user.id)">You</span>
                                            <span class="mr-auto" v-else>{{ project.user.name }}</span>
                                        </router-link>
                                        <p class="t-6 t-orange">Joined
                                            <timeago v-if="project.user.created_at" :datetime="project.user.created_at"
                                                     :auto-update="60"></timeago>
                                        </p>
                                    </div>

                                </div>


                                <hr>


                                <template v-if="authenticated === false">

                                    <p class="t-meri">To Be able to start working on this Job or others you need tto
                                        apply
                                        now.</p>
                                    <p class="t-meri">This and other Jobs are available</p>

                                    <router-link to="" class="button bg-orange">Sign Up to get Hired</router-link>
                                </template>

                                <template
                                    v-if="hasAlreadyPlacedBid && (profileType ==='work' || profileType ==='work&hire') ">
                                    <p class="t-meri t-bold t-5">You have already placed a Bid</p>
                                    <p>You should receive an email of confirmation if your bid has been accepted</p>
                                    <!-- <router-link to="" class="button bg-orange">Edit your Bid</router-link> -->
                                    <router-link to="" class="button bg-orange">View other projects</router-link>

                                </template>

                                <template
                                    v-else-if=" ( !bidSubmitted || !hasAlreadyPlacedBid) && (profileType ==='work' || profileType ==='work&hire') ">


                                    <template v-if="showBidSubmittedSuccessfully">
                                        <p class="t-meri t-bold t-5">Your bid was placed successfully</p>

                                    </template>

                                    <template v-else>
                                        <p class="t-meri t-bold t-5">Interested in this project? <br>Bid now</p>

                                        <p class="my-3">I am willing to do this Job at</p>

                                        <ValidationObserver v-slot="{handleSubmit}" ref="submitBidForm">


                                            <form>


                                                <b-field grouped>


                                                    <!--                                                    <ValidationProvider-->
                                                    <!--                                                        :rules="{ required: true, integer:false}"-->
                                                    <!--                                                        name="currency"-->
                                                    <!--                                                        v-slot="{ errors, valid }" slim-->
                                                    <!--                                                    >-->

                                                    <!--                                                        <b-field-->
                                                    <!--                                                            :message="errors"-->
                                                    <!--                                                            :type="{ 'is-danger': errors[0], 'is-success': valid }"-->
                                                    <!--                                                        >-->
                                                    <!--                                                            <b-select-->
                                                    <!--                                                                placeholder="  Select a-->
                                                    <!--                                                                            currency"-->
                                                    <!--                                                                name="currency"-->
                                                    <!--                                                                expanded-->
                                                    <!--                                                                v-model="bid.currency">-->

                                                    <!--                                                                <option v-for="currency in currencies"-->
                                                    <!--                                                                        :key="currency.id"-->
                                                    <!--                                                                        :value="currency.id">-->
                                                    <!--                                                                    {{currency.name}}-->
                                                    <!--                                                                </option>-->

                                                    <!--                                                            </b-select>-->
                                                    <!--                                                        </b-field>-->

                                                    <!--                                                    </ValidationProvider>-->


                                                    <ValidationProvider
                                                        :rules="{ required: true,  min:1}"
                                                        name="budget"
                                                        v-slot="{ errors, valid }" slim
                                                    >
                                                        <b-field
                                                            :message="errors"
                                                            :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                            expanded
                                                        >
                                                            <p class="control">
                                                                <span
                                                                    class="button is-static" v-if="project.currency"
                                                                >{{ project.currency.name }} </span>
                                                            </p>
                                                            <b-input id="budget" type="text" min="1"
                                                                     placeholder=""
                                                                     name="budget"
                                                                     expanded
                                                                     v-model="bid.amount">

                                                            </b-input>

                                                        </b-field>


                                                    </ValidationProvider>


                                                </b-field>

                                                <ValidationProvider
                                                    persist
                                                    name="additional details"
                                                    :rules="{ required: false, min: 3, max:2000}"
                                                    v-slot="{ errors, valid }" slim
                                                >
                                                    <b-field
                                                        id="additional_details"
                                                        label="Additional Details"
                                                        label-class="t-mont t-bold"
                                                        label-for="additional_details"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    >
                                                        <b-input type="textarea"
                                                                 rows="3"
                                                                 no-resize
                                                                 id="textarea-default"
                                                                 placeholder="Any additional details"
                                                                 v-model="bid.additional_details"
                                                        ></b-input>


                                                    </b-field>
                                                </ValidationProvider>


                                                <b-field class="text-right">

                                                    <template
                                                        v-if="!showBidSubmittedSuccessfully && !bidSubmissionLoading">
                                                        <button type="is-primary" class="button bg-orange t-mont"
                                                                @click.prevent="handleSubmit(submitBid)">
                                                            Bid
                                                        </button>
                                                    </template>


                                                    <template v-if="showBidSubmittedSuccessfully">
                                                        <div type="is-primary" class="button is-success t-mont">
                                                            <b-icon class="is-white" icon="check-circle"/>
                                                        </div>
                                                    </template>

                                                    <template v-if="bidSubmissionLoading">

                                                        <div
                                                            class="loading-wrap"
                                                        >
                                                            Posting... <span></span>
                                                            <div class="loader"></div>
                                                        </div>

                                                    </template>


                                                </b-field>

                                            </form>


                                        </ValidationObserver>
                                    </template>


                                </template>


                                <template v-if="profileType ==='hire' || profileType ==='work&hire'">

                                    <div class="buttons">
                                        <!--                                        <router-link to="#" class="button is-primary">Post a similar Job</router-link>-->

                                        <template v-if="authenticated && project.user.id === user.id &&
                                        !project.worker_id">
                                            <router-link :to="{name:'editProject'}" class="button is-primary ">Edit this
                                                project
                                            </router-link>
                                        </template>

                                    </div>


                                </template>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </template>


        <template v-if="projectNotFound">
            <div class="jb-section">
                <div class="jb-404 text-center">

                    <div>
                        <p class="error t-mont t-orange">404</p>
                        <p class="t-mont">OOPS! the page you requested for was not found</p>
                    </div>

                </div>
            </div>
        </template>


    </div>

</template>

<script>
import {mapGetters} from "vuex";
import project from "../../router/project";

export default {
    name: "projects",
    metaInfo: {
        // if no subcomponents specify a metaInfo.title, this title will be used
        title: 'Freelance Projects',
    },
    data() {
        return {
            initialBidsToShow: 10,
            showBidsViewMore: 0,
            bidSubmitted: false,
            showBidSubmittedSuccessfully: false,
            bidSubmissionLoading: false,
            bidSubmittedSuccessfully: true,
            project: {
                category: {
                    name: '',
                },
                currency: {
                    symbol: '',
                },
                user: {
                    name: '',
                    profile: {}
                },
                skills: '',
                tags: '',
            },
            projectNotFound: false,
            currencies: [],

            bids: {},
            bid: {
                // project_id:'',
                currency: '',
                amount: '',
                additional_details: '',
            }

        }
    },
    beforeCreate() {


        axios.get(`projects/${this.$route.params.id}`).then(({data}) => {
            this.project = data.project;
            //this.bid.project_id= this.project.id;
            this.bid.currency = this.project.currency.id;
        }).catch(() => {
            this.projectNotFound = true;
        });

        axios.get('currencies').then(({data}) => {
            this.currencies = data.currencies;
        })


    },
    methods: {

        getValidationState({dirty, validated, valid = null}) {
            return dirty || validated ? valid : null;
        },

        submitBid() {
            this.bidSubmissionLoading = true;
            axios.post(`projects/${this.project.id}/bids`, this.bid).then(({data}) => {

                this.bidSubmissionLoading = false
                this.showBidSubmittedSuccessfully = true;
                this.bidSubmittedSuccessfully = true;
                this.bids.push(data.bid);
                setTimeout(() => {
                    this.showBidSubmittedSuccessfully = false;
                    this.bidSubmitted = true
                }, 10000)

            }).catch((e) => {

                this.bidSubmissionLoading = false;

            })
        },
        acceptBid(bid_id) {


            if (this.user.id === this.project.user_id) {


                this.$buefy.dialog.confirm({
                    title: 'Accept Bid',
                    message:
                        `Are You sure you want to <b>accept</b> this bid? <br> <span style="color: crimson"> *Please note that this cannot be undone</span>`,
                    cancelText: 'Cancel',
                    confirmText: 'Approve',
                    type: 'is-success',
                    onConfirm: () => {
                        let data = {
                            bid_id,
                            project_id: this.project.id
                        };
                        axios.post(`projects/${this.project.id}/accept_bid`, data).then(({data}) => {
                            this.project = data.project;
                            this.$router.push(`/projects/assigned/${this.project.id}`)
                        })
                    }
                })


            }
        },

    },
    computed: {

        exchangeAmount() {

            let exAmount = '';
            //get current project currency
            let pcExchange = this.project.currency.exchange_rate_in_usd;


            return exAmount;
        },
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            profileType: 'auth/profileType',
        }),

        hasAlreadyPlacedBid() {

            if (!this.project.bids) {
                return false;
            }

            if (this.authenticated) {
                let userBid = this.project.bids.find((bid) => {
                    return bid.user_id === this.user.id;
                });

                if (userBid) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            }


        }
    }
}
</script>

<style scoped>

</style>
