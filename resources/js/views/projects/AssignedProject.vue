<template>

    <div class="jb-main-section-wrapper">

        <template v-if="!projectNotFound && project">
            <div class="jb-section">
                <div class="section no-padding-margin-top-bottom">
                    <div class="container">

                        <div class="columns is-multiline  ">
                            <div class=" column is-12 is-7-desktop">

                                <p class="t-bold jb-project-title-big t-mont mb-3">{{ project.title }}</p>

                                <p class="t-meri mb-3"> <span class="t-bold">
                                {{ project.category.name }}
                            </span>

                                    <span v-if="project.subcategory">> {{ project.subcategory.name }}</span>
                                </p>

                                <p class="t-mont jb-project-title-small t-bold t-orange">Description</p>
                                <p class="t-meri mb-3" v-html="project.description"></p>

                                <template v-if="project.skills">
                                    <p class="t-mont jb-project-title-small t-bold t-orange">Skills</p>
                                    <b-taglist>
                                        <template v-for="skill in project.skills.split(',')">


                                            <b-tag type="is-success" class="mr-1">{{ skill }}</b-tag>

                                        </template>
                                    </b-taglist>

                                </template>


                                <template v-if="project.complexity">
                                    <p class="t-mont jb-project-title-small t-bold t-orange">Complexity</p>
                                    <p class="mb-3">{{ project.complexity }}</p>
                                </template>


                                <template v-if="project.tags">
                                    <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Tags</p>

                                    <b-taglist>
                                        <template v-for="tag in project.tags.split(',')">

                                            <b-tag class="mr-1" type="is-success">{{ tag }}</b-tag>

                                        </template>
                                    </b-taglist>
                                </template>


                                <template v-if="project.attachments && project.attachments.length >0">
                                    <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Attachments</p>


                                    <div class="columns mt-2 is-multiline is-mobile">
                                        <template v-for="file in project.attachments">


                                            <div class="column is-12-mobile is-4-desktop ">


                                                <div class="box is-relative">
                                                    <a :href="file.location" download>
                                                        <div>

                                                            <div class="">

                                                                <template
                                                                    v-if="['xlsx','docx'].includes(file.name.split('.').pop().toLowerCase() )">
                                                                    <figure class="image is-32x32">
                                                                        <img
                                                                            src="/images/file_type_icons/doc.svg"
                                                                            alt="" width="35">
                                                                    </figure>
                                                                </template>
                                                                <template
                                                                    v-else-if="['jpg','jpeg','png','svg'].includes(file.name.split('.').pop().toLowerCase() )">
                                                                    <figure class="image">
                                                                        <img
                                                                            :src="file.location"
                                                                            alt="">
                                                                    </figure>
                                                                </template>
                                                                <template v-else>
                                                                    <figure class="image is-32x32">
                                                                        <img
                                                                            :src="`/images/file_type_icons/${file.name.split('.').pop()}.svg`"
                                                                            alt="" width="35">
                                                                    </figure>
                                                                </template>

                                                            </div>
                                                            <div class="jb-filename has-text-centered mt-2">
                                                                <p class="t-bold t-6 ">{{ file.name }}</p>
                                                                <!--                                                            <p class=" t-6">{{ formatBytes(file.size)}}</p>-->
                                                            </div>

                                                        </div>
                                                    </a>
                                                    <template v-if="file.user_id === user.id">
                                                        <button class="jb-close-button delete" type="button" rounded
                                                                size="is-small"
                                                                @click="deleteAttachment(file)"
                                                                title="Remove file">
                                                            <b-icon icon="close" size="is-small"/>
                                                        </button>
                                                    </template>


                                                </div>


                                            </div>

                                        </template>
                                    </div>


                                    <p class="t-6 text-success">
                                        <b-icon icon="information" size="is-small"/>
                                        Please note that non watermarked images are only available once payment
                                        is concluded
                                    </p>
                                </template>


                                <hr>

                                <!--project submission -->


                            </div>

                            <div class="column is-12 is-4-desktop is-offset-1-desktop">
                                <p class="t-mont jb-project-title-small t-bold t-orange">Accepted Offer</p>
                                <p class="t-meri t-4 t-bold mb-3">{{ acceptedBid.currency.symbol }}
                                    {{ acceptedBid.amount }}</p>


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
                                                                        class="t-meri">{{
                                                                            acceptedBid.user.name
                                                                        }}</span>
                                                                </p>
                                                            </div>
                                                        </router-link>
                                                        <div>

                                                        </div>


                                                    </div>

                                                    <div class="bid-details-wrap">
                                                        <div>
                                                            <p class="t-meri text-right t-6">
                                                                <timeago v-if="acceptedBid.created_at"
                                                                         :datetime="acceptedBid.created_at"
                                                                         :auto-update="60"/>
                                                            </p>
                                                            <p class="t-meri t-5">
                                                                offer <span
                                                                class="t-bold">{{
                                                                    acceptedBid.currency.symbol
                                                                }} {{ acceptedBid.amount }}</span>
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
                                                                    <p>{{ acceptedBid.additional_details }}</p>
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
                                project.payment_concluded ==0">
                                    <router-link :to="{name:'MakeDeposit' ,params:{project_id:project.id}}"
                                                 class="button is-primary mt-5">Make a
                                        deposit
                                        <b-icon icon="cash-plus" class="ml-2" size="is-small"/>
                                    </router-link>


                                </template>

                                <hr>

                                <p class="t-meri"><span>Deadline</span>
                                    <span class="t-6 badge pill badge-danger">
                                <timeago v-if="project.deadline" :datetime="project.deadline" :auto-update="60"/></span>
                                </p>

                                <hr>


                                <p class="t-mont jb-project-title-small t-bold t-orange">Created
                                    <timeago v-if='project.created_at' :datetime="project.created_at"
                                             :auto-update="60"/>
                                    by
                                </p>

                                <div class=" media t-meri mt-2">
                                    <figure class="media-left">

                                        <img :src="project.user.profile.picture" alt=""
                                             style="width: 50px; border-radius:50px">
                                    </figure>

                                    <div class="media-content">
                                        <router-link
                                            :to="{name:'ViewProfile', params:{username:project.user.username}}">
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


                                <template v-if="profileType ==='hire' || profileType ==='work&hire'">

                                    <hr>
                                    <div>
                                        <router-link :to=" {name:'createProject'}"
                                                     class="button is-primary mr-1 is-outlined">Post
                                            a
                                            similar
                                            Job
                                        </router-link>


                                        <template v-if=" project.user_id===user.id && project.worker_payed ===0 ">

                                            <b-button class="is-success" @click="markProjectAsCompleted">Mark as
                                                completed
                                            </b-button>
                                        </template>


                                    </div>


                                </template>
                                <hr>

                            </div>

                            <div class="column is-12 is-7-desktop">
                                <div>

                                    <p class="t-4 t-mont t-bold t-orange" v-if="acceptedBid.user_id === user.id">Update
                                        Status</p>
                                    <p class="t-3 t-mont t-bold" v-if="project.user_id === user.id"> Review Update</p>


                                    <template v-if="latestStatusUpdate">

                                        <div class="mt-2 mb-5 p-3 border">
                                            <p class="t-6 t-orange">
                                                <b-icon icon="update" size="is-small"/>
                                                <span>{{ latestStatusUpdate.status.replace('-', ' ') }}</span></p>
                                            <p>
                                                <b-icon icon="message" size="is-small"></b-icon>
                                                {{ latestStatusUpdate.message }}
                                            </p>
                                            <div class="t-6 mt-2">
                                                <div class="t-ash">


                                                    <timeago v-if='latestStatusUpdate.created_at'
                                                             :datetime="latestStatusUpdate.created_at"
                                                             :auto-update="60"/>
                                                </div>

                                                <div class="has-text-left t-orange">
                                                    <template
                                                        v-if="latestStatusUpdate.attachments && latestStatusUpdate.attachments.length>0">

                                                        <b-collapse :open="false" aria-id="contentIdForA11y1">
                                                            <template #trigger>
                                                                <b-icon icon="paperclip" size="is-small"/>
                                                                Attachments
                                                            </template>
                                                            <div class="mt-2">
                                                                <div class="content">

                                                                    <template
                                                                        v-for="file in latestStatusUpdate.attachments">

                                                                        <b-tag type="is-primary">
                                                                            <a :href="file.location" download
                                                                               class="mb-2">
                                                                                {{ file.name }}
                                                                            </a>
                                                                        </b-tag>

                                                                    </template>


                                                                </div>
                                                            </div>
                                                        </b-collapse>

                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                    </template>
                                    <ValidationObserver v-slot="{handleSubmit}" ref="projectStatusUpdateForm">

                                        <form class="is-relative">

                                            <b-loading :is-full-page="false" v-model="isLoading">
                                                <div class="loader-with-percentage-wrap">
                                                    <div class="loader-with-percentage"></div>
                                                    <div class="percentage t-orange">{{ uploadPercentage }}%</div>
                                                </div>

                                            </b-loading>
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
                                                              v-model="statusUpdate.status"
                                                              @input="changedSelection">

                                                        <template v-if="acceptedBid.user_id === user.id">
                                                            <option value="assigned" disabled>
                                                                Assigned
                                                            </option>

                                                            <option value="in-progress">
                                                                In progress
                                                            </option>
                                                            <option value="submitted-for-review">
                                                                Submitted for Review
                                                            </option>
                                                        </template>

                                                        <template v-if="project.user_id === user.id">


                                                            <option value="completed">
                                                                Completed
                                                            </option>

                                                            <option value="further-changes-required">
                                                                Further Changes Required
                                                            </option>

                                                            <option value="in-progress">
                                                                In progress
                                                            </option>


                                                            <option value="assigned" disabled style="color: #cdcdcd">
                                                                Assigned
                                                            </option>
                                                            <option value="submitted-for-review" disabled
                                                                    style="color: #cdcdcd">
                                                                Submitted For Review
                                                            </option>

                                                        </template>


                                                    </b-select>

                                                </b-field>
                                            </ValidationProvider>


                                            <ValidationProvider :rules="{ required: true}"
                                                                v-slot="{ errors, valid }"
                                                                name="Status update message" slim>
                                                <b-field
                                                    label="Message"
                                                    label-class="t-mont t-bold"
                                                    label-for="add_note"
                                                    :message="errors"
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


                            <div class="column is-12 is-4-desktop is-offset-1-desktop is-12 ">

                                <template v-if="statusUpdates.length> 0 ">
                                    <p class="t-bold">Recent Updates</p>

                                    <div class="mt-2 py-3 border" v-for="update in statusUpdates">
                                        <p class="t-6 t-orange">
                                            <b-icon icon="update" size="is-small"/>
                                            <span>{{ update.status.replace('-', ' ') }}</span></p>
                                        <p>
                                            <b-icon icon="message" size="is-small"></b-icon>
                                            {{ update.message }}
                                        </p>

                                        <div class="t-6 mt-2 ">
                                            <div class="has-text-left t-ash">
                                                <timeago v-if="update.created_at" :datetime="update.created_at"
                                                         :auto-update="60"/>
                                            </div>

                                            <div class="has-text-left t-orange">
                                                <template v-if="update.attachments && update.attachments.length>0">

                                                    <b-collapse :open="false" aria-id="contentIdForA11y1">
                                                        <template #trigger>
                                                            <b-icon icon="paperclip" size="is-small"/>
                                                            Attachments
                                                        </template>
                                                        <div class="mt-2">
                                                            <div class="content">

                                                                <template v-for="file in update.attachments">
                                                                    <a :href="file.location" download class="mb-2">
                                                                        <b-tag type="is-primary">
                                                                            {{ file.name }}
                                                                        </b-tag>
                                                                    </a>
                                                                </template>

                                                            </div>
                                                        </div>
                                                    </b-collapse>

                                                </template>
                                            </div>

                                        </div>


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
                    <div class="section no-padding-margin-top-bottom">

                        <div class="container">
                            <p class="error t-meri t-orange">OOPS!</p>
                            <p class="mb-5">We are sorry for the inconvenience. <br> The project you are trying to
                                access does not
                                exist or has been deleted</p>
                            <router-link to="/">
                                <b-button type="is-primary">Go Home</b-button>
                            </router-link>
                        </div>

                    </div>

                </div>
            </div>
        </template>


    </div>

</template>

<script>
import {mapGetters} from "vuex";
import AttachFiles from "../../components/extras/AttachFiles";
import {SnackbarProgrammatic as Snackbar} from 'buefy';
import ReviewAndRating from "../../components/ReviewAndRating";

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
            isLoading: false,
            uploadPercentage: 0,
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

        changedSelection(event) {
            //if the selection is  is completed
            if (event === "completed" && this.project.status !=='completed') {
                this.$buefy.dialog.confirm({
                    title: 'Mark as completed',
                    message:
                        'Are you sure you want to <b>mark this project as completed</b> ',
                    confirmText: 'Yes',
                    cancelText: 'No',
                    type: 'is-primary',
                    onCancel: () => {
                        this.statusUpdate.status = this.project.status;
                        return
                    },
                    onConfirm: () => {
                        this.markProjectAsCompleted();
                    }
                })
            }
        },

        getValidationState({dirty, validated, valid = null}) {
            return dirty || validated ? valid : null;
        },

        projectStatusUpdate() {

            let isHire = ((this.profileType === "hire" || this.profileType === "work&hire") && this.project.user_id !==
                this.user.id);

            let isWork = ((this.profileType === "work" || this.profileType === "work&hire") && this.acceptedBid.user_id !==
                this.user.id);

            if (isHire || isWork) {
                console.log("issue dey here");
                return
            }

            let allowedStatuses = [];
            //set the allowed list and check if a user is authorised
            if (this.project.user_id === this.user.id) {
                allowedStatuses = [
                    "completed",
                    "further-changes-required",
                    "in-progress",
                    "assigned",
                    "submitted-for-review"
                ];


            } else if (this.acceptedBid.user_id === this.user.id) {
                allowedStatuses = [
                    "further-changes-required",
                    "in-progress",
                    "assigned",
                    "submitted-for-review"

                ];

            } else {
                console.log("not authorised");
                return
            }


            //check if the status is in the allowed list
            if (!allowedStatuses.includes(this.statusUpdate.status)) {

                console.log("item not in the allowed list");
                return
            }

            console.log("this one ");
            console.log(this.statusUpdate.status === 'completed');


            if (this.statusUpdate.status === 'completed') {
                //check if the worker has been payed or payment has been finalised

                this.markProjectAsCompleted();


            } else {

                if (this.project.status === 'assigned') {
                    this.statusUpdate.status = 'in-progress'
                }

                this.isLoading = true;
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
                        this.uploadPercentage = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    }
                };


                axios.post('projects/update-status', formData, config)
                    .then(({data}) => {

                        this.project = data.project;
                        this.statusUpdates.unshift(this.latestStatusUpdate);
                        this.latestStatusUpdate = data.status_update;

                        this.statusUpdate = {
                            project_id: this.project.id,
                            status: this.project.status,
                            message: ''
                        }
                        this.uploadedFileList = [];
                        this.isLoading = false;
                        Snackbar.open(data.message);

                        this.$refs.projectStatusUpdateForm.reset();

                    }).catch(e => {
                    this.$refs.projectStatusUpdateForm.setErrors({...e.response.data.errors})

                    console.log(e);
                    this.isLoading = false;
                })

            }


        },

        showPayDialog() {
            this.$buefy.dialog.confirm({
                title: `Payment hasn't been completed`,
                message:
                    `It seems you haven't finalized payment for this project. Please click on the  <b>proceed</b> button to do so`,
                confirmText: 'Proceed',
                canCancel: true,
                onCancel: () => {
                    return
                },
                onConfirm: () => {
                    this.$router.push({name: 'MakeDeposit', params: {project_id: this.project.id}});
                }

            })
        },
        markAsCompletePost() {
            axios.post('projects/mark_as_completed', {project_id: this.project.id}).then(({data}) => {
                this.project = data.project;
                Snackbar.open(data.message);
            }).catch((e) => {
                console.log(e);
            })

        },
        markProjectAsCompleted() {


            if (this.project.user_id === this.user.id) {


                 if (this.project.worker_payed === 0 && this.project.payment_concluded === 1) {

                    //launch the modal here

                    this.$buefy.modal.open({
                        parent: this,
                        component: ReviewAndRating,
                        props: {projectId: this.project.id},
                        hasModalCard: true,
                        customClass: 'custom-class custom-class-2',
                        trapFocus: true,
                        events: {
                            'submitRating': response => {
                                //this.portfolioItems.push(item);
                                if (response.success === true) {
                                    Snackbar.open(response.message);
                                    this.markAsCompletePost();

                                } else {

                                }

                            },
                            'skipRating': () => {
                               this.markAsCompletePost();
                            }
                        }
                    })


                    //mark the project as complete


                    //submit rating and review


                } else {
                    //show modal about concluding payment

                    this.showPayDialog();


                }


            }


        },

        deleteAttachment(attachment) {

            this.$buefy.dialog.confirm({
                title: 'Deleting Attachment',
                message: 'Are you sure you want to <b>delete</b> this attachment? This action cannot be undone.',
                confirmText: 'Delete',
                type: 'is-danger',
                closeOnConfirm: true,
                onConfirm: () => {
                    axios.delete(`/attachments/delete/${attachment.id}`).then(({data}) => {
                        let index = this.project.attachments.indexOf(attachment);
                        this.project.attachments.splice(index, 1);
                        Snackbar.open(data.message);

                    }).catch((e) => {
                        console.log(e);
                    })
                }
            })

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
