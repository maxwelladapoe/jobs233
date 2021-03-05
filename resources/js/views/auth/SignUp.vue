<template>
    <div class="jb-main-section-wrapper-alt p-0  ">

        <section class="hero is-fullheight-with-navbar ">
            <img src="/images/slider/2.jpg" class="bg-image" alt="">
            <div class="jb-overlay2"></div>

            <div class="hero-body">

                <div class="container jb-login-wrap">

                    <div class="section">

                        <div class="columns is-vcentered is-multiline is-mobile">
                            <div
                                class="column is-12-mobile is-6-desktop  has-text-centered-mobile has-text-left-desktop ">
                                <h1 class=" t-white title t-2">Get Started</h1>
                                <p class="t-meri t-white subtitle">Join our community of creatives. <br>
                                    You can get your projects completed or get hired. <br> There are no restrictions</p>
                            </div>
                            <div class="column is-12-mobile is-5-desktop is-offset-1-desktop">


                                <div class="card p-0" footer-class="bg-white" header-class="bg-white">
                                    <div class="jb-box-overlay" :class="{'show':isLoading,
                                'show has-background-success':isSuccessful}">

                                        <div class="loading-contents-wrap">

                                            <div class="inner p-2">

                                                <template v-if="isLoading">
                                                    <div class="loader"></div>
                                                    <p class="t-3 t-mont t-bold t-white">{{ loadingMessage }}</p>
                                                </template>

                                                <template v-if="isSuccessful">
                                                    <b-icon class="t-white" icon="check-circle" v-if="isSuccessful"/>
                                                    <p class="t-white" v-if="isSuccessful">
                                                        <span class="t-5 t-bold ">{{ successMessage }}</span>
                                                        <br>
                                                        <span class="t-6 t-bold ">{{ additionalMessage }}</span>

                                                    </p>


                                                    <div class="buttons mt-3  is-justify-content-center">

                                                        <router-link :to="{name:'Login'}">
                                                            <b-button type="is-primary">
                                                                Click here to login
                                                            </b-button>
                                                        </router-link>


                                                        <b-button type="is-white" :disabled="!resendEnabled"
                                                                  class=" ml-2" @click="resendVerificationMail">
                                                            Resend link
                                                        </b-button>


                                                    </div>


                                                    <p class=" has-text-white" v-if="!resendEnabled">
                                                       <span class="t-6">

                                                           You will have to wait for a while before you can resend the
                                                        reset link again
                                                       </span>
                                                        <br>
                                                        <span class="t-bold">{{
                                                                millisToMinutesAndSeconds
                                                                (remainingTime)
                                                            }}</span>
                                                    </p>

                                                </template>

                                            </div>
                                        </div>


                                    </div>

                                    <header class="card-header">
                                        <p class="card-header-title">
                                            <span class="t-bold">Sign Up</span>
                                        </p>
                                    </header>


                                    <div class="card-content">
                                        <ValidationObserver v-slot="{ handleSubmit }" ref="signupForm">

                                            <form @submit.prevent="handleSubmit(recaptchaAuth)">


                                                <b-field grouped group-multiline>

                                                    <ValidationProvider
                                                        mode="lazy"
                                                        name="first name"
                                                        :rules="{ required: true, min: 2, alpha_dash: true  }"
                                                        v-slot="{ errors, valid }" slim
                                                    >
                                                        <b-field expanded
                                                                 label="First Name"
                                                                 label-for="first_name"
                                                                 :message="errors"
                                                                 :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                        >
                                                            <b-input id="first_name" name="first_name"
                                                                     v-model="signupCredentials.firstName"
                                                                     aria-describedby="firstname-live-feedback"
                                                                     placeholder="Kwame"></b-input>
                                                        </b-field>
                                                    </ValidationProvider>

                                                    <ValidationProvider
                                                        mode="lazy"
                                                        name="last name"
                                                        :rules="{ required: true, min: 2, alpha_dash: true }"
                                                        v-slot="{ errors, valid }" slim
                                                    >

                                                        <b-field expanded
                                                                 label="Last Name"
                                                                 label-for="lastname"
                                                                 :message="errors"
                                                                 :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                        >


                                                            <b-input id="last_name" type="text" name="last_name"
                                                                     v-model="signupCredentials.lastName"
                                                                     expanded
                                                                     aria-describedby="lastname-live-feedback"
                                                                     placeholder="Antwi"></b-input>


                                                        </b-field>
                                                    </ValidationProvider>

                                                </b-field>

                                                <ValidationProvider
                                                    mode="lazy"
                                                    name="username"
                                                    :rules="{ required: true, min: 5, max:35, alpha_dash:true}"
                                                    v-slot="{ errors, valid }" slim
                                                >

                                                    <b-field
                                                        id="s_username"
                                                        label="Username"
                                                        label-for="s_username"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    >
                                                        <b-input id="username" name="username" type="text"
                                                                 v-model="signupCredentials.username"
                                                                 placeholder="kwamemax"></b-input>

                                                    </b-field>

                                                </ValidationProvider>
                                                <ValidationProvider
                                                    mode="lazy"
                                                    name="email"
                                                    :rules="{ required: true, min: 3, email: true }"
                                                    v-slot="{ errors, valid }" slim
                                                >

                                                    <b-field
                                                        label="Email"
                                                        label-for="s_email"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    >
                                                        <b-input id="s_email" name="email" type="email"
                                                                 v-model="signupCredentials.email"
                                                                 aria-describedby="email-live-feedback"
                                                                 placeholder="kwame@example.com"></b-input>


                                                    </b-field>

                                                </ValidationProvider>


                                                <ValidationProvider
                                                    mode="lazy"
                                                    rules="required|min:6"
                                                    name="password"
                                                    v-slot="{ errors, valid }">
                                                    <b-field
                                                        label="Password"
                                                        label-for="password"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                        expanded>


                                                        <b-input id="s_password" type="password"
                                                                 v-model="signupCredentials.password" password-reveal
                                                                 expanded></b-input>


                                                    </b-field>

                                                </ValidationProvider>


                                                <b-field class="text-center mt-3 expanded" label="I want to:">

                                                    <b-radio-button expanded v-model="signupCredentials.preference"
                                                                    native-value="hire"
                                                                    type="is-primary">
                                                        <b-icon icon="handshake"></b-icon>
                                                        <span>Hire</span>
                                                    </b-radio-button>

                                                    <b-radio-button expanded v-model="signupCredentials.preference"
                                                                    native-value="work"
                                                                    type="is-primary">
                                                        <b-icon icon="account-hard-hat"></b-icon>
                                                        <span>Work</span>
                                                    </b-radio-button>


                                                </b-field>


                                                <div class="form-group mb-0">

                                                    <div class="columns">
                                                        <div class="column is-4">
                                                            <button type="submit" class="button bg-orange">
                                                                Register
                                                            </button>
                                                        </div>
                                                        <div class="column is-8">
                                                            <p class="text-left jb-t-special">By clicking this
                                                                button, you agree
                                                                to our <a href="" class="t-orange">Terms and
                                                                    conditions</a>
                                                                of
                                                                use
                                                            </p>
                                                        </div>

                                                    </div>


                                                </div>

                                            </form>

                                        </ValidationObserver>
                                    </div>


                                    <footer class="card-footer">
                                        <div class="jb-modal-footer card-footer-item ">
                                            Already a member?
                                            <router-link class="t-orange" :to="{name:'Login'}">Login</router-link>

                                        </div>
                                    </footer>

                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>

    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "Login",
    metaInfo: {
        // if no subcomponents specify a metaInfo.title, this title will be used
        title: 'Sign Up',
        meta: [
            {
                name: 'description',
                content: `Join our community of creatives. You can get your projects completed or get hired.`
            }
        ]
    },
    data() {
        return {
            ipv: false,
            isLoading: false,
            loadingMessage: 'Signing you up ...',
            isSuccessful: false,
            successMessage: '',
            additionalMessage: '',
            resendEnabled: true,
            signupCredentials: {
                firstName: '',
                lastName: '',
                username: '',
                email: '',
                password: '',
                preference: 'hire'
            },
            emailForResend: 'jadd@example.com',
            remainingTime: 300000,
        }
    },

    methods: {
        ...mapActions({

            signUp: 'auth/signUp'
        }),


        getValidationState({dirty, validated, valid = null}) {
            return dirty || validated ? valid : null;
        },
        async recaptchaAuth() {
            await this.$recaptchaLoaded();

            const token = await this.$recaptcha(this.signUpSubmit())
        },

        async signUpSubmit() {
            this.isLoading = true;
            this.loadingMessage = 'Signing you up...';

            await this.signUp(this.signupCredentials).then(({data}) => {

                //this.loadingMessage = data.message;
                this.emailForResend = this.signupCredentials.email;
                this.isLoading = false;
                this.isSuccessful = true;
                this.successMessage = data.message;
                this.additionalMessage = data.additionalMessage;
                //.hideSignUpModal();
                //this.showLogInModal();
                this.resetSignUpCredentials();

                setTimeout(() => {
                    this.$router.push('/login');
                }, 10000)


            }).catch((errors) => {
                console.log("there was an error", errors.response.data)
                this.$refs.signupForm.setErrors({...errors.response.data.errors})
                this.isLoading = false;
            })
        },

        millisToMinutesAndSeconds(millis) {
            let minutes = Math.floor(millis / 60000);
            let seconds = ((millis % 60000) / 1000).toFixed(0);
            return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
        },

        resendVerificationMail() {

            if (this.resendEnabled) {
                this.isSuccessful = false;
                this.isLoading = true;
                this.loadingMessage = 'Resending verification email...';
                axios.post('email/resend/after_signup', {email: this.emailForResend}).then(({data}) => {

                    if (data.message == 'Email already verified.') {
                        this.$router.push('/email-already-verified')
                    }
                    this.isLoading = false;
                    this.isSuccessful = true;
                    this.successMessage = data.message;
                    this.additionalMessage = '';
                }).catch(e => {
                    console.log(e);
                    this.isSuccessful = false;
                    this.isLoading = false;
                })
                this.resendEnabled = false;

                let interval = setInterval(() => {
                    this.remainingTime = this.remainingTime - 1000;
                }, 1000)

                setTimeout(() => {
                    this.resendEnabled = true;
                    this.remainingTime = 300000;
                    clearInterval(interval);
                }, 300000);


            } else {

            }

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
