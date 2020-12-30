<template>
    <div class="jb-main-section-wrapper">

            <div class="section no-padding-margin-top-bottom">


                <div class="container">

                    <div class="columns is-multiline">
                        <div class="column is-12 is-8-tablet is-8-desktop">

                            <template v-if="hasReference">
                                <div
                                    class="text-center jb-success-box " :class="{'has-background-success':paymentSuccess}">
                                    <div v-if="confirmingPayment  && !paymentSuccess " class="has-text-centered">

                                        <div class="loader mt-2"></div>
                                        <p class="t-white">Confirming your payment status</p>

                                    </div>
                                    <div v-if="paymentSuccess && !confirmingPayment" class="has-text-centered">
                                        <success-animated-icon class=""/>
                                        <p class="t-white">Your payment was successful</p>
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
            title: 'Deposit Made',
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
                    metadata: {}
                }
            }
        },

        methods: {

        },

        mounted() {

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
