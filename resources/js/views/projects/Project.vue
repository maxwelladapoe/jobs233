<template>

    <div class="jb-main-section-wrapper">

        <template v-if="!projectNotFound && project">
            <div class="jb-section">
                <div class="container">

                    <div class="row">
                        <div class="col-md-8">


                            <p class="t-bold jb-project-title-big t-mont mb-0">{{project.title}}</p>

                            <p class="t-bold">{{project.category.name}}
                                <br>
                                <span v-if="project.subcategory">{{project.subcategory.name}}</span>


                            </p>

                            <p class="t-mont jb-project-title-small t-orange">Description</p>
                            <p class="t-meri">{{project.description}}</p>

                            <p class="t-mont jb-project-title-small t-orange">Skills</p>
                            <h5>
                                <template v-for="skill in project.skills.split(',')">


                                    <b-badge variant="success" class="mr-1">{{skill}}</b-badge>

                                </template>
                            </h5>


                            <template v-if="project.complexity">
                                <p class="t-mont jb-project-title-small t-orange">Complexity</p>
                                <p>{{project.complexity}}</p>
                            </template>


                            <template v-if="project.tags">
                                <p class="t-mont jb-project-title-small t-orange">Tags</p>

                                <h5>
                                    <template v-for="tag in project.tags.split(',')">


                                        <b-badge class="mr-1" variant="success">{{tag}}</b-badge>

                                    </template>
                                </h5>
                            </template>


                            <hr>
                            <p>Deadline
                                <timeago :datetime="project.deadline" :auto-update="60"/>
                            </p>
                            <hr>


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


                            <template v-if="profileType ==='work' || profileType ==='work&hire'">

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
                                    <router-link to="" class="btn bg-orange mt-2 d-block">Edit this job</router-link>
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

        data() {
            return {
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
                bid: {
                    project_id:'',
                    currency: '',
                    amount: '',
                    additional_details: '',
                }

            }
        },
        beforeCreate() {

            axios.get(`projects/${this.$route.params.id}`).then(({data}) => {
                this.project = data.project;
                this.bid.project_id= this.project.id

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
                axios.post(`projects/${this.project.id}/bid`, this.bid).then(({data}) => {
                    console.log("BID ", data);
                })
            }

        },
        computed: {

            exchangeAmount() {

                let exAmount = '';
                //get current project currency
                let pcExhange = this.project.currency.exchange_rate_in_usd;


                return exAmount;
            },
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            })
        }
    }
</script>

<style scoped>

</style>
