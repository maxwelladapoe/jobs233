<template>
    <div class="hero is-fullheight has-background-pattern-white is-full-screen">
        <div class="hero-body">
            <div class="container">

                <div class="columns is-multiline">
                    <div class="column is-12 is-8-tablet is-offset-2-tablet is-4-desktop is-offset-4-desktop">


                        <div class="card">

                            <div class="card-header py-2">
                                <div class="is-centered has-text-centered " style="width: 100%">
                                    <img src="/images/logo.png" width="120px"/>
                                </div>
                            </div>
                            <div class="card-content">
                                <ValidationObserver  v-slot="{ handleSubmit }" ref="adminLoginForm">

                                    <form>


                                        <ValidationProvider
                                            mode="lazy"
                                            slim
                                        >
                                            <b-field label="Email" label-class="t-bold t-mont" expanded>
                                                <b-input expanded v-model="loginCredentials.identity"> </b-input>
                                            </b-field>
                                        </ValidationProvider>

                                        <ValidationProvider>

                                            <b-field label="Password" label-class="t-bold t-white t-mont" expanded>
                                                <b-input expanded v-model="loginCredentials.password" password-reveal
                                                         type="password">

                                                </b-input>
                                            </b-field>
                                        </ValidationProvider>

                                        <b-checkbox class="mt-3" type="is-success"
                                                    v-model="loginCredentials.remember">Remember me
                                        </b-checkbox>


                                        <b-field label="" class="has-text-centered">
                                            <b-button class="mt-5 " type="submit is-primary" expanded
                                                      @click.prevent="handleSubmit(loginSubmit)">
                                                Login
                                            </b-button>
                                        </b-field>

                                    </form>
                                </ValidationObserver>
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
    name: "AdminLogin",
    data() {
        return {
            loginCredentials: {
                identity: '',
                password: '',
                remember: false,
            }
        }
    },
    methods: {
        ...mapActions({
            adminLogIn: 'adminAuth/adminLogIn',
        }),

        async loginSubmit() {

            this.displayErrors = false;
            this.isLoading = true;
            this.loadingMessage = 'Logging you in ...';
            await this.adminLogIn(this.loginCredentials).then(response => {
                this.isLoading = false;


                this.$router.push(this.$route.query.redirect || '/dashboard');

            }).catch(errors => {
                this.displayErrors = true;
                this.errorMessages = errors.response.data.errors;
                this.$refs.loginForm.setErrors({...errors.response.data.errors})
                this.isLoading = false;
            })
        },
    },

}
</script>

<style scoped>

</style>
