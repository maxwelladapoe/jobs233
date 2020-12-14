<template>
    <div class="jb-main-section-wrapper">

        <div class="jb-section">
            <div class="section no-padding-margin-top-bottom">
                <div class="container">


                    <div class="columns is is-multiline is-mobile">

                        <div class="column is-12-mobile is-6-tablet is-offset-3-tablet is-offset-0-desktop is-3-desktop  mb-5 ">

                            <form class="has-txt-center">
                                <div class="jb-profile-picture">
                                    <img class="is-rounded" style="border-radius: 50%"
                                         :src="imagePreview"
                                         :alt="user.name"/>
                                    <div class="upload-functions">
                                        <input type="file" name="file" ref="changeProfilePicture"
                                               @change="handleImageUpload" style="display:none"
                                               accept="image/*">
                                        <button class="change-btn button"
                                                @click.prevent="$refs['changeProfilePicture'].click()">
                                            <b-icon icon="pencil"/>
                                        </button>

                                    </div>
                                </div>
                                <b-button class="mt-3 button" type="is-success" v-if="showUploadButton"  @click.prevent="changeProfilePicture">Upload</b-button>
                            </form>

                            <div class=" mt-5">
                                <p>Skills</p>
                                <div class="">
                                        <ValidationObserver v-slot="{handleSubmit}" ref="skillsForm">
                                            <form @submit.prevent="handleSubmit(editProfile)">
                                                <ValidationProvider
                                                    persist slim
                                                    name="skills"
                                                    :rules="{ required: true, min: 3, max:150}"
                                                    v-slot="validationContext"
                                                >

                                                    <b-field expanded
                                                        id="skills">
                                                        <b-field class="mb-2">
                                                            <b-input
                                                                v-model="additionalSkill"
                                                                placeholder="Add Skill" expanded
                                                            ></b-input>

                                                            <b-button  @click="addSkill()" variant="primary">Add
                                                            </b-button>

                                                        </b-field>


                                                        <div class="d-inline-block" style="font-size: 1.5rem;">
                                                            <b-tag
                                                                v-for="skill in skills"
                                                                @remove="removeTag(skill)"
                                                                :key="skill"
                                                                :title="skill"
                                                                :variant="tagVariant"
                                                                class="mr-1"
                                                            >{{ skill }}
                                                            </b-tag>
                                                        </div>

                                                    </b-field>

                                                </ValidationProvider>

                                            </form>
                                        </ValidationObserver>
                                </div>
                            </div>


                        </div>


                        <div class="column is-12-mobile is-6-tablet is-offset-3-tablet is-8-desktop  is-offset-1-desktop ">
                            <p class="mb-5">Profile</p>


                            <div class="jb-project-form ">


                                <ValidationObserver v-slot="{handleSubmit}" ref="editProfile">
                                    <form @submit.prevent="handleSubmit(editProfile)">


                                        <ValidationProvider
                                            slim
                                            persist
                                            name="full name"
                                            :rules="{ required: true, min: 3, max:150}"
                                            v-slot="validationContext"
                                        >

                                            <b-field
                                                id="title"
                                                label="Full Name"
                                                label-class="t-mont t-bold"
                                                label-for="fullname">
                                                <b-input id="title" type="text"
                                                         rows="6"
                                                         placeholder=""
                                                         v-model="userDetails.name"
                                                         :state="getValidationState(validationContext)"
                                                         aria-describedby="fullname-live-feedback">

                                                </b-input>


                                            </b-field>

                                        </ValidationProvider>


                                        <b-field class="mb-5" grouped group-multiline>


                                            <ValidationProvider
                                                persist
                                                name="email"
                                                :rules="{ required: true, min: 3, max:2000}"
                                                v-slot="validationContext" slim
                                            >
                                                <b-field
                                                    id="email"
                                                    label="Email"
                                                    label-class="t-mont t-bold"
                                                    label-for="email"
                                                    expanded
                                                >
                                                    <b-input
                                                        :state="getValidationState(validationContext)"
                                                        id="textarea-default" disabled
                                                        v-model="user.email"
                                                        expanded
                                                    ></b-input>
                                                </b-field>
                                            </ValidationProvider>


                                            <ValidationProvider
                                                persist slim
                                                name="phone number"
                                                :rules="{ required: true, min: 3, max:2000}"
                                                v-slot="validationContext"
                                            >
                                                <b-field
                                                    id="phone_number"
                                                    label="Phone Number"
                                                    label-class="t-mont t-bold"
                                                    label-for="phone_number" expanded
                                                >
                                                    <b-input
                                                        :state="getValidationState(validationContext)"
                                                        id="phone-default" expanded
                                                        v-model="profileDetails.phone_number"
                                                    ></b-input>

                                                </b-field>
                                            </ValidationProvider>

                                        </b-field>


                                        <b-field class="mb-5" grouped group-multiline>


                                            <ValidationProvider
                                                persist slim
                                                name="gender"
                                                :rules="{ required: true, min:1}"
                                                v-slot="validationContext"
                                            >
                                                <b-field
                                                    id="gender"
                                                    label="Gender"
                                                    label-class="t-mont t-bold"
                                                    label-for="gender"
                                                >
                                                    <b-select
                                                        :state="getValidationState(validationContext)"
                                                        id="gender-default"
                                                        v-model="profileDetails.gender" placeholder="Select
                                                                Gender"
                                                    >


                                                        <option value="M">Male
                                                        </option>
                                                        <option value="F">Female
                                                        </option>
                                                        <option value="O">Rather not say
                                                        </option>
                                                    </b-select>
                                                </b-field>
                                            </ValidationProvider>


                                            <ValidationProvider
                                                persist slim
                                                name="bio"
                                                :rules="{ required: true, min: 3, max:2000}"
                                                v-slot="validationContext"
                                            >
                                                <b-field
                                                    id="bio"
                                                    label="Bio"
                                                    label-class="t-mont t-bold"
                                                    label-for="bio" expanded
                                                >
                                                    <b-input type="textarea"
                                                             rows="5"
                                                             no-resize
                                                             :state="getValidationState(validationContext)"
                                                             id="bio-default"
                                                             placeholder="Tell us about yourself"
                                                             v-model="profileDetails.bio" expanded
                                                    ></b-input>
                                                </b-field>
                                            </ValidationProvider>
                                        </b-field>

                                        <hr>

                                        <p class=" mb-5">Location Details</p>

                                        <b-field grouped group-multiline>
                                            <ValidationProvider
                                                persist slim
                                                name="country"
                                                :rules="{ required: true, min: 3, max:2000}"
                                                v-slot="validationContext"
                                            >
                                                <b-field
                                                    id="country"
                                                    label="Country"
                                                    label-class="t-mont t-bold"
                                                    label-for="country" expanded
                                                >
                                                    <b-input
                                                        :state="getValidationState(validationContext)"
                                                        id="country-default" expanded
                                                        v-model="profileDetails.country"
                                                    ></b-input>
                                                </b-field>
                                            </ValidationProvider>
                                            <ValidationProvider
                                                persist slim
                                                name="city"
                                                :rules="{ required: true, min: 3, max:2000}"
                                                v-slot="validationContext"
                                            >
                                                <b-field
                                                    id="city"
                                                    label="City"
                                                    label-class="t-mont t-bold"
                                                    label-for="city" expanded
                                                >
                                                    <b-input
                                                        :state="getValidationState(validationContext)"
                                                        id="city-default" expanded
                                                        v-model="profileDetails.city"
                                                    ></b-input>
                                                </b-field>
                                            </ValidationProvider>
                                        </b-field>


                                        <ValidationProvider
                                            persist
                                            name="address"
                                            :rules="{ required: true, min: 3, max:2000}"
                                            v-slot="validationContext"
                                        >
                                            <b-field
                                                id="address"
                                                label="Address"
                                                label-class="t-mont t-bold"
                                                label-for="address"
                                            >
                                                <b-input type="textarea"
                                                         no-resize
                                                         rows="2"
                                                         :state="getValidationState(validationContext)"
                                                         id="address-default"
                                                         v-model="profileDetails.address"
                                                ></b-input>
                                            </b-field>
                                        </ValidationProvider>


                                        <b-field>


                                            <div
                                                class=" mt-5 has-text-right d-flex align-items-start justify-content-end">

                                                <div
                                                    class=" mr-4 d-flex flex-wrap align-baseline justify-content-center"
                                                    v-if="profileUpdateLoading">
                                                    <p class="mr-2 p-0 m-0">Updating </p>
                                                    <div class="loader"></div>
                                                </div>

                                                <button type="submit" :class="profileUpdateLoading?'d-none':''"
                                                        class="button bg-orange">

                                                    Update Profile

                                                </button>

                                            </div>
                                        </b-field>

                                    </form>
                                </ValidationObserver>

                                <!--                                    <ValidationObserver v-slot="{handleSubmit}" ref="changePassword">-->
                                <!--                                        <b-form @submit.prevent="handleSubmit(changePassword)">-->

                                <!--                                            <p>Credentials</p>-->
                                <!--                                            <div class="row">-->
                                <!--                                                <div class="col-md-12">-->
                                <!--                                                    <ValidationProvider-->
                                <!--                                                        name="current password"-->
                                <!--                                                        :rules="{ required: true, min: 6}"-->
                                <!--                                                        v-slot="validationContext"-->
                                <!--                                                    >-->
                                <!--                                                        <b-field-->
                                <!--                                                            id="current_password"-->
                                <!--                                                            label="Current Password"-->
                                <!--                                                            label-class="t-mont t-bold"-->
                                <!--                                                            label-for="current_password"-->
                                <!--                                                        >-->
                                <!--                                                            <b-input type="password"-->
                                <!--                                                                          :state="getValidationState(validationContext)"-->
                                <!--                                                                          id="current_password"-->
                                <!--                                                                          v-model="credentials.currentPassword"-->
                                <!--                                                            ></b-input>-->

                                <!--                                                            <b-form-invalid-feedback-->
                                <!--                                                                id="current_password-live-feedback">-->
                                <!--                                                                {{validationContext.errors[0] }}-->
                                <!--                                                            </b-form-invalid-feedback>-->
                                <!--                                                        </b-field>-->
                                <!--                                                    </ValidationProvider>-->

                                <!--                                                </div>-->
                                <!--                                                <div class="col-md-6">-->
                                <!--                                                    <ValidationProvider-->
                                <!--                                                        persist-->
                                <!--                                                        name="country"-->
                                <!--                                                        :rules="{ required: true, min: 6}"-->
                                <!--                                                        v-slot="validationContext"-->
                                <!--                                                    >-->
                                <!--                                                        <b-field-->
                                <!--                                                            id="new_password"-->
                                <!--                                                            label="New Password"-->
                                <!--                                                            label-class="t-mont t-bold"-->
                                <!--                                                            label-for="new_password"-->
                                <!--                                                        >-->
                                <!--                                                            <b-input-->
                                <!--                                                                :state="getValidationState(validationContext)"-->
                                <!--                                                                id="textarea-default"-->
                                <!--                                                                v-model="credentials.newPassword"-->
                                <!--                                                            ></b-input>-->

                                <!--                                                            <b-form-invalid-feedback id="description-live-feedback">-->
                                <!--                                                                {{validationContext.errors[0] }}-->
                                <!--                                                            </b-form-invalid-feedback>-->
                                <!--                                                        </b-field>-->
                                <!--                                                    </ValidationProvider>-->

                                <!--                                                </div>-->
                                <!--                                                <div class="col-md-6">-->
                                <!--                                                    <ValidationProvider-->
                                <!--                                                        persist-->
                                <!--                                                        name="confirm_new_password"-->
                                <!--                                                        :rules="{ required: true, min: 6}"-->
                                <!--                                                        v-slot="validationContext"-->
                                <!--                                                    >-->
                                <!--                                                        <b-field-->
                                <!--                                                            id="confirm_new_password"-->
                                <!--                                                            label="Confirm New Password"-->
                                <!--                                                            label-class="t-mont t-bold"-->
                                <!--                                                            label-for="confirm_new_password"-->
                                <!--                                                        >-->
                                <!--                                                            <b-input-->
                                <!--                                                                :state="getValidationState(validationContext)"-->
                                <!--                                                                id="textarea-default"-->
                                <!--                                                                v-model="credentials.confirmNewPassword"-->
                                <!--                                                            ></b-input>-->

                                <!--                                                            <b-form-invalid-feedback id="description-live-feedback">-->
                                <!--                                                                {{validationContext.errors[0] }}-->
                                <!--                                                            </b-form-invalid-feedback>-->
                                <!--                                                        </b-field>-->
                                <!--                                                    </ValidationProvider>-->

                                <!--                                                </div>-->

                                <!--                                            </div>-->


                                <!--                                            <div class=" form-group mr-auto text-right">-->

                                <!--                                                <button type="submit" class="btn bg-orange t-mont">-->

                                <!--                                                    Change Password-->

                                <!--                                                </button>-->

                                <!--                                            </div>-->


                                <!--                                        </b-form>-->

                                <!--                                    </ValidationObserver>-->
                            </div>


                        </div>


                    </div>


                </div>
            </div>

        </div>
        <div class="jb-section">

            <div class="section">


            <div class="container">
                <div class="columns">

                    <div class="column is-12 ">
                        <div class="jb-title-with-icon mb-5 mt-5">
                            <div><p>Your Portfolio</p></div>
                            <div @click="showPortfolioForm = !showPortfolioForm" class="cursor-pointer t-6 t-orange">
                                <span><b-icon icon="plus-circle" size="is-small"/></span>
                                <span>Add Item</span>
                            </div>
                        </div>


                        <p v-if="!showPortfolioForm && portfolioItems.length<1">There are no items in your
                            portfolio</p>

                        <template v-if="showPortfolioForm">
                            <ValidationObserver v-slot="{handleSubmit}" ref="submitPortfolioForm">
                                <form @submit.prevent="handleSubmit(submitPortfolio)">
                                    <div class="jb-add-portfolio-item-form">
                                        <div class="form-img">
                                            <attach-single-file v-model="portfolio.file"></attach-single-file>
                                        </div>

                                        <div class="form-details mt-3">

                                            <b-field label="Title" label-class="t-bold t-mont">
                                                <b-input type="text"></b-input>
                                            </b-field>

                                            <b-field label="Description" label-class="t-bold t-mont">
                                                <b-input type="textarea" no-resize rows="4"></b-input>
                                            </b-field>
                                            <b-field label="Skills & Tools" label-class="t-bold t-mont">
                                                <b-taginput
                                                    ellipsis
                                                    icon="label"
                                                    placeholder="Skills / Tools used"

                                                    v-model="portfolio.skillsAndTools"
                                                        remove-on-delete>
                                                </b-taginput>

                                            </b-field>


                                            <b-field class="text-right">
                                                <b-button type="submit">Save</b-button>
                                            </b-field>
                                        </div>

                                    </div>


                                </form>
                            </ValidationObserver>
                        </template>

                    </div>

                </div>

            </div>

            </div>
        </div>


    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import AttachSingleFile from "../../components/extras/AttachSingleFile";

    export default {
        name: "EditProfile",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Edit Profile',
        },
        data() {
            return {
                userDetails: {},
                showUploadButton: false,
                showPortfolioForm: false,
                profileDetails: {
                    picture: '',
                    gender: null,
                },
                credentials: {
                    currentPassword: '',
                    newPassword: '',
                    confirmNewPassword: '',
                },
                imagePreview: null,
                file: '',
                profileUpdateLoading: false,
                showPortfolioItem: false,


                portfolio: {
                    file: new File([], "", undefined),
                    skillsAndTools: []

                },
                portfolioItems: [],
                allSkills: [],
                additionalSkill: '',
                skills: [],
            }
        },
        methods: {

            ...mapActions({
                refresh: 'auth/refresh'
            }),
            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },

            editProfile() {
                this.profileUpdateLoading = true;
                axios.patch('profile/', {...this.userDetails, ...this.profileDetails}).then(({data}) => {
                    this.profileUpdateLoading = false;
                    this.refresh();
                }).catch()
            },
            changePassword() {

            },

            addPortfolioItem() {

            },

            addSkill() {

            },
            removeTag() {

            },
            submitPortfolio() {
                axios.post(`${user.id}/portfolio`).then(({data}) => {

                })
            },

            handleImageUpload() {
                this.file = this.$refs.changeProfilePicture.files[0];

                let reader = new FileReader();

                reader.addEventListener("load", function () {

                    this.imagePreview = reader.result;
                }.bind(this), false);

                if (this.file) {

                    if (/\.(jpe?g|png|gif)$/i.test(this.file.name)) {
                        this.showUploadButton = true;
                        reader.readAsDataURL(this.file);
                    }
                }


            },
            changeProfilePicture() {

                let data = new FormData();
                const config = {}

                data.append('image', this.file);
                axios.post('profile/picture', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },

                    onUploadProgress: (progressEvent) => {
                        this.showUploadButton = false;
                        let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                        console.log(percentCompleted)
                    },


                }).then((data) => {
                    this.refresh();
                    console.log(data)
                })
            },


        },
        mounted() {
            this.profileDetails = {...this.user.profile};
            this.imagePreview = this.profileDetails.picture;
            this.userDetails = {...this.user};

            axios.get('skills').then(({data}) => {
                this.allSkills = data.skills;
            })
            delete this.userDetails.profile;
        },
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            })
        },
        components: {
            AttachSingleFile
        }
    }
</script>

<style scoped>

</style>
