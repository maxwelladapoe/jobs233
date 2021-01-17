<template>
    <div class="jb-main-section-wrapper-alt p-0  ">

        <section class="hero is-fullheight-with-navbar ">
            <img src="/images/slider/2.jpg" class="bg-image" alt="">
            <div class="jb-overlay2"></div>

            <div class="hero-body">

                <div class="container jb-login-wrap">

                    <div class="section">

                        <div class="columns is-vcentered is-multiline is-mobile">
                            <div class="column is-12-mobile is-6-desktop  has-text-centered-mobile has-text-left-desktop ">
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
                                                    <p class="t-3 t-mont t-bold t-white">{{loadingMessage}}</p>
                                                </template>

                                                <template v-if="isSuccessful">
                                                    <b-icon class="t-white" icon="check-circle" v-if="isSuccessful"/>
                                                    <p class="t-5 t-mont t-bold t-white" v-if="isSuccessful">
                                                        <span>{{successMessage}}</span>
                                                        <br>
                                                        <span >{{additionalMessage}}</span>

                                                    </p>


                                                    <router-link :to="{name:'Login'}">
                                                        <button class="button bg-orange t-white">
                                                           Click here to login
                                                        </button>


                                                    </router-link>


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

                                            <form @submit.prevent="handleSubmit(signUpSubmit)">


                                                <b-field grouped group-multiline>

                                                    <ValidationProvider
                                                        name="First Name"
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
                                                        name="Last Name"
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
                                                    name="username"
                                                    :rules="{ required: true, min: 5, max:35}"
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
                                                    rules="required|min:6"
                                                    name="password"
                                                    v-slot="{ errors, valid }">
                                                    <b-field
                                                        label="Password"
                                                        label-for="password"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                        expanded>


                                                        <b-input id="s_password" :type="!ipv?'password':'text'"
                                                                 v-model="signupCredentials.password"
                                                                 aria-describedby="password-live-feedback"
                                                                 expanded></b-input>


                                                    </b-field>

                                                </ValidationProvider>



                                                <b-field class="text-center mt-3 expanded">

                                                    <b-radio-button  expanded v-model="signupCredentials.preference"
                                                                     native-value="work"
                                                                     type="is-primary">
                                                        <b-icon icon="account-hard-hat"></b-icon>
                                                        <span>Work</span>
                                                    </b-radio-button>

                                                    <b-radio-button expanded v-model="signupCredentials.preference"
                                                                    native-value="hire"
                                                                    type="is-primary">
                                                        <b-icon icon="handshake"></b-icon>
                                                        <span>Hire</span>
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
                                                                to our <a href="" class="t-orange">Terms and conditions</a>
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
        },
        data() {
            return {
                ipv: false,
                isLoading: false,
                loadingMessage: 'Signing you up ...',
                isSuccessful: false,
                successMessage:'',
                additionalMessage:'',
                signupCredentials: {
                    firstName: '',
                    lastName: '',
                    username: '',
                    email: '',
                    password: '',
                    preference: 'hire'
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

                    //this.loadingMessage = data.message;
                    this.isLoading = false;
                    this.isLoading = false;
                    this.isSuccessful=true;
                    this.successMessage = data.message;
                    this.additionalMessage = data.additionalMessage;
                    //.hideSignUpModal();
                    //this.showLogInModal();
                    this.resetSignUpCredentials();

                    setTimeout(()=>{
                        this.$router.push( '/login');
                    }, 10000)


                }).catch((errors) => {
                    console.log("there was an error", errors.response.data)
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
