<template>
    <div class="jb-main-section-wrapper-alt p-0  ">

        <div class="jb-section p-0 m-0">
            <img src="/images/slider/1.jpg" class="bg-image" alt="">

            <div class="jb-overlay"></div>

            <div class="container ">


                <div class="columns jb-login-wrap">
                    <div class="column is-12 is-4-desktop order-1 order-md-0">


                        <div class="card p-0" footer-class="bg-white" header-class="bg-white">
                            <div class="jb-box-overlay" :class="{'show':isLoading}">

                                <div class="loading-contents-wrap">

                                    <div class="inner">

                                        <div class="loader"></div>
                                        <p class="message t-mont t-bold t-white">{{loadingMessage}}</p>
                                    </div>
                                </div>


                            </div>

                            <header class="card-header">
                                <span class="t-bold">Sign Up</span>
                            </header>


                            <div class="card-content">
                                <ValidationObserver v-slot="{ handleSubmit }" ref="signupForm">

                                    <form @submit.prevent="handleSubmit(signUpSubmit)">


                                        <b-field grouped>
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
                                            :rules="{ required: true, min: 5, max:15}"
                                            v-slot="{ errors, valid }" slim
                                        >

                                            <b-field
                                                id="s_username"
                                                label="Username"
                                                label-for="s_username"
                                                :message="errors"
                                                :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                            >
                                                <b-input id="s_username" name="username" type="text"
                                                         v-model="signupCredentials.username"

                                                         aria-describedby="username-live-feedback"
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
                                                         aria-describedby="password-live-feedback" expanded></b-input>


                                            </b-field>

                                        </ValidationProvider>


                                        <b-field class="text-center mt-3">

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
                                                        to our <a href="" class="t-orange">Terms and conditions</a> of
                                                        use
                                                    </p>
                                                </div>

                                            </div>


                                        </div>

                                    </form>

                                </ValidationObserver>
                            </div>


                            <footer class="card-footer">
                                <div class="jb-modal-footer">
                                    Already a member?
                                    <router-link class="t-orange" :to="{name:'Login'}">Login</router-link>

                                </div>
                            </footer>

                        </div>


                    </div>


                    <div class="column is-12 is-6-desktop is-offset-2-desktop d-none d-lg-block order-0 order-md-1">
                        <h1 class=" t-white title">Work / Get hired</h1>
                        <p class="t-meri t-white subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Aliquid
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
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Sign Up',
        },
        data() {
            return {
                ipv: false,
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
