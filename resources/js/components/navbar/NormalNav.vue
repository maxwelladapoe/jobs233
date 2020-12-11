<template>

    <header class="pt-3 pb-3" style="z-index: 9999; position: relative; background-color: #fff">
        <div class="container">

            <b-navbar spaced transparent>
                <template slot="brand">
                    <b-navbar-item tag="router-link" to="/">
                        <img src="/images/logo2.png" alt="Jobs 233 logo"></b-navbar-item>
                </template>
                <template slot="start">
                    <b-navbar-item>
                        <router-link :to="{name:'HowItWorks'}">How it Works</router-link>
                    </b-navbar-item>
                    <b-navbar-item>
                        <router-link :to="{name:'Projects'}">Browse Projects</router-link>
                    </b-navbar-item>

                </template>

                <template slot="end">

                    <b-navbar-item>
                        <router-link :to="{name:'SignUp'}" class="button is-primary">
                            <strong>Sign up</strong>
                        </router-link>
                    </b-navbar-item>

                    <b-navbar-item>
                        <router-link :to="{name:'Login'}" class="button is-outlined is-primary">
                            <strong>Login</strong>
                        </router-link>
                    </b-navbar-item>

                </template>

            </b-navbar>
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
