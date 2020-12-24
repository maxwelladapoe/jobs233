<template>
    <div class="jb-main-section-wrapper-alt p-0">

        <div class="jb-section p-0 m-0">
            <img src="/images/slider/1.jpg" class="bg-image" alt="">

            <div class="jb-overlay"></div>

            <div class="container jb-login-wrap ">

                <div class="section is-large">

                    <div class="columns is-vcentered is-mobile is-multiline">
                        <div class="column is-12-mobile is-6-desktop  has-text-centered-mobile has-text-left-desktop ">

                            <h1 class=" t-white title">Work / Get hired</h1>
                            <p class="t-meri t-white subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Aliquid
                                architecto aspernatur
                                assumenda aut corporis delectus esse, et harum iste nesciunt nihil pariatur perspiciatis
                                quo
                                quod rem sed similique unde voluptatibus.</p>
                        </div>
                        <div class="column is-12-mobile is-5-desktop is-offset-1-desktop">
                            <div class="card">

                                <div class="jb-box-overlay" :class="{'show':isLoading}">

                                    <div class="loading-contents-wrap">

                                        <div class="inner">

                                            <div class="loader"></div>
                                            <p class="t-2 t-mont t-bold t-white">{{loadingMessage}}</p>
                                        </div>
                                    </div>


                                </div>


                                <header class="card-header">
                                    <p class="card-header-title">
                                        Login
                                    </p>
                                </header>

                                <div class="card-content">


                                    <validation-observer v-slot="{ handleSubmit }" ref="loginForm">

                                        <section>
                                            <form @submit.prevent="handleSubmit(loginSubmit)">


                                                <ValidationProvider
                                                    name="Email / Username"
                                                    :rules="{ required: true, min:3}"
                                                    v-slot="{ errors, valid }"
                                                >
                                                    <b-field
                                                        label="Email / Username"
                                                        label-for="identity"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                                        <b-input id="identity" name="identity"
                                                                 v-model="loginCredentials.identity"
                                                                 aria-describedby="email-live-feedback"
                                                                 placeholder="kwame@example.com"></b-input>

                                                    </b-field>

                                                </ValidationProvider>

                                                <ValidationProvider
                                                    rules="required"
                                                    name="password"
                                                    v-slot="{ errors, valid }">
                                                    <b-field
                                                        label="Password"
                                                        label-for="password"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    >


                                                        <div class="input-with-icon">


                                                            <b-input id="password" :type="!ipv?'password':'text'"
                                                                     v-model="loginCredentials.password"
                                                                     placeholder=""
                                                                     aria-describedby="password-live-feedback"></b-input>
                                                            <b-icon :icon="!ipv?'eye':'eye-slash'" class="the-icon"
                                                                    @click="ipv = !ipv"/>

                                                        </div>

                                                    </b-field>

                                                </ValidationProvider>


                                                <div class="errors" v-if="displayErrors">

                                                    <p class="t-6 text-danger" v-for="error in errorMessages">
                                                        {{error[0]}}
                                                    </p>

                                                </div>


                                                <b-field class="mt-3">

                                                    <b-switch :rounded="false" class="mb-2 mr-sm-2 mb-sm-0 t-mont"
                                                              v-model="loginCredentials.remember"> <span
                                                        class="small" switch>Remember Me
                                    </span>
                                                    </b-switch>


                                                    <div class="" style="margin-left: auto"> <router-link
                                                        :to="{name:'ForgotPassword'}" >Forgot
                                                        Password?</router-link></div>

                                                </b-field>


                                                <div class="field mb-0">

                                                    <div class="columns">
                                                        <div class="column is-12 is-6-tablet">
                                                            <button class="button bg-orange t-white"
                                                                    type="submit">
                                                                Login
                                                            </button>
                                                        </div>
                                                        <div class="column is-12 is-6-tablet">

                                                        </div>

                                                    </div>


                                                </div>

                                            </form>
                                        </section>
                                    </validation-observer>
                                </div>

                                <footer class="card-footer has-text-left">

                                    <p class="card-footer-item ">
                                        Not a member?
                                        <span><router-link class="t-orange"
                                                           :to="{name:'SignUp'}"> SignUp</router-link></span>

                                    </p>

                                </footer>
                            </div>
                        </div>
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
