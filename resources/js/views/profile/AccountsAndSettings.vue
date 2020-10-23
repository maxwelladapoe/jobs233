<template>
    <div class="jb-main-section-wrapper">

        <div class="jb-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 mx-auto  ">


                        <div class="row">
                            <div class="col-12 col-lg-9 order-1 order-md-0">
                                <p>Profile</p>
                                <div class="card bg-white p-3 shadow">


                                    <div class="jb-project-form pr-3">

                                        <ValidationObserver v-slot="{handleSubmit}" ref="changePassword">
                                            <b-form @submit.prevent="handleSubmit(changePassword)">

                                                <p>Credentials</p>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <validation-provider
                                                            name="current password"
                                                            :rules="{ required: true, min: 6}"
                                                            v-slot="validationContext"
                                                        >
                                                            <b-form-group
                                                                id="current_password"
                                                                label="Current Password"
                                                                label-class="t-mont t-bold"
                                                                label-for="current_password"
                                                            >
                                                                <b-form-input type="password"
                                                                              :state="getValidationState(validationContext)"
                                                                              id="current_password"
                                                                              v-model="credentials.currentPassword"
                                                                ></b-form-input>

                                                                <b-form-invalid-feedback
                                                                    id="current_password-live-feedback">
                                                                    {{validationContext.errors[0] }}
                                                                </b-form-invalid-feedback>
                                                            </b-form-group>
                                                        </validation-provider>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <validation-provider
                                                            persist
                                                            name="country"
                                                            :rules="{ required: true, min: 6}"
                                                            v-slot="validationContext"
                                                        >
                                                            <b-form-group
                                                                id="new_password"
                                                                label="New Password"
                                                                label-class="t-mont t-bold"
                                                                label-for="new_password"
                                                            >
                                                                <b-form-input
                                                                    :state="getValidationState(validationContext)"
                                                                    id="textarea-default"
                                                                    v-model="credentials.newPassword"
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
                                                            name="confirm_new_password"
                                                            :rules="{ required: true, min: 6}"
                                                            v-slot="validationContext"
                                                        >
                                                            <b-form-group
                                                                id="confirm_new_password"
                                                                label="Confirm New Password"
                                                                label-class="t-mont t-bold"
                                                                label-for="confirm_new_password"
                                                            >
                                                                <b-form-input
                                                                    :state="getValidationState(validationContext)"
                                                                    id="textarea-default"
                                                                    v-model="credentials.confirmNewPassword"
                                                                ></b-form-input>

                                                                <b-form-invalid-feedback id="description-live-feedback">
                                                                    {{validationContext.errors[0] }}
                                                                </b-form-invalid-feedback>
                                                            </b-form-group>
                                                        </validation-provider>

                                                    </div>

                                                </div>


                                                <div class=" form-group mr-auto text-right">

                                                    <button type="submit" class="btn bg-orange t-mont">

                                                        Change Password

                                                    </button>

                                                </div>


                                            </b-form>

                                        </ValidationObserver>
                                    </div>
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
                                                   @change="handleImageUpload" style="display:none"
                                                   accept="image/*">
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

                    <div class="col-12 col-lg-9 mt-4">

                        <div>
                            <p>Your Portfolio </p>
                            <p> <ion-icon name="add-circle"></ion-icon> Add Item</p>
                        </div>


                        <div class="card">

                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: "AccountsAndSettings",
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
