<template>
    <div class="jb-main-section-wrapper-alt p-0  ">

        <div class="jb-section p-0 m-0">
            <img src="/images/slider/1.jpg" class="bg-image" alt="">

            <div class="jb-overlay"></div>

            <div class="container ">


                <div class="row jb-login-wrap">
                    <div class="col-sm-12 col-lg-5 order-1 order-md-0" >


                        <b-card class="p-0" footer-class="bg-white" header-class="bg-white">
                            <div class="jb-box-overlay" :class="{'show':isLoading}">

                                <div class="loading-contents-wrap">

                                    <div class="inner">

                                        <div class="loader"></div>
                                        <p class="message t-mont t-bold t-white">{{loadingMessage}}</p>
                                    </div>
                                </div>


                            </div>

                            <template template v-slot:header>
                                Sign Up
                            </template>


                            <validation-observer v-slot="{ handleSubmit }" ref="signupForm">

                                <b-form @submit.prevent="handleSubmit(signUpSubmit)">


                                    <div class="form-row">

                                        <div class="col-6 col-md-6">
                                            <validation-provider
                                                name="First Name"
                                                :rules="{ required: true, min: 2, alpha_dash: true  }"
                                                v-slot="validationContext"
                                            >
                                                <b-form-group
                                                    id="first_name"
                                                    label="First Name"
                                                    label-for="first_name">
                                                    <b-form-input id="first_name" name="first_name"
                                                                  v-model="signupCredentials.firstName"
                                                                  :state="getValidationState(validationContext)"
                                                                  aria-describedby="firstname-live-feedback"
                                                                  placeholder="Kwame"></b-form-input>
                                                    <b-form-invalid-feedback id="firstname-live-feedback">{{
                                                        validationContext.errors[0]}}
                                                    </b-form-invalid-feedback>
                                                </b-form-group>
                                            </validation-provider>
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <validation-provider
                                                name="Last Name"
                                                :rules="{ required: true, min: 2, alpha_dash: true }"
                                                v-slot="validationContext"

                                            >

                                                <b-form-group
                                                    id="lastname"
                                                    label="Last Name"
                                                    label-for="lastname">


                                                    <b-form-input id="last_name" type="text" name="last_name"
                                                                  v-model="signupCredentials.lastName"
                                                                  :state="getValidationState(validationContext)"
                                                                  aria-describedby="lastname-live-feedback"
                                                                  placeholder="Antwi"></b-form-input>

                                                    <b-form-invalid-feedback id="lastname-live-feedback">{{
                                                        validationContext.errors[0]}}
                                                    </b-form-invalid-feedback>


                                                </b-form-group>
                                            </validation-provider>
                                        </div>
                                    </div>


                                    <validation-provider
                                        name="username"
                                        :rules="{ required: true, min: 5, max:15}"
                                        v-slot="validationContext"
                                    >

                                        <b-form-group
                                            id="s_username"
                                            label="Username"
                                            label-for="s_username">
                                            <b-form-input id="s_username" name="username" type="text"
                                                          v-model="signupCredentials.username"

                                                          :state="getValidationState(validationContext)"
                                                          aria-describedby="username-live-feedback"
                                                          placeholder="kwamemax"></b-form-input>

                                            <b-form-invalid-feedback id="username-live-feedback">{{
                                                validationContext.errors[0] }}
                                            </b-form-invalid-feedback>

                                        </b-form-group>

                                    </validation-provider>
                                    <validation-provider
                                        name="email"
                                        :rules="{ required: true, min: 3, email: true }"
                                        v-slot="validationContext"
                                    >

                                        <b-form-group
                                            id="s_email"
                                            label="Email"
                                            label-for="s_email">
                                            <b-form-input id="s_email" name="email" type="email"
                                                          v-model="signupCredentials.email"

                                                          :state="getValidationState(validationContext)"
                                                          aria-describedby="email-live-feedback"
                                                          placeholder="kwame@example.com"></b-form-input>

                                            <b-form-invalid-feedback id="email-live-feedback">{{
                                                validationContext.errors[0] }}
                                            </b-form-invalid-feedback>

                                        </b-form-group>

                                    </validation-provider>


                                    <div>

                                        <validation-provider
                                            rules="required|min:6"
                                            name="password"
                                            v-slot="validationContext">
                                            <b-form-group
                                                id="s_password"
                                                label="Password"
                                                description=""
                                                label-for="password">
                                                <b-input-group>


                                                    <b-form-input id="s_password" :type="!ipv?'password':'text'"
                                                                  v-model="signupCredentials.password"
                                                                  :state="getValidationState(validationContext)"
                                                                  aria-describedby="password-live-feedback"></b-form-input>

                                                    <b-input-group-append>
                                                        <b-input-group-text>
                                                            <b-icon :icon="!ipv?'eye':'eye-slash'"
                                                                    @click="ipv = !ipv"/>
                                                        </b-input-group-text>
                                                    </b-input-group-append>

                                                </b-input-group>
                                                <b-form-invalid-feedback id="password-live-feedback">
                                                    {{validationContext.errors[0]}}
                                                </b-form-invalid-feedback>

                                            </b-form-group>

                                        </validation-provider>

                                    </div>


                                    <div class="form-group text-center">

                                        <div class="jb-l-wrap">

                                            <label for="work" class="t-bold jb-l-special ">
                                                <input type="radio" name="work-or-hire-1" id="work"
                                                       class="special-radio"
                                                       v-model="signupCredentials.preference" value="work"> Work
                                            </label>

                                            <label for="hire" class="t-bold jb-l-special">
                                                <input type="radio" name="work-or-hire-2" id="hire"
                                                       class="special-radio"
                                                       v-model="signupCredentials.preference" value="hire"> Hire
                                            </label>
                                        </div>

                                    </div>


                                    <div class="form-group mb-0">

                                        <div class="row">
                                            <div class="col-4 col-md-4">
                                                <button type="submit" class="btn bg-orange">
                                                    Register
                                                </button>
                                            </div>
                                            <div class="col-8 col-md-8">
                                                <p class="text-left jb-t-special">By clicking this
                                                    button, you agree
                                                    to our <a href="" class="t-orange">Terms and conditions</a> of
                                                    use
                                                </p>
                                            </div>

                                        </div>


                                    </div>

                                </b-form>

                            </validation-observer>


                            <template v-slot:footer>
                                <div class="jb-modal-footer">
                                    Already a member?
                                    <router-link class="t-orange" :to="{name:'Login'}">Login</router-link>

                                </div>
                            </template>

                        </b-card>


                    </div>


                    <div class="col-sm-12 col-lg-6 offset-lg-1 d-none d-lg-block order-0 order-md-1">
                        <p class="t-1 t-meri t-white">Work / Get hired</p>
                        <p class="t-meri t-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid
                            architecto aspernatur
                            assumenda aut corporis delectus esse, et harum iste nesciunt nihil pariatur perspiciatis quo
                            quod rem sed similique unde voluptatibus.</p>
                    </div>
                </div>
            </div>


        </div>

    </div>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "Login",
        data() {
            return {

                isLoading: false,
                loadingMessage: 'Signing you up ...',
                signupCredentials: {
                    firstName: '',
                    lastName: '',
                    username: '',
                    email: '',
                    password: '',
                    preference: null
                },
            }
        },
        methods: {
            ...mapActions({

                signUp: 'auth/signUp'
            }),


            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },


            async signUpSubmit() {
                this.isLoading = true;
                this.loadingMessage = 'Signing you up...';

                await this.signUp(this.signupCredentials).then(({data}) => {
                    console.log(data);
                    this.loadingMessage = data.message;
                    this.isLoading = false;
                    this.hideSignUpModal();
                    this.showLogInModal();
                    this.resetSignUpCredentials();

                }).catch(errors => {
                    console.log("there was an error", errors)
                    this.$refs.signupForm.setErrors({...errors.response.data.errors})
                    this.isLoading = false;
                })
            }
        }
    }
</script>

<style scoped lang="scss">

    .jb-main-section-wrapper-alt {
        position: relative;

        .bg-image {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }
</style>
