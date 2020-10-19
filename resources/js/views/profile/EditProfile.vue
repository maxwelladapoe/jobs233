<template>
    <div class="jb-main-section-wrapper">

        <div class="jb-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 mx-auto  ">
                        <div class="row">
                            <div class="col-12 col-lg-9 order-1 order-md-0">
                                <p>Profile</p>
                                <div class="jb-project-form pr-3">


                                    <ValidationObserver v-slot="{handleSubmit}" ref="editProfile">
                                        <b-form @submit.prevent="handleSubmit(editProfile)">


                                            <div class="row">

                                                <div class="col-md-12">
                                                    <validation-provider
                                                        persist
                                                        name="full name"
                                                        :rules="{ required: true, min: 3, max:150}"
                                                        v-slot="validationContext"
                                                    >

                                                        <b-form-group
                                                            id="title"
                                                            label="Full Name"
                                                            label-class="t-mont t-bold"
                                                            label-for="fullname">
                                                            <b-form-input id="title" type="text"
                                                                          rows="6"
                                                                          placeholder=""
                                                                          v-model="userDetails.name"
                                                                          :state="getValidationState(validationContext)"
                                                                          aria-describedby="fullname-live-feedback">

                                                            </b-form-input>

                                                            <b-form-invalid-feedback id="title-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>


                                                        </b-form-group>

                                                    </validation-provider>

                                                </div>
                                                <div class="col-md-6">
                                                    <validation-provider
                                                        persist
                                                        name="email"
                                                        :rules="{ required: true, min: 3, max:2000}"
                                                        v-slot="validationContext"
                                                    >
                                                        <b-form-group
                                                            id="email"
                                                            label="Email"
                                                            label-class="t-mont t-bold"
                                                            label-for="email"
                                                        >
                                                            <b-form-input
                                                                :state="getValidationState(validationContext)"
                                                                id="textarea-default" disabled
                                                                v-model="user.email"
                                                            ></b-form-input>

                                                            <b-form-invalid-feedback id="description-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>
                                                        </b-form-group>
                                                    </validation-provider>

                                                </div>
                                                <div class="col-md-6">
                                                    <validation-provider
                                                        persist
                                                        name="phone number"
                                                        :rules="{ required: true, min: 3, max:2000}"
                                                        v-slot="validationContext"
                                                    >
                                                        <b-form-group
                                                            id="phone_number"
                                                            label="Phone Number"
                                                            label-class="t-mont t-bold"
                                                            label-for="phone_number"
                                                        >
                                                            <b-form-input
                                                                :state="getValidationState(validationContext)"
                                                                id="phone-default"
                                                                v-model="profileDetails.phone_number"
                                                            ></b-form-input>

                                                            <b-form-invalid-feedback id="phone-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>
                                                        </b-form-group>
                                                    </validation-provider>

                                                </div>
                                                <div class="col-md-3">
                                                    <validation-provider
                                                        persist
                                                        name="gender"
                                                        :rules="{ required: true, min:1}"
                                                        v-slot="validationContext"
                                                    >
                                                        <b-form-group
                                                            id="gender"
                                                            label="Gender"
                                                            label-class="t-mont t-bold"
                                                            label-for="gender"
                                                        >
                                                            <b-form-select
                                                                :state="getValidationState(validationContext)"
                                                                id="gender-default"
                                                                v-model="profileDetails.gender"
                                                            >

                                                                <template v-slot:first>
                                                                    <b-form-select-option :value="null" disabled> Select
                                                                        Gender
                                                                    </b-form-select-option>
                                                                </template>

                                                                <b-form-select-option value="M">Male
                                                                </b-form-select-option>
                                                                <b-form-select-option value="F">Female
                                                                </b-form-select-option>
                                                                <b-form-select-option value="O">Rather not say
                                                                </b-form-select-option>
                                                            </b-form-select>

                                                            <b-form-invalid-feedback id="gender-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>
                                                        </b-form-group>
                                                    </validation-provider>

                                                </div>
                                                <div class="col-md-9">
                                                    <validation-provider
                                                        persist
                                                        name="bio"
                                                        :rules="{ required: true, min: 3, max:2000}"
                                                        v-slot="validationContext"
                                                    >
                                                        <b-form-group
                                                            id="bio"
                                                            label="Bio"
                                                            label-class="t-mont t-bold"
                                                            label-for="bio"
                                                        >
                                                            <b-form-textarea
                                                                rows="4"
                                                                no-resize
                                                                :state="getValidationState(validationContext)"
                                                                id="bio-default"
                                                                v-model="profileDetails.bio"
                                                            ></b-form-textarea>

                                                            <b-form-invalid-feedback id="bio-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>
                                                        </b-form-group>
                                                    </validation-provider>

                                                </div>


                                            </div>


                                            <p>Location Details</p>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <validation-provider
                                                        persist
                                                        name="country"
                                                        :rules="{ required: true, min: 3, max:2000}"
                                                        v-slot="validationContext"
                                                    >
                                                        <b-form-group
                                                            id="country"
                                                            label="Country"
                                                            label-class="t-mont t-bold"
                                                            label-for="country"
                                                        >
                                                            <b-form-input
                                                                :state="getValidationState(validationContext)"
                                                                id="country-default"
                                                                v-model="profileDetails.country"
                                                            ></b-form-input>

                                                            <b-form-invalid-feedback id="country-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>
                                                        </b-form-group>
                                                    </validation-provider>

                                                </div>
                                                <div class="col-md-6">
                                                    <validation-provider
                                                        persist
                                                        name="city"
                                                        :rules="{ required: true, min: 3, max:2000}"
                                                        v-slot="validationContext"
                                                    >
                                                        <b-form-group
                                                            id="city"
                                                            label="City"
                                                            label-class="t-mont t-bold"
                                                            label-for="city"
                                                        >
                                                            <b-form-input
                                                                :state="getValidationState(validationContext)"
                                                                id="city-default"
                                                                v-model="profileDetails.city"
                                                            ></b-form-input>

                                                            <b-form-invalid-feedback id="city-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>
                                                        </b-form-group>
                                                    </validation-provider>

                                                </div>

                                                <div class="col-md-12">
                                                    <validation-provider
                                                        persist
                                                        name="address"
                                                        :rules="{ required: true, min: 3, max:2000}"
                                                        v-slot="validationContext"
                                                    >
                                                        <b-form-group
                                                            id="address"
                                                            label="Address"
                                                            label-class="t-mont t-bold"
                                                            label-for="address"
                                                        >
                                                            <b-form-textarea
                                                                no-resize
                                                                rows="4"
                                                                :state="getValidationState(validationContext)"
                                                                id="address-default"
                                                                v-model="profileDetails.address"
                                                            ></b-form-textarea>

                                                            <b-form-invalid-feedback id="address-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>
                                                        </b-form-group>
                                                    </validation-provider>

                                                </div>

                                            </div>


                                            <div
                                                class="form-group text-right d-flex align-items-start justify-content-end">

                                                <div
                                                    class=" mr-4 d-flex flex-wrap align-baseline justify-content-center"
                                                    v-if="profileUpdateLoading">
                                                    <p class="mr-2 p-0 m-0">Updating </p>
                                                    <div class="loader"></div>
                                                </div>

                                                <button type="submit" :class="profileUpdateLoading?'d-none':''"
                                                        class="btn bg-orange">

                                                    Update Profile

                                                </button>

                                            </div>


                                        </b-form>
                                    </ValidationObserver>

<!--                                    <ValidationObserver v-slot="{handleSubmit}" ref="changePassword">-->
<!--                                        <b-form @submit.prevent="handleSubmit(changePassword)">-->

<!--                                            <p>Credentials</p>-->
<!--                                            <div class="row">-->
<!--                                                <div class="col-md-12">-->
<!--                                                    <validation-provider-->
<!--                                                        name="current password"-->
<!--                                                        :rules="{ required: true, min: 6}"-->
<!--                                                        v-slot="validationContext"-->
<!--                                                    >-->
<!--                                                        <b-form-group-->
<!--                                                            id="current_password"-->
<!--                                                            label="Current Password"-->
<!--                                                            label-class="t-mont t-bold"-->
<!--                                                            label-for="current_password"-->
<!--                                                        >-->
<!--                                                            <b-form-input type="password"-->
<!--                                                                          :state="getValidationState(validationContext)"-->
<!--                                                                          id="current_password"-->
<!--                                                                          v-model="credentials.currentPassword"-->
<!--                                                            ></b-form-input>-->

<!--                                                            <b-form-invalid-feedback-->
<!--                                                                id="current_password-live-feedback">-->
<!--                                                                {{validationContext.errors[0] }}-->
<!--                                                            </b-form-invalid-feedback>-->
<!--                                                        </b-form-group>-->
<!--                                                    </validation-provider>-->

<!--                                                </div>-->
<!--                                                <div class="col-md-6">-->
<!--                                                    <validation-provider-->
<!--                                                        persist-->
<!--                                                        name="country"-->
<!--                                                        :rules="{ required: true, min: 6}"-->
<!--                                                        v-slot="validationContext"-->
<!--                                                    >-->
<!--                                                        <b-form-group-->
<!--                                                            id="new_password"-->
<!--                                                            label="New Password"-->
<!--                                                            label-class="t-mont t-bold"-->
<!--                                                            label-for="new_password"-->
<!--                                                        >-->
<!--                                                            <b-form-input-->
<!--                                                                :state="getValidationState(validationContext)"-->
<!--                                                                id="textarea-default"-->
<!--                                                                v-model="credentials.newPassword"-->
<!--                                                            ></b-form-input>-->

<!--                                                            <b-form-invalid-feedback id="description-live-feedback">-->
<!--                                                                {{validationContext.errors[0] }}-->
<!--                                                            </b-form-invalid-feedback>-->
<!--                                                        </b-form-group>-->
<!--                                                    </validation-provider>-->

<!--                                                </div>-->
<!--                                                <div class="col-md-6">-->
<!--                                                    <validation-provider-->
<!--                                                        persist-->
<!--                                                        name="confirm_new_password"-->
<!--                                                        :rules="{ required: true, min: 6}"-->
<!--                                                        v-slot="validationContext"-->
<!--                                                    >-->
<!--                                                        <b-form-group-->
<!--                                                            id="confirm_new_password"-->
<!--                                                            label="Confirm New Password"-->
<!--                                                            label-class="t-mont t-bold"-->
<!--                                                            label-for="confirm_new_password"-->
<!--                                                        >-->
<!--                                                            <b-form-input-->
<!--                                                                :state="getValidationState(validationContext)"-->
<!--                                                                id="textarea-default"-->
<!--                                                                v-model="credentials.confirmNewPassword"-->
<!--                                                            ></b-form-input>-->

<!--                                                            <b-form-invalid-feedback id="description-live-feedback">-->
<!--                                                                {{validationContext.errors[0] }}-->
<!--                                                            </b-form-invalid-feedback>-->
<!--                                                        </b-form-group>-->
<!--                                                    </validation-provider>-->

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
                            <div
                                class="col-10 offset-1 offset-sm-2 col-sm-8 offset-lg-0 col-lg-3 order-0 order-md-1 mb-5 ">

                                <b-form class="" @submit.prevent="changeProfilePicture">
                                    <div class="jb-profile-picture">
                                        <b-img fluid rounded
                                               :src="imagePreview"
                                               :alt="user.name"></b-img>
                                        <div class="upload-functions">
                                            <input type="file" name="file" ref="changeProfilePicture"
                                                   @change="handleImageUpload" style="display:none" accept="image/*">
                                            <button class="change-btn"
                                                    @click.prevent="$refs['changeProfilePicture'].click()">
                                                <b-icon icon="pencil-fill"/>
                                            </button>

                                        </div>
                                    </div>
                                    <b-button class="mt-3" type="submit" v-if="showUploadButton">Upload</b-button>
                                </b-form>

                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-lg-9">
                        <p>Your Portfolio </p>
                    </div>

                </div>

            </div>
        </div>


    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

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
                profileDetails: {
                    picture: '',
                    gender: null
                },
                credentials: {
                    currentPassword: '',
                    newPassword: '',
                    confirmNewPassword: '',
                },
                imagePreview: null,
                file: '',
                profileUpdateLoading: false

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
            }
        },
        mounted() {
            this.profileDetails = {...this.user.profile};
            this.imagePreview = this.profileDetails.picture;
            this.userDetails = {...this.user};

            delete this.userDetails.profile;
        },
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            })
        },
    }
</script>

<style scoped>

</style>
