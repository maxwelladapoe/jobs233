<template>

    <div class="jb-main-section-wrapper">

        <template v-if="!projectNotFound && project">
            <div class="jb-section">
                <div class="container">

                    <div class="columns">
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


                                    <b-tag variant="success" class="mr-1">{{skill}}</b-tag>

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


                                        <b-tag class="mr-1" variant="success">{{tag}}</b-tag>

                                    </template>
                                </h5>
                            </template>


                            <template v-if="project.attachments && project.attachments.length >0">
                                <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Attachments</p>


                                <div class="columns mt-2">
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

                            <!--project submission -->


                        </div>

                        <div class="col-md-12 col-lg-4">
                            <p class="t-mont jb-project-title-small t-bold t-orange">Accepted Offer</p>
                            <p class="t-meri t-4 t-bold">{{acceptedBid.currency.symbol}} {{acceptedBid.amount}}</p>

                            <p class="t-mont jb-project-title-small t-bold t-orange">Official Budget</p>
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

                            <p class="t-meri"><span>Deadline</span>
                                <span class="t-6 badge pill badge-danger">
                                <timeago :datetime="project.deadline" :auto-update="60"/></span>
                            </p>
                            <hr>


                            <template v-if="profileType ==='hire' || profileType ==='work&hire'">

                                <router-link to="" class="btn bg-orange">Post a similar Job</router-link>

                                <template v-if="authenticated && project.user.id === user.id">
                                    <router-link to="" class="btn bg-orange ">Edit this job</router-link>
                                </template>
                            </template>

                        </div>


                        <div class="col-md-12 col-lg-8" v-if="acceptedBid.user_id === user.id">

                            <div>
                                <validationObserver v-slot="{handleSubmit}" ref="submitForReview">

                                    <b-form @submit.prevent="handleSubmit(submitForReview)">
                                        <validation-provider>

                                            <b-form-group


                                                id="status"
                                                label="Select Status"
                                                label-class="t-mont t-bold"
                                                label-for="select_status"
                                            >


                                                <b-select>
                                                    <b-select-option value="in-progress">
                                                        In progress
                                                    </b-select-option>
                                                    <b-select-option value="submitted-for-review">
                                                        Submitted for Review
                                                    </b-select-option>
                                                </b-select>

                                            </b-form-group>
                                        </validation-provider>


                                        <validation-provider>
                                            <b-form-group

                                                id="note"
                                                label="Add Note"
                                                label-class="t-mont t-bold"
                                                label-for="add_note"
                                            >
                                                <b-textarea rows="3" no-resize>
                                                </b-textarea>
                                            </b-form-group>

                                        </validation-provider>

                                        <b-form-group>
                                            <attach-files v-model="attachedFiles"></attach-files>

                                        </b-form-group>


                                        <b-form-group>
                                            <b-button type="submit">
                                                Submit
                                            </b-button>
                                        </b-form-group>

                                    </b-form>
                                </validationObserver>


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
    import AttachFiles from "../../components/extras/AttachFiles";

    export default {
        name: "projects",

        data() {
            return {

                attachedFiles: [],
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

                acceptedBid: {
                    currency: {
                        symbol: '',
                    },
                },

            }
        },
        beforeCreate() {

            axios.get(`projects/assigned/${this.$route.params.id}`).then(({data}) => {
                this.project = data.project;
                this.acceptedBid = data.accepted_bid;
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

            submitForReview() {
                console.log(this.attachedFiles)
            }
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
        },
        components: {
            AttachFiles
        }
    }
</script>

<style scoped>

</style>
