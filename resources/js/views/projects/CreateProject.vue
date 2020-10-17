<template>

    <div class="jb-main-section-wrapper" v-if="authenticated">

        <div class="jb-section">
            <div class="container">
                <h1 class="t-mont">Create a project</h1>
                <p class="text-left t-meri t-normal ">Don't waste any more time. Post your project for free <br>
                    and start getting responses in minutes</p>
            </div>
        </div>

        <div class="jb-section-small-special bg-ash-light">
            <div class="container">


                <div class="row">
                    <div class="col-md-8">
                        <div class="jb-step-wrapper ">

                            <div class="jb-step">
                                <p>
                                    <span class="jb-step-circle">1</span> Description
                                    <b-icon icon="chevron-right"/>
                                </p>
                            </div>
                            <div class="jb-step">
                                <p>
                                    <span class="jb-step-circle">2</span> Extra Requirements
                                    <b-icon icon="chevron-right"/>
                                </p>
                            </div>
                            <div class="jb-step">
                                <p>
                                    <span class="jb-step-circle">3</span> Publish
                                    <b-icon icon="chevron-right"/>
                                </p>
                            </div>

                        </div>
                    </div>


                    <!--                    <div class="col-md-4">-->
                    <!--                        <div class="jb-project-save text-right">-->
                    <!--                            <a href="#">-->
                    <!--                                <b-icon icon="hdd"/>-->
                    <!--                                Save</a> | <a href="#"><i class="fas fa-save"></i>-->
                    <!--                            Save & Preview </a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->

                </div>


            </div>

        </div>

        <div class="jb-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 mx-auto  ">


                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <div class="jb-project-form p-3">


                                    <ValidationObserver v-slot="{handleSubmit}" ref="submitProject">
                                        <b-form @submit.prevent="handleSubmit(submitProject)">


                                            <ValidationObserver :key="1" v-if="step ===1">
                                                <validation-provider
                                                    persist
                                                    name="title"
                                                    :rules="{ required: true, min: 3, max:150}"
                                                    v-slot="validationContext"
                                                >

                                                    <b-form-group
                                                        id="title"
                                                        label="Title"
                                                        label-class="t-mont t-bold"
                                                        label-for="title">
                                                        <b-form-input id="title" type="text"
                                                                      rows="6"
                                                                      placeholder=""
                                                                      v-model="project.title"
                                                                      :state="getValidationState(validationContext)"
                                                                      @input="titleCharacterCount()"
                                                                      aria-describedby="title-live-feedback">

                                                        </b-form-input>

                                                        <b-form-invalid-feedback id="title-live-feedback">
                                                            {{validationContext.errors[0] }}
                                                        </b-form-invalid-feedback>

                                                        <small><span class="text-right">

                                                        {{titleLength}} / 150 Characters
                                                        </span>
                                                        </small>

                                                    </b-form-group>

                                                </validation-provider>


                                                <validation-provider
                                                    persist
                                                    name="description"
                                                    :rules="{ required: true, min: 3, max:2000}"
                                                    v-slot="validationContext"
                                                >
                                                    <b-form-group
                                                        id="description"
                                                        label="Description"
                                                        label-class="t-mont t-bold"
                                                        label-for="description"
                                                    >
                                                        <b-form-textarea
                                                            rows="8"
                                                            no-resize
                                                            :state="getValidationState(validationContext)"
                                                            id="textarea-default"
                                                            placeholder="Describe the project here"
                                                            v-model="project.description"
                                                        ></b-form-textarea>

                                                        <b-form-invalid-feedback id="description-live-feedback">
                                                            {{validationContext.errors[0] }}
                                                        </b-form-invalid-feedback>

                                                        <small>0 / 2000 Characters</small>
                                                    </b-form-group>
                                                </validation-provider>


                                                <div class="form-row">
                                                    <div class="col-12 col-md-6">
                                                        <validation-provider
                                                            persist
                                                            name="Category"
                                                            :rules="{required: true}"
                                                        >

                                                            <b-form-group
                                                                id="category"
                                                                label="Category"
                                                                label-class="t-mont t-bold"
                                                                label-for="category"
                                                            >
                                                                <b-form-select v-model="project.category"

                                                                               class="mb-3">
                                                                    <!-- This slot appears above the categories from 'categories' prop -->
                                                                    <template v-slot:first>
                                                                        <b-form-select-option :value="null" disabled>
                                                                            Select a
                                                                            category
                                                                        </b-form-select-option>
                                                                    </template>
                                                                    <b-form-select-option
                                                                        v-for="category  in categories"
                                                                        :key="category.id"
                                                                        :value="category.id">{{category.name}}
                                                                    </b-form-select-option>

                                                                </b-form-select>

                                                            </b-form-group>


                                                        </validation-provider>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <validation-provider
                                                            persist
                                                            name="subcategory"
                                                            :rules="{required: true}"
                                                        >

                                                            <b-form-group
                                                                id="sub_category"
                                                                label="Subcategory"
                                                                label-class="t-mont t-bold"
                                                                label-for="sub_category"
                                                            >
                                                                <b-form-select v-model="project.subcategory"
                                                                               class="mb-3"
                                                                               :disabled="subCategories == null">
                                                                    <!-- This slot appears above the categories from 'categories' prop -->
                                                                    <template v-slot:first>
                                                                        <b-form-select-option :value="null" disabled>
                                                                            Select a
                                                                            subcategory
                                                                        </b-form-select-option>
                                                                    </template>
                                                                    <b-form-select-option
                                                                        v-for="subCategory  in subCategories"
                                                                        :key="subCategory.id"
                                                                        :value="subCategory.id">{{subCategory.name}}
                                                                    </b-form-select-option>

                                                                </b-form-select>

                                                            </b-form-group>


                                                        </validation-provider>
                                                    </div>
                                                </div>


                                                <b-form-group
                                                    id="budget"
                                                    label="Budget"
                                                    label-class="t-mont t-bold"
                                                    label-for="budget"
                                                >

                                                    <div class="form-row">
                                                        <div class="col-3">
                                                            <validation-provider
                                                                :rules="{ required: true, integer:false}"
                                                                name="currency"
                                                                v-slot="validationContext"
                                                            >

                                                                <b-form-select id="budget"
                                                                               placeholder=""
                                                                               name="currency"
                                                                               v-model="project.currency"
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
                                                                                     :key="currency.id"
                                                                                     :value="currency.id">
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
                                                                :rules="{ required: true, integer:true, min:1}"
                                                                name="budget"
                                                                v-slot="validationContext"
                                                            >
                                                                <b-form-input id="budget" type="number" min="1"
                                                                              placeholder=""
                                                                              name="budget"
                                                                              v-model="project.budget"
                                                                              :state="getValidationState(validationContext)"
                                                                              aria-describedby="budget-live-feedback">

                                                                </b-form-input>

                                                                <b-form-invalid-feedback id="budget-live-feedback">
                                                                    {{validationContext.errors[0] }}
                                                                </b-form-invalid-feedback>

                                                            </validation-provider>
                                                        </div>

                                                    </div>

                                                </b-form-group>


                                            </ValidationObserver>


                                            <ValidationObserver :key="2" v-if="step===2">

                                                <validation-provider
                                                    :rules="{ required: true,}"
                                                    name="skills"
                                                    v-slot="validationContext"
                                                >
                                                    <b-form-group
                                                        id="skills"
                                                        label="Skills"
                                                        label-class="t-mont t-bold"
                                                        label-for="skills"
                                                    >
                                                        <b-form-input
                                                            input-id="tags-separators"
                                                            name="skills"
                                                            placeholder=""
                                                            v-model="project.skills"
                                                            :state="getValidationState(validationContext)"
                                                            @input="titleCharacterCount()"
                                                            aria-describedby="title-live-feedback">

                                                        </b-form-input>

                                                        <b-form-invalid-feedback id="title-live-feedback">
                                                            {{validationContext.errors[0] }}
                                                        </b-form-invalid-feedback>

                                                    </b-form-group>
                                                </validation-provider>
                                                <validation-provider
                                                    :rules="{ required: true,}"
                                                    v-slot="validationContext"
                                                >
                                                    <b-form-group
                                                        id="tags"
                                                        label="Tags"
                                                        label-class="t-mont t-bold"
                                                        label-for="budget"
                                                    >
                                                        <b-form-tags
                                                            input-id="tags-separators"

                                                            placeholder=""
                                                            v-model="project.tags"
                                                            :state="getValidationState(validationContext)"
                                                            @input="titleCharacterCount()"
                                                            aria-describedby="title-live-feedback">

                                                        </b-form-tags>

                                                        <b-form-invalid-feedback id="title-live-feedback">
                                                            {{validationContext.errors[0] }}
                                                        </b-form-invalid-feedback>

                                                    </b-form-group>
                                                </validation-provider>


                                                <div class="form-group">

                                                    <label for="projectExtra" class="t-mont t-bold">Any Extra
                                                        Requirements</label>


                                                    <textarea class="form-control" id="projectExtra"
                                                              v-model="project.additional_details"
                                                              @input="titleCharacterCount()" rows="5"
                                                              style="width: 100%"></textarea>
                                                </div>
                                                <!--deadline -->
                                                <validation-provider
                                                    :rules="{ required: true,}"
                                                    name="deadline"
                                                    v-slot="validationContext"
                                                >
                                                    <b-form-group
                                                        id="deadline"
                                                        label="Expected time"
                                                        label-class="t-mont t-bold"
                                                        label-for="deadline"
                                                    >
                                                        <b-form-datepicker
                                                            input-id="deadline"
                                                            name="deadline"
                                                            placeholder=" select deadline here"
                                                            v-model="project.deadline"
                                                            :state="getValidationState(validationContext)"
                                                            aria-describedby="deadline-live-feedback">

                                                        </b-form-datepicker>

                                                        <b-form-invalid-feedback id="deadline-live-feedback">
                                                            {{validationContext.errors[0] }}
                                                        </b-form-invalid-feedback>

                                                    </b-form-group>
                                                </validation-provider>

                                                <attach-files v-model="uploadedFileList" class="mb-3"></attach-files>


                                            </ValidationObserver>


                                            <div :key="4" v-if="step===3">
                                                <p class="t-mont t-bold t-orange">Title</p>
                                                <p>{{project.title}}</p>

                                                <p class="t-mont t-bold t-orange"> Description</p>
                                                <p>{{project.description}}</p>

                                                <p class="t-mont t-bold t-orange"> Category</p>
                                                <p>{{project.category}}</p>

                                                <p class="t-mont t-bold t-orange"> Budget</p>
                                                <p>{{project.budget}}</p>

                                                <p class="t-mont t-bold t-orange"> Additional Information</p>
                                                <p>{{project.additional_details}}</p>

                                                <p class="t-mont t-bold t-orange"> skills</p>
                                                <h6>
                                                    <template v-for="skill in project.skills.split(',')">
                                                        <b-badge class="mr-1" variant="success">{{skill}}</b-badge>
                                                    </template>
                                                </h6>

                                                <p class="t-mont t-bold t-orange"> tags</p>

                                                <h6>
                                                    <template v-for="tag in project.tags.split(',')">
                                                        <b-badge class="mr-1" variant="success">{{tag}}</b-badge>
                                                    </template>

                                                </h6>


                                            </div>


                                            <div v-if="!isLoading && !isSuccessful"
                                                 class=" form-group mr-auto text-right t-white">

                                                <button type="submit" class="btn bg-orange t-mont"
                                                        v-if="step> 1 && step <= totalSteps"
                                                        @click.prevent="prev()">
                                                    Previous
                                                </button>

                                                <button type="submit" class="btn bg-orange t-mont t-white">
                                            <span v-if="step ===totalSteps">
                                                Create Project
                                            </span>
                                                    <span v-else>
                                                  Next
                                            </span>
                                                </button>

                                            </div>

                                            <div v-if="isSuccessful && project.id" class="text-right">
                                                <span class="text-success"><b-icon-check-circle-fill/> Your Project was Posted Successfully</span>

                                                <b-button @click="resetProject()" variant="orange" class="ml-2">Post
                                                    Another Project
                                                </b-button>

                                                <b-button @click="viewPostedProject"
                                                          class="ml-2" variant="success">View Project
                                                </b-button>
                                            </div>

                                            <div
                                                class="form-group text-right d-flex align-items-start justify-content-end"
                                                v-if="isLoading">
                                                <div
                                                    class=" mr-4 d-flex flex-wrap align-baseline justify-content-center"
                                                >
                                                    <p class="mr-2 p-0 m-0">Posting... </p>
                                                    <div class="loader"></div>
                                                </div>
                                            </div>

                                        </b-form>

                                    </ValidationObserver>


                                </div>

                            </div>
                            <div class="col-12 col-lg-4">


                            </div>
                        </div>


                    </div>

                </div>

            </div>
        </div>


    </div>

</template>

<script>


    import {mapGetters} from "vuex";
    import AttachFiles from "../../components/extras/AttachFiles";

    export default {

        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Create Project',
        },

        data: function () {
            return {
                categories: [],
                skillsList: [],
                uploadedFileList: [],
                isLoading: false,
                isSuccessful: false,

                dropAreaDragOver: false,
                dropAreaDragLeave: false,

                project: {
                    title: '',
                    description: '',
                    category: null,
                    budget: '',
                    currency: null,
                    subcategory: null,
                    additional_details: '',
                    skills: '',
                    tags: [],
                    deadline: '',
                },
                currencies: [],

                titleLength: 0,
                step: 1,
                totalSteps: 3,

                editorOption: {
                    modules: {
                        toolbar: '#toolbar'
                    }
                }
            }
        },
        methods: {

            viewPostedProject() {
                if (this.project.id) {
                    this.$router.push({name: 'singleProject', params: {id: this.project.id}});

                }
            },

            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },

            titleCharacterCount() {
                const length = this.project.title.length;
                this.titleLength = length;
                if (length === 150) {

                }
            },

            prev() {
                this.step--;
            },


            resetProject() {
                this.project = {
                    title: '',
                    description: '',
                    category: null,
                    budget: '',
                    currency: null,
                    subcategory: null,
                    additional_details: '',
                    skills: '',
                    tags: [],
                    deadline: '',
                }
                this.step = 1;
                this.$refs.submitProject.reset();
                //reset the errors
            },
            submitProject() {

                let formData = new FormData();


                for (let i = 0; i < this.uploadedFileList.length; i++) {
                    formData.append('attachments[' + i + ']', this.uploadedFileList[i]);
                }

                for (let key in this.project) {
                    formData.append(key, this.project[key]);
                }

                // data.append(...this.project);
                const config = {

                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },

                    onUploadProgress: (progressEvent) => {
                        let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                        console.log(percentCompleted)
                    }
                };

                if (this.step < this.totalSteps) {
                    this.step++
                } else {
                    this.isLoading = true;
                    axios.post('projects', formData, config)

                        .then(({data}) => {
                            if (data.status === 'true') {
                                this.project = data.project;
                                //this.resetProject();
                                this.isLoading = false;
                                this.isSuccessful = true;
                            } else {
                                return
                            }

                        })
                        .catch((errorRes) => {
                            //show error
                            this.$refs.submitProject.setErrors({...errorRes.response.data.errors})
                        });
                }

            }

        },
        beforeCreate() {
            axios.get('projects/categories-skills').then(({data}) => {
                this.categories = data.categories;
                this.skillsList = data.skills;

            });

            axios.get('currencies').then(({data}) => {
                this.currencies = data.currencies;

            })

        },
        computed: {

            subCategories() {
                let subCat = null;

                if (this.project.category != null) {
                    let selectedCategory = this.categories.find(
                        (category) => {
                            return category.id === this.project.category
                        }
                    );
                    subCat = selectedCategory.subcategories;
                }

                return subCat;
            },

            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            })

        },
        watch: {
            title: function () {
                if (this.project.title.length === 10) {

                }
            }
        },
        components: {AttachFiles}
    }
</script>


<style lang="scss">


    .b-form-tags-button {

    }

    .b-form-tag {
        margin-right: 5px;
        min-width: 70px;
        padding: 0 !important;
        font-size: 0.8em !important;
        line-height: 2em !important;

        .b-form-tag-content {
            padding: 0;
            margin: 0;
        }

        .b-form-tag-remove {
        }


    }
</style>

