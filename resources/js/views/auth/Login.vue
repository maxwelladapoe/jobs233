<template>
    <div class="jb-main-section-wrapper-alt p-0  ">

        <div class="jb-section p-0 m-0">
            <img src="/images/slider/1.jpg" class="bg-image" alt="">

            <div class="jb-overlay"></div>

            <div class="container ">


                <div class="row jb-login-wrap">
                    <div class="col-lg-6">
                        <p class="t-1 t-meri t-white">Work / Get hired</p>
                        <p class="t-meri t-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid
                            architecto aspernatur
                            assumenda aut corporis delectus esse, et harum iste nesciunt nihil pariatur perspiciatis quo
                            quod rem sed similique unde voluptatibus.</p>
                    </div>
                    <div class="col-sm-12 col-lg-5 offset-lg-1">
                        <b-card class="border-0" footer-class="bg-white" header-class="bg-white">

                            <div class="jb-box-overlay" :class="{'show':isLoading}">

                                <div class="loading-contents-wrap">

                                    <div class="inner">

                                        <div class="loader"></div>
                                        <p class="message t-mont t-bold t-white">{{loadingMessage}}</p>
                                    </div>
                                </div>


                            </div>

                            <template v-slot:header>
                                Login
                            </template>

                            <validation-observer v-slot="{ handleSubmit }" ref="loginForm">

                                <b-form @submit.prevent="handleSubmit(loginSubmit)">


                                    <validation-provider
                                        name="identity"
                                        :rules="{ required: true, min: 3,  }"
                                        v-slot="validationContext"
                                    >

                                        <b-form-group
                                            id="email"
                                            label="Email / Username"
                                            label-for="identity">
                                            <b-form-input id="identity" name="identity"
                                                          v-model="loginCredentials.identity"

                                                          :state="getValidationState(validationContext)"
                                                          aria-describedby="email-live-feedback"
                                                          placeholder="kwame@example.com"></b-form-input>

                                            <b-form-invalid-feedback id="email-live-feedback">{{
                                                validationContext.errors[0] }}
                                            </b-form-invalid-feedback>

                                        </b-form-group>

                                    </validation-provider>

                                    <validation-provider
                                        rules="required"
                                        name="password"
                                        v-slot="validationContext">
                                        <b-form-group
                                            id="password"
                                            label="Password"
                                            label-for="password">


                                            <div class="input-with-icon">


                                                <b-form-input id="password" :type="!ipv?'password':'text'"
                                                              v-model="loginCredentials.password"
                                                              :state="getValidationState(validationContext)"
                                                              placeholder=""
                                                              aria-describedby="password-live-feedback"></b-form-input>
                                                <b-icon :icon="!ipv?'eye':'eye-slash'" class="the-icon"
                                                        @click="ipv = !ipv"/>

                                            </div>


                                            <b-form-invalid-feedback id="password-live-feedback">
                                                {{validationContext.errors[0]
                                                }}
                                            </b-form-invalid-feedback>

                                        </b-form-group>

                                    </validation-provider>


                                    <div class="errors" v-if="displayErrors">

                                        <p class="t-6 text-danger" v-for="error in errorMessages">
                                            {{error[0]}}
                                        </p>

                                    </div>


                                    <div class="form-group">

                                        <b-form-checkbox class="mb-2 mr-sm-2 mb-sm-0 t-mont"
                                                         v-model="loginCredentials.remember"> <span
                                            class="small" switch>Remember Me
                                    </span>
                                        </b-form-checkbox>

                                    </div>


                                    <div class="form-group mb-0">

                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <button class="btn bg-orange" type="submit">Login
                                                </button>
                                            </div>
                                            <div class="col-sm-12 col-md-6">

                                            </div>

                                        </div>


                                    </div>

                                </b-form>

                            </validation-observer>


                            <template v-slot:footer>
                                <div class="jb-modal-footer">

                                    Not a member?
                                    <span><router-link class="t-orange"
                                                       :to="{name:'SignUp'}">SignUp</router-link></span>
                                </div>
                            </template>
                        </b-card>
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
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Log In',
        },
        data() {
            return {

                ipv: false,
                isLoading: false,
                loadingMessage: 'Logging you in ...',
                loginCredentials: {
                    identity: '',
                    password: '',
                    remember: false,
                },

                displayErrors: false,
                errorMessages: []
            }
        },
        methods: {
            ...mapActions({
                logIn: 'auth/logIn',
            }),


            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },

            async loginSubmit() {

                this.displayErrors = false;
                this.isLoading = true;
                this.loadingMessage = 'Logging you in ...';
                await this.logIn(this.loginCredentials).then(response => {
                    this.isLoading = false;

                    this.$router.push(this.$route.query.redirect || '/');

                }).catch(errors => {
                    this.displayErrors = true;
                    this.errorMessages = errors.response.data.errors;
                    this.$refs.loginForm.setErrors({...errors.response.data.errors})
                    this.isLoading = false;
                })
            },
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
