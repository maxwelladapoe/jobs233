<template>
    <div class="jb-main-section-wrapper">


        <template v-if="project && (project.user_id === user.id)">


            <div class="section no-padding-margin-top-bottom">


                <div class="container">

                    <div class="columns is-multiline">
                        <div class="column is-12 is-8-desktop">
                            <h1 class="t-mont title t-bold">Make a Deposit </h1>
                            <p class="subtitle ">Project: <span class="">{{ project_id}} > {{project
                            .title}}</span></p>

                            <p class="text-left t-meri ">You can speed up the bidding process by ensuring ahead of time
                                that you have adequate funds in your account to cover all planned purchases. This adds a
                                "deposit
                                made" icon to your project when the deposit is more than 50% of the budget or accepted
                                offer.

                            </p>

                            <!--                this was just added it will be a future feature -->
                            <p class="t-meri t-bold mt-2 ">
                                When topping up your balance, please note: Per our fraud control guidelines, some
                                transactions
                                (especially those involving third-party payments) may require additional verification.
                                In
                                some
                                cases, we’ll need phone verification for the card holder.

                            </p>


                            <div class="columns is-multiline mt-6 ">

                                <div class="column is-3-tablet is-3-desktop">
                                    <p><span class="t-orange t-bold t-mont">Your budget:</span> <span
                                        class="t-bold">{{project.budget}}</span>
                                    </p>

                                    <p><span class="t-orange t-bold t-mont">Your balance:</span> <span
                                        class="t-bold">{{project.budget}}</span>
                                    </p>

                                    <b-field label=" Select a payment Method" class="mt-5">

                                        <b-select placeholder="Select a payment method" expanded
                                                  v-model="selectedPaymentOption">

                                            <option v-for="paymentOption in paymentOptions"
                                                    :value="paymentOption">{{paymentOption.name}}
                                            </option>
                                        </b-select>
                                    </b-field>

                                </div>


                                <div class="column is-12 is-8-tablet is-8-desktop is-offset-1-desktop">

                                    <template v-if="!hasReference">


                                        <template v-if="selectedPaymentOption">

                                            <div class="media">
                                                <div class="media-left">
                                                    <figure class="media-left">
                                                        <p class="image is-64x64">
                                                            <img :src="selectedPaymentOption.logo">
                                                        </p>
                                                    </figure>
                                                </div>

                                                <div class="media-content">
                                                    <div class="content">
                                                        <p class="">

                                                        <span class="t-bold t-mont t-5">
                                                            {{selectedPaymentOption.name}}
                                                        </span>
                                                            <br>
                                                            <span class="t-meri">
                                                           {{selectedPaymentOption.description}}
                                                       </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </template>


                                        <ValidationObserver v-slot="{handleSubmit}" ref="submitDepositForm">

                                            <form class="mt-5">

                                                <b-field expanded>
                                                    <b-field
                                                        id="amount"
                                                        label="Top-up Amount"
                                                        label-class="t-mont t-bold"
                                                        label-for="amount"
                                                        grouped
                                                    >

                                                        <ValidationProvider
                                                            :rules="{ required: true, integer:false}"
                                                            name="currency"
                                                            v-slot="{ errors, valid }" slim
                                                        >

                                                            <b-select id="currency"
                                                                      placeholder="Select a
                                                                currency"
                                                                      name="currency"
                                                                      v-model="paymentTopup.currency"
                                                                      aria-describedby="currency-live-feedback">

                                                                <option v-for="currency in currencies"
                                                                        :key="currency.name"
                                                                        :value="currency.name">
                                                                    {{currency.name}}
                                                                </option>

                                                            </b-select>



                                                        </ValidationProvider>

                                                        <ValidationProvider
                                                            :rules="{ required: true,  min:1}"
                                                            name="budget"
                                                            v-slot="{ errors, valid }" slim
                                                        >
                                                            <b-input id="amount-input" type="number" step="0.10"
                                                                     :min="minPayableAmount"
                                                                     expanded
                                                                     placeholder=""
                                                                     name="amount"
                                                                     v-model="paymentTopup.inputAmount"
                                                                     aria-describedby="amount-live-feedback">

                                                            </b-input>

                                                        </ValidationProvider>


                                                        <p class="control">
                                                            <b-button @click="submitPaymentTopUp" class="is-success"
                                                                      icon-right="cash-plus">Deposit
                                                            </b-button>
                                                        </p>


                                                    </b-field>


                                                </b-field>


                                            </form>
                                        </ValidationObserver>

                                    </template>

                                    <template v-if="hasReference">
                                        <div
                                            class="text-center bg-orange d-flex align-items-center justify-content-center"
                                            style="height: 300px; width: 100%">
                                            <div v-if="confirmingPayment  && !paymentSuccess ">
                                                <p class="t-white">Confirming your payment status</p>
                                                <div class="loader mt-2"></div>
                                            </div>
                                            <div v-if="paymentSuccess && !confirmingPayment">
                                                <p class="t-white">Your payment was successful</p>
                                                <success-animated-icon class=""/>
                                            </div>
                                            <div v-if="!paymentSuccess && !confirmingPayment ">

                                                <p class="t-white">Your payment failed</p>
                                                <p>{{failedMessage}}</p>

                                            </div>

                                            <div>

                                            </div>

                                        </div>

                                    </template>


                                </div>

                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </template>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import md5 from 'js-md5'
    import SuccessAnimatedIcon from "../../components/extras/SuccessAnimatedIcon";

    export default {
        name: "MakeDeposit",
        components: {SuccessAnimatedIcon},
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Make Deposit',
        },
        props: {
            project_id: {
                type: String,
                required: true
            },
            trxref: {
                type: String,
                required: false
            },
            reference: {
                type: String,
                required: false
            }
        },
        data() {
            return {
                hasReference: false,
                paymentSuccess: null,
                confirmingPayment: false,
                failedMessage: '',
                currencies: [],
                project: {},
                projectNotFound: false,
                paymentOptions: {},
                selectedPaymentOption: '',
                minPayableAmount: 0,

                paymentTopup: {
                    email: '',
                    orderId: '',
                    amount: 0,
                    currency: 'GHS',
                    reference: '',
                    first_name: '',
                    last_name: '',
                    inputAmount:0,
                    metadata: {}
                }
            }
        },

        methods: {

            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },

            submitPaymentTopUp() {

                console.log(this.paymentTopup);

                this.paymentTopup.amount = Number(this.paymentTopup.inputAmount*100).toFixed(2)

                axios.post(`/pay/${this.project.id}`, this.paymentTopup).then(({data}) => {

                    if (data.success === true) {
                        window.location = data.redirect_route.url;
                    }
                })



            }
        },

        beforeMount() {

            axios.get(`projects/${this.project_id}`).then(({data}) => {
                this.project = data.project;
                this.minPayableAmount = parseFloat(this.project.budget.replace(',', '')) * 0.5;
            }).catch(() => {
                this.projectNotFound = true;
            });
        },
        mounted() {

            axios.get('currencies').then(({data}) => {
                this.currencies = data.currencies;
            })

            axios.get('payment_options').then(({data}) => {
                this.paymentOptions = data.payment_options;
                this.selectedPaymentOption = data.payment_options[0];
            })

            if (this.trxref && this.reference) {
                this.confirmingPayment = true;
                this.hasReference = true;
                axios.get(`/payment/callback/?trxref=${this.$route.query.trxref}&reference=${this.$route.query.reference}`).then(({data}) => {
                    this.confirmingPayment = false;
                    this.paymentSuccess = data.success;
                    setTimeout(function () {
                        this.$router.push({name: 'Dashboard'})
                    }, 5000);

                }).catch(({error}) => {
                    this.confirmingPayment = false;
                    this.paymentSuccess = false;
                    this.failedMessage = 'the reference was not found';
                })
            } else {
                this.hasReference = false;
                this.confirmingPayment = false;
                axios.get('user/pp/get-transaction-reference').then(({data}) => {
                    this.paymentTopup.reference = data;
                    this.paymentTopup.orderId = md5('topup_order/' + 0 + '/' + new Date());
                });
                let name = this.user.name.split(' ');
                this.paymentTopup.first_name = name[0];
                this.paymentTopup.last_name = [...name][0];
                this.paymentTopup.phone = this.user.profile.phone_number;
                this.paymentTopup.id = this.user.id;
                this.paymentTopup.metadata = {
                    user_id: this.user.id,
                    name: this.user.name,
                    email: this.user.email,
                    project_id: this.project_id
                }
                this.paymentTopup.email = this.user.email;
                this.paymentTopup.orderId = md5('topup_order/' + 0 + '/' + new Date());


            }

        },

        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            }),


        },
    }
</script>

<style scoped>

</style>
