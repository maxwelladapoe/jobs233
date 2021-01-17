<template>
    <div class="jb-main-section-wrapper">

        <div class="jb-section">
            <div class="section no-padding-margin-top-bottom">

                <div class="container">


                    <div class="columns is-multiline is-mobile">
                        <div
                            class="column is-12-mobile is-3-desktop has-text-centered mb-5 "
                        >
                            <div class="shadow card has-background-black has-text-white">
                                <div class="card-content">
                                    <p class="t-mont  t-bold">Total Funds <b-icon icon="cash" size="is-small"/></p>
                                    <p class="t-3 t-bold t-mont">
                                        <span class="t-normal">₵</span>
                                        {{ user.wallet.balance }}
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="column is-12 is-12-mobile is-12-desktop">
                            <p class="t-mont title t-bold">Deposits <b-icon icon="cash-plus"/></p>

                            <b-table :data="deposits"
                                     :striped="true"
                                     mobile-cards
                                     :paginated="paginationEnabled"
                                     :pagination-simple="true"
                                     :per-page="perPage"
                                     @page-change="onPageChange"
                                     :loading="loading"
                            >
                                <b-table-column field="id" label="ID" width="40" numeric v-slot="props">
                                    {{props.row.id}}
                                </b-table-column>
                                <b-table-column field="project_id" label="Project ID"
                                                v-slot="props">
                                    {{props.row.project_id}}
                                </b-table-column>
                                <b-table-column field="amount" label="Amount"
                                                v-slot="props">

                                    <b-tag type="is-success">
                                        {{props.row.currency.symbol}} {{props.row.amount}}
                                    </b-tag>

                                </b-table-column>
                                <b-table-column field="payment_id" label="Payment ID"
                                                v-slot="props">

                                    {{props.row.payment_id}}

                                </b-table-column>

                                <b-table-column field="created_at" label="Created at"
                                                v-slot="props">

                                    <b-tag type="is-info">
                                        <timeago
                                            :datetime="props.row.created_at"
                                            :auto-update="60"
                                        />
                                    </b-tag>

                                </b-table-column>

                            </b-table>

                        </div>

                    </div>



                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Account",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Account',
        },
        data() {
            return {
                deposits: [],
                perPage: 10,
                paginationEnabled: false,
                currentPage: 1,
                total: 0,
                loading: true,

            }
        },

        mounted() {

            this.loading = true;

            axios.get('deposits').then(({data}) => {
                this.deposits = data.deposits.data;
                this.perPage = data.deposits.per_page;
                this.currentPage = data.deposits.current_page;
                this.total = data.deposits.total;
                this.loading = false;

                if (this.total > this.perPage) {
                    this.paginationEnabled = true;
                } else {
                    this.paginationEnabled = false;

                }


            }).catch((e) => {
                console.log(e)
            })

        },

        methods: {
            onPageChange() {

                this.loading = true;

                axios.get(`deposits/page=${this.currentPage++}`).then(({data}) => {
                    this.deposits = data.deposits.data;
                    this.perPage = data.deposits.per_page;
                    this.currentPage = data.deposits.current_page;
                    this.total = data.deposits.total;
                    this.loading = false;
                    if (this.total > this.perPage) {
                        this.paginationEnabled = true;
                    } else {
                        this.paginationEnabled = false;

                    }


                }).catch((e) => {
                    console.log(e)
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
