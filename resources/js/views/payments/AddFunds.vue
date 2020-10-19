<template>
    <div class="jb-main-section-wrapper">

        <div class="jb-section">
            <div class="container">
                <h1 class="t-mont">Add Funds</h1>
                <p class="text-left t-meri t-normal ">You can speed up the bidding process by ensuring ahead of time
                    that you have adequate funds in your account to cover all planned purchases. This adds a "deposit
                    made" icon to your project when your balance is more than 50% of the amount for the current
                    paymentTopup.

                </p>

                <!--                this was just added it will be a future feature -->
                <p>
                    When topping up your balance, please note: Per our fraud control guidelines, some transactions
                    (especially those involving third-party payments) may require additional verification. In some
                    cases, we’ll need phone verification for the card holder.

                </p>
            </div>
        </div>

        <div class="jb-section">
            <div class="container">

                <div class="row">
                    <div class="col-md-3">
                        <p><span class="t-orange t-bold t-mont">Your current balance:</span> <span class="t-bold">{{user.wallet.balance}}</span>
                        </p>

                        <b-form-group label=" Select a payment Method">
                            <b-form-select>
                                <b-form-select-option value="Paystack">Paystack</b-form-select-option>
                            </b-form-select>
                        </b-form-group>

                    </div>

                    <div class="col-md-12 col-lg-5 offset-0 offset-lg-1">

                        <template v-if="!hasReference">
                            <p class="h2">Paystack</p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias placeat porro recusandae
                                vitae
                                voluptatem. Amet aperiam commodi delectus fugit ipsum laborum optio placeat voluptas
                                voluptates.
                                Animi ducimus harum in natus.
                            </p>


                            <b-form class="mt-5">


                                <b-form-group
                                    id="amount"
                                    label="Top-up Amount"
                                    label-class="t-mont t-bold"
                                    label-for="amount"
                                >

                                    <div class="form-row">
                                        <div class="col-3">
                                            <validation-provider
                                                :rules="{ required: true, integer:false}"
                                                name="currency"
                                                v-slot="validationContext"
                                            >

                                                <b-form-select id="currency"
                                                               placeholder=""
                                                               name="currency"
                                                               v-model="paymentTopup.currency"
                                                               :state="getValidationState(validationContext)"
                                                               aria-describedby="currency-live-feedback">

                                                    <!-- This slot appears above the categories from 'categories' prop -->
                                                    <template v-slot:first>
                                                        <b-form-select-option :value="null" disabled>
                                                            Select a
                                                            currency
                                                        </b-form-select-option>
                                                    </template>


                                                    <b-select-option v-for="currency in currencies"
                                                                     :key="currency.name"
                                                                     :value="currency.name">
                                                        {{currency.name}}
                                                    </b-select-option>

                                                </b-form-select>

                                                <b-form-invalid-feedback id="currency-live-feedback">
                                                    {{validationContext.errors[0] }}
                                                </b-form-invalid-feedback>


                                            </validation-provider>
                                        </div>

                                        <div class="col-9">
                                            <validation-provider
                                                :rules="{ required: true, min:1.0}"
                                                name="amount"
                                                v-slot="validationContext"
                                            >
                                                <b-form-input id="amount" type="number" step="0.10" min="1"
                                                              placeholder=""
                                                              name="amount"
                                                              v-model="paymentTopup.amount"
                                                              :state="getValidationState(validationContext)"
                                                              aria-describedby="amount-live-feedback">

                                                </b-form-input>

                                                <b-form-invalid-feedback id="amount-live-feedback">
                                                    {{validationContext.errors[0] }}
                                                </b-form-invalid-feedback>

                                            </validation-provider>
                                        </div>

                                    </div>

                                </b-form-group>


                                <b-form-group class="text-right">
                                    <b-button @click="submitPaymentTopUp">Top-up</b-button>
                                </b-form-group>

                            </b-form>

                        </template>

                        <template v-if="hasReference">
                            <div class="text-center bg-orange d-flex align-items-center justify-content-center"
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

        <div class="jb-section">
            <div class="container">

            </div>

        </div>

    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import md5 from 'js-md5'
    import SuccessAnimatedIcon from "../../components/extras/SuccessAnimatedIcon";

    export default {
        name: "AddFunds",
        components: {SuccessAnimatedIcon},
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Add Funds',
        },
        data() {
            return {
                hasReference: false,
                paymentSuccess: null,
                confirmingPayment: false,
                failedMessage: '',
                currencies: [],
                paymentTopup: {
                    email: '',
                    orderId: '',
                    amount: '1.00',
                    currency: 'GHS',
                    reference: '',
                    first_name: '',
                    last_name: '',
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

                this.paymentTopup.amount = Number(this.paymentTopup.amount).toFixed(2)
                axios.post('/pay', this.paymentTopup).then(({data}) => {

                    if (data.success === true) {
                        console.log(data.redirect_route);
                        window.location = data.redirect_route.url;
                    }
                })
            }
        },
        mounted() {

            axios.get('currencies').then(({data}) => {
                this.currencies = data.currencies;

            })

            if (this.$route.query.trxref && this.$route.query.reference) {
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
            })
        },
    }
</script>

<style scoped>

</style>
