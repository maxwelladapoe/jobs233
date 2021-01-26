<template>
    <div>

        <div class="hero is-medium has-background-pattern">

            <div class="hero-body">
                <div class="container">

                    <div class="columns is-multiline">

                        <div class="column is-12 is-6-desktop is-offset-3-desktop has-text-centered">
                            <h1 class="title t-black t-1 t-bold">Contact Us</h1>
                            <p class="subtitle t-white">Need some help / information</p>

                            <div class=" has-text-centered">
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

                            <ValidationObserver>
                                <form class="mb-5">
                                    <ValidationProvider  :rules="{ required: true}"
                                                         v-slot="{ errors, valid }"
                                                         name="user type"
                                                         slim>
                                        <b-field label="Are you hiring or working?"
                                                 :message="errors"
                                                 :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                            <b-select placeholder="Select an option" expanded v-model="userType">
                                                <option value="hiring">I am Hiring</option>
                                                <option value="working">I am a worker</option>
                                            </b-select>
                                        </b-field>
                                    </ValidationProvider>


                                    <div v-if="userType">
                                        <ValidationProvider
                                            :rules="{ required: true,email}"
                                            v-slot="{ errors, valid }"
                                            name="email" slim>
                                            <b-field label="Your email address"
                                                     :message="errors"
                                                     :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                                <b-input type="email" maxlength="30" v-model="email" ></b-input>
                                            </b-field>
                                        </ValidationProvider>


                                        <ValidationProvider :rules="{ required: true,}"
                                                            v-slot="{ errors, valid }"
                                                            name="subject" slim>
                                            <b-field label="Subject"
                                                     :message="errors"
                                                     :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                                <b-input type="email" maxlength="30" v-model="email"></b-input>
                                            </b-field>
                                        </ValidationProvider>

                                        <ValidationProvider :rules="{ required: true}"
                                                            v-slot="{ errors, valid }"
                                                            name="description"  slim>
                                            <b-field label="Description" :message="errors"
                                                     :type="{ 'is-danger': errors[0], 'is-success': valid }">
                                                <b-input type="textarea" rows="3" v-model="email">

                                                </b-input>
                                            </b-field>
                                        </ValidationProvider>

                                    </div>


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
                userType: null,
                email: '',
                subject: '',
                description: '',

            }
        }
    }
</script>

<style scoped>

</style>
