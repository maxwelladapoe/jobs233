<template>

    <div class="jb-main-section-wrapper">

        <template v-if="!projectNotFound && project">
            <div class="jb-section">
                <div class="container">

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 mb-5 pr-0 pr-lg-5">


                            <p class="t-bold jb-project-title-big t-mont ">{{project.title}}</p>

                            <p class="t-meri"> <span class="t-bold">
                                {{project.category.name}}
                            </span>

                                <span v-if="project.subcategory">> {{project.subcategory.name}}</span>
                            </p>

                            <p class="t-mont jb-project-title-small t-bold t-orange">Description</p>
                            <p class="t-meri">{{project.description}}</p>

                            <p class="t-mont jb-project-title-small t-bold t-orange">Skills</p>
                            <h5>
                                <template v-for="skill in project.skills.split(',')">


                                    <b-badge variant="success" class="mr-1">{{skill}}</b-badge>

                                </template>
                            </h5>


                            <template v-if="project.complexity">
                                <p class="t-mont jb-project-title-small t-bold t-orange">Complexity</p>
                                <p>{{project.complexity}}</p>
                            </template>


                            <template v-if="project.tags">
                                <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Tags</p>

                                <h5>
                                    <template v-for="tag in project.tags.split(',')">


                                        <b-badge class="mr-1" variant="success">{{tag}}</b-badge>

                                    </template>
                                </h5>
                            </template>


                            <template v-if="project.attachments && project.attachments.length >0">
                                <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Attachments</p>


                                <div class="row mt-2">
                                    <template v-for="attachment in project.attachments">


                                        <div class="col-4 col-lg-3">
                                            <div class="d-flex justify-content-between">

                                                <div>
                                                    <template
                                                        v-if="['xlsx','docx'].includes(attachment.name.split('.').pop().toLowerCase() )">
                                                        <img
                                                            src="/images/file_type_icons/doc.svg"
                                                            alt="" width="35">
                                                    </template>
                                                    <template v-else>
                                                        <img
                                                            :src="`/images/file_type_icons/${attachment.name.split('.').pop()}.svg`"
                                                            alt="" width="35">
                                                    </template>

                                                </div>

                                                <div class="ml-2">
                                                    <p class="t-6">{{ attachment.name }}</p>
                                                </div>


                                            </div>

                                        </div>

                                    </template>
                                </div>


                            </template>


                            <hr>
                            <p class="t-meri"><span>Deadline</span>
                                <span></span>
                                <timeago :datetime="project.deadline" :auto-update="60"/>
                            </p>
                            <hr>

                            <p class="t-mont jb-project-title-small t-bold t-orange">Activities on this Job</p>
                            <p class="t-meri m-0">Bids: {{project.bids_count}}</p>
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
                                                     :class="!bid.is_accepted && project.accepted_bid_id != null ? 'disabled':''">

                                                    <div class="top">
                                                        <div class="profile-details-wrap">

                                                            <div><p>
                                                                <img :src="bid.user.profile.picture" alt=""
                                                                     class="rounded-circle mr-2"
                                                                     width="30">
                                                                <span class="t-meri">{{bid.user.name}}</span></p>

                                                            </div>

                                                            <div>

                                                            </div>


                                                        </div>

                                                        <div class="bid-details-wrap">

                                                            <div>
                                                                <p class="t-meri text-right">
                                                                    <timeago :datetime="bid.created_at"
                                                                             :auto-update="60"/>
                                                                </p>
                                                                <p class="t-meri t-5">
                                                                    offer <span class="t-bold">{{bid.currency.symbol}} {{bid.amount}}</span>
                                                                </p>

                                                            </div>


                                                        </div>

                                                    </div>


                                                    <div class="bottom">
                                                        <div class="more-info-wrap">
                                                            <template v-if="bid.additional_details">
                                                                <p v-b-toggle="'collapse-'+bid.id+'-inner'" size="sm"
                                                                   class="t-orange t-6 text-right m-0"
                                                                   style="border: none; cursor: pointer">More info</p>

                                                                <b-collapse :id="'collapse-'+bid.id+'-inner'"
                                                                            class="mt-1">
                                                                    <div class="text-right mt-0 p-0">
                                                                        <p>{{bid.additional_details}}</p>
                                                                    </div>
                                                                </b-collapse>

                                                            </template>
                                                        </div>

                                                    </div>

                                                    <div class="w-100 text-right mt-2">

                                                        <template
                                                            v-if="!bid.is_accepted && project.accepted_bid_id == null">
                                                            <b-button @click.prevent="acceptBid(bid.id)"
                                                                      variant="success"
                                                                      class="ml-auto">
                                                                Accept Bid
                                                            </b-button>
                                                        </template>

                                                        <div v-if="bid.is_accepted" @click.prevent="acceptBid(bid.id)"
                                                             class="ml-auto text-success">
                                                            <b-icon icon="check-circle"/>
                                                            Accepted Bid
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

                        <div class="col-md-12 col-lg-4">
                            <p class="t-mont jb-project-title-small t-bold t-orange">Budget</p>
                            <p class="t-meri t-4 t-bold">{{project.currency.symbol}} {{project.budget}}</p>


                            <hr>

                            <p class="t-mont jb-project-title-small t-bold t-orange">Created
                                <timeago :datetime="project.created_at" :auto-update="60"/>
                                by
                            </p>

                            <p class="t-meri mt-2">

                                <img :src="project.user.profile.picture" width="50" class="mr-2 rounded-circle"/>
                                <span class="mr-auto" v-if="authenticated && (user.id === project.user.id)">You</span>
                                <span class="mr-auto" v-else>{{project.user.name}}</span>

                            </p>

                            <p>Joined
                                <timeago :datetime="project.user.created_at" :auto-update="60"></timeago>
                            </p>


                            <hr>


                            <template v-if="authenticated === false">

                                <p class="t-meri">To Be able to start working on this Job or others you need tto apply
                                    now.</p>
                                <p class="t-meri">This and other Jobs are available</p>

                                <router-link to="" class="btn bg-orange">Sign Up to get Hired</router-link>
                            </template>

                            <template
                                v-if="hasAlreadyPlacedBid && (profileType ==='work' || profileType ==='work&hire') ">
                                <p class="t-meri t-bold t-5">You have already placed a Bid</p>
                                <p>You should receive an email of confirmation if your bid has been accepted</p>
                                <router-link to="" class="btn bg-orange">Edit your Bid</router-link>
                                <router-link to="" class="btn bg-orange">View other projects</router-link>

                            </template>

                            <template
                                v-else-if=" !hasAlreadyPlacedBid && (profileType ==='work' || profileType ==='work&hire') ">

                                <p class="t-meri t-bold t-5">Interested in this project? <br>Bid now</p>

                                <p>I am willing to do this Job at</p>
                                <ValidationObserver v-slot="{handleSubmit}" ref="submitBidForm">

                                    <b-form @submit.prevent="handleSubmit(submitBid)">

                                        <b-form-group
                                            id="budget"
                                            label-class="t-mont t-bold"
                                            label-for="budget"
                                            :description="exchangeAmount"
                                        >

                                            <div class="form-row">
                                                <div class="col-3">
                                                    <validation-provider
                                                        :rules="{ required: true, integer:false}"
                                                        name="currency"
                                                        v-slot="validationContext"
                                                    >

                                                        <b-form-select id="budget" type="text"
                                                                       placeholder=""
                                                                       name="currency"
                                                                       :state="getValidationState(validationContext)"
                                                                       v-model="bid.currency"
                                                                       aria-describedby="currency-live-feedback">

                                                            <!-- This slot appears above the categories from 'categories' prop -->
                                                            <template v-slot:first>
                                                                <b-form-select-option :value="null" disabled>Select a
                                                                    currency
                                                                </b-form-select-option>
                                                            </template>


                                                            <b-select-option v-for="currency in currencies"
                                                                             :key="currency.id"
                                                                             :value="currency.id">{{currency.name}}
                                                            </b-select-option>

                                                        </b-form-select>

                                                        <b-form-invalid-feedback id="currency-live-feedback">
                                                            {{validationContext.errors[0] }}
                                                        </b-form-invalid-feedback>


                                                    </validation-provider>
                                                </div>

                                                <div class="col-9">
                                                    <validation-provider
                                                        :rules="{ required: true, integer:true, min:1}"
                                                        name="budget"
                                                        v-slot="validationContext"
                                                    >
                                                        <b-form-input id="budget" type="text" min="1"
                                                                      placeholder=""
                                                                      name="budget"
                                                                      :state="getValidationState(validationContext)"

                                                                      v-model="bid.amount"
                                                                      aria-describedby="budget-live-feedback">

                                                        </b-form-input>

                                                        <b-form-invalid-feedback id="budget-live-feedback">
                                                            {{validationContext.errors[0] }}
                                                        </b-form-invalid-feedback>

                                                    </validation-provider>
                                                </div>

                                            </div>

                                        </b-form-group>


                                        <validation-provider
                                            persist
                                            name="additional details"
                                            :rules="{ required: false, min: 3, max:2000}"
                                            v-slot="validationContext"
                                        >
                                            <b-form-group
                                                id="additional_details"
                                                label="Additional Details"
                                                label-class="t-mont t-bold"
                                                label-for="additional_details"
                                            >
                                                <b-form-textarea
                                                    rows="3"
                                                    no-resize
                                                    id="textarea-default"
                                                    :validation-icons="false"
                                                    :state="getValidationState(validationContext)"
                                                    placeholder="Any additional details"
                                                    v-model="bid.additional_details"
                                                ></b-form-textarea>

                                                <b-form-invalid-feedback id="additional_details-live-feedback">
                                                    {{validationContext.errors[0] }}
                                                </b-form-invalid-feedback>


                                            </b-form-group>
                                        </validation-provider>


                                        <b-form-group class="text-right">
                                            <button type="submit" class="btn bg-orange t-mont">
                                                Bid
                                            </button>
                                        </b-form-group>

                                    </b-form>


                                </ValidationObserver>
                            </template>


                            <template v-if="profileType ==='hire' || profileType ==='work&hire'">

                                <router-link to="" class="btn bg-orange">Post a similar Job</router-link>

                                <template v-if="authenticated && project.user.id === user.id">
                                    <router-link to="" class="btn bg-orange ">Edit this job</router-link>
                                </template>
                            </template>

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
                axios.post(`projects/${this.project.id}/bids`, this.bid).then(({data}) => {

                })
            },
            acceptBid(bid_id) {
                if (this.user.id === this.project.user_id) {
                    let data = {
                        bid_id,
                        project_id: this.project.id
                    };
                    axios.post(`projects/${this.project.id}/accept_bid`, data).then(({data}) => {
                        this.project = data.project;
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
