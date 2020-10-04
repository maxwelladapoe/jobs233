<template>

    <header>


        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">

                <a class="navbar-brand" href="/"><img src="/images/logo2.png" alt="Jobs 233 logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item">
                            <a class="nav-link " href="#">How it Works</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item">
                            <a class="nav-link " href="#" @click.prevent="showSignUpModal">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#" @click.prevent="showLogInModal">Login</a>
                        </li>
                    </ul>
                    <button class="btn bg-orange ml-5 my-sm-0" type="submit">Hire</button>

                </div>

            </div>

        </nav>

        <div v-if="showLogin  && ismv">


            <div class="jb-modal" :class="{'showModal':ismv}">

                <div class="jb-modal-wrap">


                    <div id="login" class="jb-modal-box text-center">
                        <div class="jb-modal-box-overlay" :class="{'show':isLoading}">

                            <div class="loading-contents-wrap">

                                <div class="inner">

                                    <div class="loader"></div>
                                    <p class="message t-mont t-bold t-white">{{loadingMessage}}</p>
                                </div>
                            </div>


                        </div>
                        <!-- this is the close btn -->
                        <div class="jb-close" @click="closeModal"></div>

                        <div class="jb-modal-header">
                            <p class="jb-modal-text">Login to start work</p>
                        </div>


                        <div class="jb-modal-contents text-left">
                            <div class="container">
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
                                                <b-form-input id="identity" name="identity" v-model="loginCredentials.identity"

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

                                                <b-input-group>


                                                    <b-form-input id="password" :type="!ipv?'password':'text'"
                                                                  v-model="loginCredentials.password"
                                                                  :state="getValidationState(validationContext)"
                                                                  placeholder=""
                                                                  aria-describedby="password-live-feedback"></b-form-input>

                                                    <b-input-group-append>
                                                        <b-input-group-text>
                                                            <b-icon :icon="!ipv?'eye':'eye-slash'" @click="ipv = !ipv"/>
                                                        </b-input-group-text>
                                                    </b-input-group-append>

                                                </b-input-group>

                                                <b-form-invalid-feedback id="password-live-feedback">
                                                    {{validationContext.errors[0]
                                                    }}
                                                </b-form-invalid-feedback>

                                            </b-form-group>

                                        </validation-provider>

                                        <div class="form-group">

                                            <b-form-checkbox class="mb-2 mr-sm-2 mb-sm-0 t-mont"
                                                             v-model="loginCredentials.rememberMe"> <span
                                                class="small" switch>Remember Me
                                    </span>
                                            </b-form-checkbox>

                                        </div>

                                        <div class="form-group">

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

                            </div>


                        </div>

                        <div class="jb-modal-footer">

                            <p>Not a member?
                                <a class="t-orange" href="#" @click.prevent="showSignUpModal">SignUp</a>
                            </p>
                        </div>


                    </div>
                </div>
            </div>


        </div>
        <div v-if="showSignUp && ismv">

            <div class="jb-modal" :class="{'showModal':ismv}">

                <div class="jb-modal-wrap">
                    <div id="signup" class="jb-modal-box text-center" v-if="showSignUp">

                        <div class="jb-modal-box-overlay" :class="{'show':isLoading}">
                            <div class="loading-contents-wrap">

                                <div class="inner">
                                <div class="loader"></div>
                                <p class="message t-mont t-bold t-white">{{loadingMessage}}</p>

                                </div>
                            </div>
                        </div>

                        <!-- this is the close btn -->
                        <div class="jb-close" @click="closeModal"></div>

                        <div class="jb-modal-header">
                            <p class="jb-modal-text">Sign up and become your own boss</p>
                        </div>


                        <div class="jb-modal-contents text-left">
                            <div class="container">
                                <validation-observer v-slot="{ handleSubmit }" ref="signupForm">

                                    <b-form @submit.prevent="handleSubmit(signUpSubmit)">


                                        <div class="form-row">

                                            <div class="col-12 col-md-6">
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
                                            <div class="col-12 col-md-6">
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
                                            :rules="{ required: true, min: 5, max:10}"
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
                                                    description="  All new passwords must contain at least 8 characters.
                                        We also suggest having at least one capital and one lower-case letter (Aa-Zz), one
                                        special
                                        symbol (#, &, % etc), and one number (0-9) in your password for the best strength."
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
                                                        {{validationContext.errors[0]
                                                        }}
                                                    </b-form-invalid-feedback>

                                                </b-form-group>

                                            </validation-provider>

                                        </div>


                                        <div class="form-group text-center">

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


                                        <div class="form-group">

                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <button type="submit" class="btn bg-orange">
                                                        Register
                                                    </button>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
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

                            </div>


                        </div>

                        <div class="jb-modal-footer">
                            <p>Already a member?
                                <span class="t-orange" @click="showLogInModal">Login</span>
                            </p>
                        </div>


                    </div>
                </div>


            </div>


        </div>

    </header>
</template>

<script>

    import {mapActions, mapGetters} from "vuex";

    export default {
        data: function () {
            return {
                ismv: false,
                ipv: false,
                showSignUp: false,
                showLogin: false,
                isLoading: false,

                error: false,
                success: false,
                loadingMessage: 'Logging you in ...',
                //signup
                signupCredentials: {
                    firstName: '',
                    lastName: '',
                    username: '',
                    email: '',
                    password: '',
                    preference: null
                },
                loginCredentials: {
                    identity: '',
                    password: '',
                    rememberMe: true,
                },
            }
        },

        methods: {
            showSignUpModal() {
                this.showSignUp = true;
                this.showLogin = false;
                this.ismv = true;

                // eventBus.$emit('requestForSignUp', this.showSignUp);
            },
            hideSignUpModal() {
                this.showSignUp = false;
                this.ismv = false;

                // eventBus.$emit('requestForSignUp', this.showSignUp);
            },
            showLogInModal() {
                this.showLogin = true;
                this.showSignUp = false;
                this.ismv = true;

                // eventBus.$emit('requestForLogin', this.showLogin);
            },
            closeModal() {
                this.ismv = false;
            },
            ...mapActions({
                logIn: 'auth/logIn',
                signUp: 'auth/signUp'
            }),

            resetSignUpCredentials() {
                this.signupCredentials = {
                    firstName: '',
                    lastName: '',
                    email: '',
                    password: '',
                    preference: null
                }
            },

            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },

            async loginSubmit() {

                this.isLoading = true;
                this.loadingMessage = 'Logging you in ...';
                await this.logIn(this.loginCredentials).then(response => {
                    this.isLoading = false;
                    this.ismv = false;
                    this.$router.push('/dashboard');

                }).catch(errors => {
                    this.$refs.loginForm.setErrors({...errors.response.data.errors})
                    this.isLoading = false;
                })
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


        },

        components: {}
    }
</script>

<style lang="scss">
</style>
