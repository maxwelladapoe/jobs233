<template>
    <ValidationObserver v-slot="{handleSubmit}" ref="submitPortfolioForm">
        <form>

            <div class="modal-card jb-add-portfolio-item-modal">


                <header class="modal-card-head">
                    <p class="modal-card-title">Review & Rating</p>
                    <button
                        type="button"
                        class="delete"
                        @click="$emit('close')"/>
                </header>
                <section class="modal-card-body">

                    <b-loading :is-full-page="false" v-model="isLoading">
                        <div class="loader-with-percentage-wrap">
                            <div class="loader-with-percentage"></div>
                            <div class="percentage t-orange">{{ uploadPercentage }}%</div>
                        </div>

                    </b-loading>

                    <div class="jb-add-portfolio-item-form">

                        <ValidationObserver v-slot="{handleSubmit}" ref="submitRatingForm">


                            <form>


                                <div class="form-details mt-3">
                                    <b-field label="Rate this creative">
                                    </b-field>
                                    <b-rate custom-text="Skill" v-model="rating.skill"></b-rate>

                                    <b-rate custom-text="Quality of work" v-model="rating.qow"></b-rate>
                                    <b-rate custom-text="Cooperation" v-model="rating.cooperation"></b-rate>
                                    <b-rate custom-text="Communication" v-model="rating.communication"></b-rate>
                                    <b-rate custom-text="Timeliness" v-model="rating.timeliness"></b-rate>

                                    <b-field>
                                        <p class="t-4 t-bold">Total Score: {{ averageRating }} </p>
                                    </b-field>


                                    <ValidationProvider
                                        mode="lazy"
                                        persist
                                        name="hire again" slim
                                        :rules="{ required: true, min: 3}"
                                        v-slot="{ errors, valid }"
                                    >

                                    <b-field expanded class="mt-5"
                                             :message="errors"
                                             :type="{ 'is-danger': errors[0], 'is-success': valid }"

                                             label="Would you like to hire this creative again, if you had a similar project?">
                                        <b-radio-button expanded v-model="rating.hireAgain"
                                                        native-value="Yes"
                                                        type="is-success  is-outlined">
                                            <b-icon icon="check"></b-icon>
                                            <span>Yes i would like to</span>
                                        </b-radio-button>

                                        <b-radio-button expanded v-model="rating.hireAgain"
                                                        native-value="Yep"
                                                        type=" is-primary is-outlined">
                                            <span>Probably</span>
                                        </b-radio-button>

                                        <b-radio-button expanded v-model="rating.hireAgain"
                                                        native-value="No"
                                                        type="is-danger is-outlined">
                                            <b-icon icon="close"></b-icon>

                                            <span>No i wouldn't</span>
                                        </b-radio-button>

                                    </b-field>

                                    </ValidationProvider>


                                    <ValidationProvider
                                        mode="lazy"
                                        name="review" slim
                                        :rules="{ required: true, min: 3}"
                                        v-slot="{ errors, valid }"
                                    >

                                        <b-field label="Share your experience" class="mt-5"
                                                 :message="errors"
                                                 :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                 expanded
                                        >
                                            <b-input type="textarea" no-resize rows="2"
                                                     v-model="rating.review"></b-input>
                                        </b-field>
                                    </ValidationProvider>

                                    <b-field class="text-right mb-5">
                                        <div class="buttons">
                                            <b-button type=""
                                                      @click.prevent="skipRating">Skip
                                            </b-button>
                                            <b-button type="is-success"
                                                      @click.prevent="handleSubmit(submitRating)">Submit
                                            </b-button>
                                        </div>

                                    </b-field>
                                </div>
                            </form>
                        </ValidationObserver>
                    </div>

                </section>
            </div>


        </form>
    </ValidationObserver>

</template>

<script>

import AttachSingleFile from "./extras/AttachSingleFile";
import {SnackbarProgrammatic as Snackbar} from "buefy";

export default {
    name: "ReviewAndRating",

    props: ['projectId'],

    data() {
        return {
            isLoading: false,
            uploadPercentage: 0,
            rating: {
                skill: 0,
                qow: 0,
                cooperation: 0,
                communication: 0,
                timeliness: 0,
                review: '',
                hireAgain: '',
                totalAverageRating: 0,
                projectId: '',
            },
        }
    },

    mounted() {
        console.log(this.projectId);
        this.rating.projectId = this.projectId;
    },

    computed: {
        averageRating() {
            let total;
            total = (this.rating.skill
                + this.rating.qow
                + this.rating.cooperation
                + this.rating.communication
                + this.rating.timeliness
            ) / 5;
            this.rating.totalAverageRating = total;
            return total;
        }
    },

    methods: {
        submitRating() {
            //submit rating

            axios.post('rating', this.rating).then(({data}) => {

                this.$emit('submitRating', data);
                this.$refs.submitRatingForm.reset();

            }).catch(e => {
                console.log(e.response.data.errors)
                this.$refs.submitRatingForm.setErrors({...e.response.data.errors})

            })
           this.$emit('close');
        },

        skipRating() {
            console.log("skipping")
            this.$emit('skip')
        },

    },
    components: {
        AttachSingleFile
    }
}
</script>

<style scoped>

</style>
