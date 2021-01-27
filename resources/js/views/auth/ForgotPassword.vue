<template>
    <div class="jb-main-section-wrapper-alt p-0 ">

        <section class="hero is-fullheight-with-navbar p-0 m-0">
            <img src="/images/slider/4.jpg" class="bg-image" alt="">

            <div class="jb-overlay2"></div>

            <div class="hero-body">


            <div class="container jb-login-wrap">

                <div class="section">

                    <div class="columns  is-vcentered is-mobile is-multiline">
                        <div class="column is-12-mobile is-6-desktop  has-text-centered-mobile has-text-left-desktop ">
                            <h1 class=" t-white title">Reset your password</h1>
                            <p class="t-meri t-white subtitle">Don't worry, it happens to the best of us.</p>
                        </div>
                        <div class="column is-12-mobile is-5-desktop is-offset-1-desktop">


                            <div class="card p-0" footer-class="bg-white" header-class="bg-white">
                                <div class="jb-box-overlay " :class="{'show': isLoading, 'show has-background-success' :
                                isSuccessful}">

                                    <div class="loading-contents-wrap">

                                        <div class="inner">

                                            <div class="loader" v-if="isLoading"></div>
                                            <b-icon class="t-white" icon="check-circle" v-if="isSuccessful"/>
                                            <p class="t-5 t-mont t-bold t-white" v-if="isSuccessful">{{successMessage
                                                }}</p>
                                        </div>
                                    </div>


                                </div>

                                <header class="card-header">
                                    <p class="card-header-title">
                                        <span class="t-bold">Forgot Password</span>
                                    </p>
                                </header>


                                <div class="card-content">
                                    <ValidationObserver v-slot="{ handleSubmit }" ref="resetForm">

                                        <form @submit.prevent="handleSubmit(recaptchaAuth)">

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
                                                             v-model="resetCredentials.email"
                                                             aria-describedby="email-live-feedback"
                                                             placeholder="kwame@example.com"></b-input>
                                                </b-field>

                                            </ValidationProvider>

                                            <div class="form-group mb-0">

                                                <div class="columns">
                                                    <div class="column is-4">
                                                        <button type="submit" class="button bg-orange t-white">
                                                            Email reset link
                                                        </button>
                                                    </div>

                                                </div>


                                            </div>

                                        </form>

                                    </ValidationObserver>
                                </div>


                                <footer class="card-footer">
                                    <div class="jb-modal-footer card-footer-item ">
                                        Remember your password? <router-link class="t-orange ml-1" :to="{name:'Login'}">
                                        Login</router-link>

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
            title: 'Forgot Password',
        },
        data() {
            return {
                ipv: false,
                isLoading: false,
                isSuccessful: false,
                successMessage:'',
                loadingMessage: 'Sending the reset link ...',
                resetCredentials: {
                    email: ''
                },
            }
        },
        methods: {


            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },

            async recaptchaAuth(){
                await this.$recaptchaLoaded();

                const token = await this.$recaptcha(this.resetCredentialsSubmit())
            },


            resetCredentialsSubmit() {
                this.isLoading = true;
                //this.loadingMessage = 'Checking the email ...';

                axios.post('password-reset',this.resetCredentials).then(({data}) => {
                    console.log(data);
                    //this.loadingMessage = data.message;
                    this.isLoading = false;
                    this.isSuccessful=true;
                    this.successMessage = data.message

                    this.resetCredentials.email='';
                    this.$refs.resetForm.reset();

                    setTimeout(()=>{
                        this.$router.push( '/login');
                    }, 10000)

                }).catch(errors => {
                    console.log("there was an error", errors)
                    this.$refs.resetForm.setErrors({...errors.response.data.errors})
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
