<template>
    <div class="jb-main-section-wrapper">

        <div class="jb-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 mx-auto  ">


                        <div class="row">
                            <div class="col-12 col-lg-9">
                                <div class="jb-project-form p-3">


                                    <ValidationObserver v-slot="{handleSubmit}" ref="editProfile">
                                        <b-form @submit.prevent="handleSubmit(editProfile)">

                                            <p>Profile</p>
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
                                                                id="textarea-default"
                                                                v-model="profileDetails.phone_number"
                                                            ></b-form-input>

                                                            <b-form-invalid-feedback id="description-live-feedback">
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
                                                                id="textarea-default"
                                                                v-model="profileDetails.gender"
                                                            >

                                                                <b-form-select-option value="M">Male
                                                                </b-form-select-option>
                                                                <b-form-select-option value="F">Female
                                                                </b-form-select-option>
                                                                <b-form-select-option value="O">Rather not state
                                                                </b-form-select-option>
                                                            </b-form-select>

                                                            <b-form-invalid-feedback id="description-live-feedback">
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
                                                                id="textarea-default"
                                                                v-model="profileDetails.bio"
                                                            ></b-form-textarea>

                                                            <b-form-invalid-feedback id="description-live-feedback">
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
                                                                id="textarea-default"
                                                                v-model="profileDetails.country"
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
                                                                id="textarea-default"
                                                                v-model="profileDetails.city"
                                                            ></b-form-input>

                                                            <b-form-invalid-feedback id="description-live-feedback">
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
                                                                id="textarea-default"
                                                                v-model="profileDetails.address"
                                                            ></b-form-textarea>

                                                            <b-form-invalid-feedback id="description-live-feedback">
                                                                {{validationContext.errors[0] }}
                                                            </b-form-invalid-feedback>
                                                        </b-form-group>
                                                    </validation-provider>

                                                </div>

                                            </div>


                                            <div class=" form-group mr-auto text-right">

                                                <button type="submit" class="btn bg-orange t-mont">

                                                    Update Profile

                                                </button>

                                            </div>


                                        </b-form>

                                    </ValidationObserver>
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
                                                                          id="textarea-default"
                                                                          v-model="credentials.currentPassword"
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
                            <div class="col-12 col-lg-3 ">

                                <b-form class="">
                                <div class="jb-profile-picture">
                                    <b-img  fluid rounded
                                           :src="profileDetails.picture ? profileDetails.picture : '/images/userimages/profile.svg'"
                                           :alt="user.name"></b-img>
                                    <div class="upload-functions">
                                        <input type="file" name="" ref="changeProfilePicture" class="d-none">
                                        <button class="change-btn" @click="$refs['changeProfilePicture'].click()" ><b-icon icon="pencil-fill"/></button>

                                    </div>
                                </div>

                                    <b-button class="mt-3" type="submit">Change</b-button>
                                </b-form>

                            </div>

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
        name: "EditProfile",
        data() {
            return {
                userDetails: {},
                profileDetails: {},
                credentials: {
                    currentPassword: '',
                    newPassword: '',
                    confirmNewPassword: '',
                }
            }
        },
        methods: {

            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },

            editProfile() {
                axios.post('/profile/update', {...this.userDetails, ...this.profileDetails}).then(({data}) => {
                    console.log(data)
                }).catch()
            },
            changePassword() {

            }
        },
        mounted() {
            this.profileDetails = this.user.profile;
            this.userDetails = this.user;
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
