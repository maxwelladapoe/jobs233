<template>
    <div>

        <div class="hero is-medium has-background-pattern">

            <div class="hero-body">
                <div class="container">

                    <div class="columns is-multiline">

                        <div class="column is-12  has-text-left">
                            <h1 class="title t-black t-1 t-bold">Contact Us</h1>
                            <p class="subtitle t-white">Need some help / information</p>

                            <div class=" has-text-left">
                                <a class="t-bold button is-text bg-white no-decoration"
                                   href="mailto:support@jobs233.com">Send us an email <span
                                    class="ml-2"><b-icon
                                    icon="arrow-right"/></span></a>
                            </div>


                        </div>
                    </div>

                </div>

            </div>


        </div>


        <div class="jb-main-section-wrapper-alt">

            <div class="section">
                <div class="container">

                    <div class="columns is-multiline">
                        <div class="column is-12 is-4-desktop">
                            <p class="t-3 t-bold mb-5">Submit a Request</p>

                            <ValidationObserver v-slot="{handleSubmit}" ref="submitRequest">
                                <form class="mb-5">
                                    <ValidationProvider :rules="{ required: true}"
                                                        v-slot="{ errors, valid }"
                                                        name="user type"
                                                        slim>
                                        <b-field label="Are you hiring or working?"
                                                 :message="errors"
                                                 :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                            <b-select placeholder="Select an option" expanded
                                                      v-model="contactUsRequest.userType">
                                                <option value="hiring">I am Hiring</option>
                                                <option value="working">I am a worker</option>
                                            </b-select>
                                        </b-field>
                                    </ValidationProvider>


                                    <template v-if="contactUsRequest.userType">
                                        <ValidationProvider
                                            :rules="{ required: true,email}"
                                            v-slot="{ errors, valid }"
                                            name="email" slim>
                                            <b-field label="Your email address"
                                                     :message="errors"
                                                     :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                                <b-input type="email" maxlength="30" v-model="contactUsRequest.email"
                                                ></b-input>
                                            </b-field>
                                        </ValidationProvider>


                                        <ValidationProvider :rules="{ required: true,}"
                                                            v-slot="{ errors, valid }"
                                                            name="subject" slim>
                                            <b-field label="Subject"
                                                     :message="errors"
                                                     :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                                <b-input type="text" maxlength="30"
                                                         v-model="contactUsRequest.subject" name="subject"
                                                ></b-input>
                                            </b-field>
                                        </ValidationProvider>

                                        <ValidationProvider :rules="{ required: true}"
                                                            v-slot="{ errors, valid }"
                                                            name="description" slim>
                                            <b-field label="Description" :message="errors"
                                                     :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                                <b-input type="textarea" rows="3"
                                                         v-model="contactUsRequest.description" name="description">

                                                </b-input>
                                            </b-field>
                                        </ValidationProvider>

                                        <b-field>

                                            <template v-if="!isLoading">
                                                <b-button type="is-primary" @click.prevent="handleSubmit(submitRequest)">
                                                    Submit
                                                </b-button>
                                            </template>



                                            <div
                                                class="form-group text-right d-flex align-items-start justify-content-end"
                                                v-if="isLoading">
                                                <div
                                                    class=" mr-4 d-flex flex-wrap align-baseline justify-content-center"
                                                >
                                                    <p class="mr-2 p-0 m-0">Submitting... </p>
                                                    <div class="loader"></div>
                                                </div>
                                            </div>


                                        </b-field>

                                    </template>


                                </form>
                            </ValidationObserver>

                            <p class="t-6">By completing this form, you agree to our Terms of Service and have
                                read and
                                understood the Privacy Policy.</p>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {SnackbarProgrammatic as Snackbar} from 'buefy'

    export default {
        name: "Contact",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Contact Us',
            meta: [
                {
                    name: 'description',
                    content: `Need to make some inquiries? Feel free to send us an email or submit a request`
                }
            ]
        },
        data() {
            return {

                contactUsRequest: {
                    userType: null,
                    email: '',
                    subject: '',
                    description: '',
                },
                isLoading: false,
                isSuccessful: false,


            }
        },
        methods: {
            submitRequest() {
                this.isLoading = true
                axios.post('contact/submit-request', this.contactUsRequest).then(({data}) => {

                    Snackbar.open(data.message);

                    this.contactUsRequest = {
                        userType: null,
                        email: '',
                        subject: '',
                        description: '',
                    }
                    this.$refs.submitRequest.reset();

                    this.isLoading = false;
                    this.isSuccessful =true;
                }).catch(error)
                {
                    this.isLoading = false
                }
            }
        }
    }
</script>

<style scoped>

</style>
