<template>

    <div class="jb-main-section-wrapper">

        <template v-if="!projectNotFound && project">
            <div class="jb-section">
                <div class="section no-padding-margin-top-bottom">
                    <div class="container">

                        <div class="columns is-multiline  ">
                            <div class=" column is-12 is-8-desktop">

                                <p class="t-bold jb-project-title-big t-mont mb-3">{{project.title}}</p>

                                <p class="t-meri mb-3"> <span class="t-bold">
                                {{project.category.name}}
                            </span>

                                    <span v-if="project.subcategory">> {{project.subcategory.name}}</span>
                                </p>

                                <p class="t-mont jb-project-title-small t-bold t-orange">Description</p>
                                <p class="t-meri mb-3" v-html="project.description"></p>

                                <p class="t-mont jb-project-title-small t-bold t-orange">Skills</p>
                                <b-taglist>
                                    <template v-for="skill in project.skills.split(',')">


                                        <b-tag type="is-success" class="mr-1">{{skill}}</b-tag>

                                    </template>
                                </b-taglist>


                                <template v-if="project.complexity">
                                    <p class="t-mont jb-project-title-small t-bold t-orange">Complexity</p>
                                    <p class="mb-3">{{project.complexity}}</p>
                                </template>


                                <template v-if="project.tags">
                                    <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Tags</p>

                                    <b-taglist>
                                        <template v-for="tag in project.tags.split(',')">

                                            <b-tag class="mr-1" type="is-success">{{tag}}</b-tag>

                                        </template>
                                    </b-taglist>
                                </template>


                                <template v-if="project.attachments && project.attachments.length >0">
                                    <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Attachments</p>


                                    <div class="columns mt-2">
                                        <template v-for="attachment in project.attachments">


                                            <div class="col-4 col-lg-3">
                                                <a :href="attachment.location" download>


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
                                                </a>
                                            </div>

                                        </template>
                                    </div>


                                </template>


                                <hr>

                                <!--project submission -->


                            </div>

                            <div class="column is-12 is-4-desktop ">
                                <p class="t-mont jb-project-title-small t-bold t-orange">Accepted Offer</p>
                                <p class="t-meri t-4 t-bold mb-3">{{acceptedBid.currency.symbol}}
                                    {{acceptedBid.amount}}</p>


                                <!-- Placed bids -->
                                <template v-if=" authenticated && user &&( project.user_id === user.id)">

                                    <!--if the project bids are available and the bids count is greater than zero -->
                                    <template v-if="acceptedBid">


                                        <div class="jb-bids-wrap">
                                            <div class="jb-bid">

                                                <div class="top">
                                                    <div class="profile-details-wrap">
                                                        <router-link
                                                            :to="{name:'ViewProfile',params:{username:acceptedBid.user.username}}">

                                                            <div>
                                                                <p>
                                                                    <b-image class="" rounded
                                                                             :src="acceptedBid.user.profile.picture"
                                                                             alt=""
                                                                    />
                                                                    <span
                                                                        class="t-meri">{{acceptedBid.user.name}}</span>
                                                                </p>
                                                            </div>
                                                        </router-link>
                                                        <div>

                                                        </div>


                                                    </div>

                                                    <div class="bid-details-wrap">
                                                        <div>
                                                            <p class="t-meri text-right t-6">
                                                                <timeago :datetime="acceptedBid.created_at"
                                                                         :auto-update="60"/>
                                                            </p>
                                                            <p class="t-meri t-5">
                                                                offer <span class="t-bold">{{acceptedBid.currency.symbol}} {{acceptedBid.amount}}</span>
                                                            </p>
                                                        </div>


                                                    </div>

                                                </div>


                                                <div class="bottom">
                                                    <div class="more-info-wrap">
                                                        <template v-if="acceptedBid.additional_details">


                                                            <b-collapse :open="false"
                                                                        :aria-id="'content-'+acceptedBid.id+'-ally'"
                                                                        class="mt-1">
                                                                <p :aria-controls="'content-'+acceptedBid.id+'-ally'"
                                                                   slot="trigger"
                                                                   class="t-orange t-6 text-right m-0"
                                                                   style="border: none; cursor: pointer">More
                                                                    info</p>


                                                                <div class="text-right mt-0 p-0">
                                                                    <p>{{acceptedBid.additional_details}}</p>
                                                                </div>
                                                            </b-collapse>

                                                        </template>
                                                    </div>

                                                </div>


                                            </div>

                                        </div>


                                    </template>
                                </template>
                                <!-- Placed bids -->

                                <template v-if="authenticated && project.user.id === user.id &&
                                project.payment_concluded ===0">
                                    <router-link :to="{name:'MakeDeposit' ,params:{'project_id':project.id}}"
                                                 class="button is-primary mt-5">Make a
                                        deposit
                                        <b-icon icon="cash-plus" class="ml-2" size="is-small"/>
                                    </router-link>


                                </template>

                                <hr>

                                <p class="t-meri"><span>Deadline</span>
                                    <span class="t-6 badge pill badge-danger">
                                <timeago :datetime="project.deadline" :auto-update="60"/></span>
                                </p>

                                <hr>


                                <p class="t-mont jb-project-title-small t-bold t-orange">Created
                                    <timeago :datetime="project.created_at" :auto-update="60"/>
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
                                            <span class="mr-auto" v-else>{{project.user.name}}</span>
                                        </router-link>
                                        <p class="t-6 t-orange">Joined
                                            <timeago :datetime="project.user.created_at" :auto-update="60"></timeago>
                                        </p>
                                    </div>

                                </div>


                                <template v-if="profileType ==='hire' || profileType ==='work&hire'">

                                    <hr>

                                    <router-link to="" class="button bg-orange">Post a similar Job</router-link>

                                </template>

                            </div>

                            <div class="column is-12 is-8-desktop">
                                <div v-if="acceptedBid.user_id === user.id">

                                    <p class="t-4 t-mont t-bold t-orange">Update Status</p>
                                    <ValidationObserver v-slot="{handleSubmit}" ref="projectStatusUpdate">

                                        <form>
                                            <ValidationProvider
                                                :rules="{ required: true}"
                                                v-slot="{ errors, valid }"
                                                name="Status" slim>

                                                <b-field

                                                    label="Status"
                                                    label-class="t-mont t-bold"
                                                    label-for="select_status"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    expanded
                                                >
                                                    <b-select expanded placeholder="Select Project Status"
                                                              v-model="statusUpdate.status">

                                                        <option value="assigned" disabled>
                                                            Assigned
                                                        </option>

                                                        <option value="in-progress">
                                                            In progress
                                                        </option>
                                                        <option value="submitted-for-review">
                                                            Submitted for Review
                                                        </option>
                                                    </b-select>

                                                </b-field>
                                            </ValidationProvider>


                                            <ValidationProvider :rules="{ required: true}"
                                                                v-slot="{ errors, valid }"
                                                                name="Message" slim>
                                                <b-field
                                                    label="Message"
                                                    label-class="t-mont t-bold"
                                                    label-for="add_note"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"

                                                >
                                                    <b-input
                                                        type="textarea"
                                                        placeholder="Enter message here"
                                                        rows="3"
                                                        v-model="statusUpdate.message"
                                                        no-resize>
                                                    </b-input>
                                                </b-field>

                                            </ValidationProvider>


                                            <b-field>
                                                <attach-files v-model="uploadedFileList"></attach-files>

                                            </b-field>


                                            <b-field>
                                                <b-button type="is-success"
                                                          @click.prevent="handleSubmit(projectStatusUpdate)">
                                                    Submit
                                                </b-button>
                                            </b-field>

                                        </form>
                                    </ValidationObserver>

                                </div>

                                <div v-if="project.user_id === user.id">
                                    <p class="t-3 t-mont t-bold"> Review Update</p>

                                    <template v-if="latestStatusUpdate">

                                        <div class="mt-2 mb-3 p-3 border">
                                            <p class="t-6 t-orange">
                                                <b-icon icon="update" size="is-small"/>
                                                <span>{{latestStatusUpdate.status.replace('-',' ')}}</span></p>
                                            <p>
                                                <b-icon icon="message" size="is-small"></b-icon>
                                                {{latestStatusUpdate.message}}
                                            </p>
                                            <p class="t-6 mt-2 t-ash text-right">
                                                <timeago :datetime="latestStatusUpdate.created_at" :auto-update="60"/>
                                            </p>
                                        </div>

                                    </template>


                                    <ValidationObserver v-slot="{handleSubmit}" ref="projectStatusUpdate">

                                        <form>
                                            <ValidationProvider
                                                :rules="{ required: true}"
                                                v-slot="{ errors, valid }"
                                                name="Status" slim>

                                                <b-field
                                                    id="status"
                                                    label="Status"
                                                    label-class="t-mont t-bold"
                                                    label-for="select_status"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    expanded
                                                >
                                                    <b-select expanded placeholder="Select Project Status"
                                                              v-model="statusUpdate.status">


                                                        <option value="completed">
                                                            Completed
                                                        </option>

                                                        <option value="further-changes-required">
                                                            Further Changes Required
                                                        </option>


                                                        <option value="assigned" disabled style="color: #cdcdcd">
                                                            Assigned
                                                        </option>
                                                        <option value="submitted-for-review" disabled
                                                                style="color: #cdcdcd">
                                                            Submitted For Review
                                                        </option>

                                                        <option value="in-progress" disabled style="color: #cdcdcd">
                                                            In progress
                                                        </option>

                                                    </b-select>

                                                </b-field>
                                            </ValidationProvider>


                                            <ValidationProvider :rules="{ required: true}"
                                                                v-slot="{ errors, valid }"
                                                                name="Message" slim>
                                                <b-field

                                                    id="message"
                                                    label="Message"
                                                    label-class="t-mont t-bold"
                                                    label-for="add_note"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"

                                                >
                                                    <b-input
                                                        type="textarea"
                                                        placeholder="Enter message here"
                                                        rows="3"
                                                        v-model="statusUpdate.message"
                                                        no-resize>
                                                    </b-input>
                                                </b-field>

                                            </ValidationProvider>


                                            <b-field>
                                                <attach-files v-model="uploadedFileList"></attach-files>

                                            </b-field>


                                            <b-field>
                                                <b-button type="is-success"
                                                          @click.prevent="handleSubmit(projectStatusUpdate)">
                                                    Submit
                                                </b-button>
                                            </b-field>

                                        </form>
                                    </ValidationObserver>


                                </div>
                            </div>


                            <div class="column is-4-desktop is-12 ">

                                <template v-if="statusUpdates.length> 0 ">
                                    <p class="t-bold">Recent Updates</p>

                                    <div class="mt-2 p-3 border" v-for="update in statusUpdates">
                                        <p class="t-6 t-orange">
                                            <b-icon icon="update" size="is-small"/>
                                            <span>{{update.status.replace('-',' ')}}</span></p>
                                        <p>
                                            <b-icon icon="message" size="is-small"></b-icon>
                                            {{update.message}}
                                        </p>
                                        <p class="t-6 mt-2 t-ash text-right">
                                            <timeago :datetime="update.created_at" :auto-update="60"/>
                                        </p>
                                    </div>

                                </template>


                                <template v-if="(statusUpdate.status === 'submitted-for-review' ||
                                statusUpdate.status === 'completed') &&
                                project.user_id===user.id && project.worker_payed ===0
                                ">
                                    <hr>
                                    <p>If this project is completed</p>
                                    <b-button class="mt-2 is-success" @click="markProjectAsCompleted">Mark as
                                        completed
                                    </b-button>
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
                    <div class="section no-padding-margin-top-bottom">

                        <div class="container">
                            <p class="error t-mont t-orange">404</p>
                            <p class="t-mont">OOPS! the page you requested for was not found</p>
                        </div>

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
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Assigned Project',
        },

        data() {
            return {
                uploadedFileList: [],
                initialBidsToShow: 10,
                showBidsViewMore: 0,
                statusUpdates: [],
                latestStatusUpdate: '',
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

                statusUpdate: {
                    project_id: '',
                    status: '',
                    message: ''
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
                this.statusUpdate.status = this.project.status;
                this.statusUpdate.project_id = this.project.id;


                this.acceptedBid = data.accepted_bid;

                this.statusUpdates = data.status_updates;
                this.latestStatusUpdate = data.latest_status_update;


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
            },
            projectStatusUpdate() {

                if (this.project.status === 'assigned') {
                    this.statusUpdate.status = 'in-progress'
                }
                let formData = new FormData();

                for (let i = 0; i < this.uploadedFileList.length; i++) {
                    formData.append('attachments[' + i + ']', this.uploadedFileList[i]);
                }
                for (let key in this.statusUpdate) {
                    formData.append(key, this.statusUpdate[key]);
                }
                const config = {

                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },

                    onUploadProgress: (progressEvent) => {
                        let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    }
                };
                axios.post('projects/update-status', formData, config)
                    .then(({data}) => {
                        this.project = data.project;
                    })
            },
            markProjectAsCompleted() {


                if (this.project.user_id === this.user.id) {


                    if (this.project.worker_payed === 0 && this.project.payment_concluded === 1) {
                        axios.post('projects/mark_as_completed', {project_id: this.project.id}).then(({data}) => {
                            this.project = data.project;
                        }).catch((e) => {
                            console.log(e);
                        })
                    }


                }


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
