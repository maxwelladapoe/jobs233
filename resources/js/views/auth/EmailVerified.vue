<template>
    <div class="jb-main-section-wrapper-alt p-0 ">

        <section class="hero is-fullheight-with-navbar p-0 m-0">

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
