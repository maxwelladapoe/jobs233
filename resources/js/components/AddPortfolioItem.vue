<template>
    <ValidationObserver v-slot="{handleSubmit}" ref="submitPortfolioForm">
        <form>

            <div class="modal-card jb-add-portfolio-item-modal" >

                <header class="modal-card-head">
                    <p class="modal-card-title">Add Portfolio Item</p>
                    <button
                        type="button"
                        class="delete"
                        @click="$emit('close')"/>
                </header>
                <section class="modal-card-body">
                    <div class="jb-add-portfolio-item-form">
                        <div class="form-img">
                            <attach-single-file v-model="portfolio.cover_image"></attach-single-file>
                        </div>

                        <div class="form-details mt-3">

                            <b-field label="Name" label-class="t-bold t-mont">
                                <b-input type="text" v-model="portfolio.name"></b-input>
                            </b-field>

                            <b-field label="Description" label-class="t-bold t-mont">
                                <b-input type="textarea" no-resize rows="4"
                                         v-model="portfolio.description"></b-input>
                            </b-field>
                            <b-field label="Skills & Tools" label-class="t-bold t-mont">
                                <b-taginput
                                    ellipsis
                                    icon="label"
                                    placeholder="Skills / Tools used"

                                    v-model="portfolio.skills_and_tools"
                                    remove-on-delete>
                                </b-taginput>

                            </b-field>


                            <b-field class="text-right">
                                <b-button type="submit"
                                          @click.prevent="handleSubmit(submitPortfolio)">Save
                                </b-button>
                            </b-field>
                        </div>

                    </div>

                </section>
            </div>


        </form>
    </ValidationObserver>

</template>

<script>

    import AttachSingleFile from "./extras/AttachSingleFile";

    export default {
        name: "AddPortfolioItemForm",

        data() {
            return {
                portfolio: {
                    name: '',
                    description: '',
                    cover_image: new File([], "", undefined),
                    skills_and_tools: []

                },
            }
        },

        methods: {
            submitPortfolio() {


                let formData = new FormData();


                for (let key in this.portfolio) {

                    if (key === 'skills_and_tools') {
                        formData.append(key, this.portfolio[key].toString())
                    } else {
                        formData.append(key, this.portfolio[key]);
                    }
                }

                // data.append(...this.portfolio);
                const config = {

                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },

                    onUploadProgress: (progressEvent) => {
                        let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                        console.log(percentCompleted)
                    }
                };


                axios.post(`/portfolio/add`, formData, config).then(({data}) => {
                    console.log(data);
                })
            },

        },
        components: {
            AttachSingleFile
        }
    }
</script>

<style scoped>

</style>
