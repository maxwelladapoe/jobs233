<template>

    <div class="jb-main-section-wrapper" v-if="authenticated">


        <div class="jb-section-small-special bg-ash-light">

            <div class="section no-padding-margin-top-bottom">

                <div class="container">


                    <div class="columns">
                        <div class="col-md-8">
                            <div class="jb-step-wrapper ">

                                <div class="jb-step">
                                    <p>
                                        <span class="jb-step-circle"
                                              :class="step===1 ? 'active' : 'not-active' ">1</span> Description
                                        <b-icon icon="chevron-right"/>
                                    </p>
                                </div>
                                <div class="jb-step">
                                    <p>
                                        <span class="jb-step-circle"
                                              :class="step===2 ? 'active' : 'not-active' ">2</span> Extra Requirements
                                        <b-icon icon="chevron-right"/>
                                    </p>
                                </div>
                                <div class="jb-step">
                                    <p>
                                        <span class="jb-step-circle"
                                              :class="step===3 ? 'active' : 'not-active' ">3</span> Publish
                                        <b-icon icon="chevron-right"/>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="jb-section">

            <div class="section no-padding-margin-top-bottom">
                <div class="container">


                    <div class="columns is-desktop">
                        <div class="column is-12 is-8-desktop">
                            <div class="jb-project-form p-3">

                                <ValidationObserver v-slot="{handleSubmit}" ref="submitProject">
                                    <form @submit.prevent="handleSubmit(updateProject)">


                                        <ValidationObserver :key="1" v-if="step ===1">
                                            <ValidationProvider
                                                persist
                                                name="title" slim
                                                :rules="{ required: true, min: 3, max:150}"
                                                v-slot="{ errors, valid }"
                                            >
                                                <b-field
                                                    label="Title"
                                                    label-class="t-mont t-bold"
                                                    :message="errors"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    label-for="title">

                                                    <b-input id="title" type="text"
                                                             placeholder=""
                                                             v-model="project.title"
                                                             aria-describedby="title-live-feedback">

                                                    </b-input>

                                                </b-field>

                                            </ValidationProvider>


                                            <ValidationProvider
                                                persist
                                                name="description"
                                                :rules="{ required: true, min: 3, max:2000}"
                                                v-slot="{ errors, valid }" slim
                                            >
                                                <b-field
                                                    id="description"
                                                    label="Description"
                                                    label-class="t-mont t-bold"
                                                    label-for="description"
                                                    :message="errors"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                >
                                                    <b-input
                                                        rows="8"
                                                        no-resize
                                                        type="textarea"
                                                        expanded

                                                        id="textarea-default"
                                                        placeholder="Describe the project here"
                                                        v-model="project.description"
                                                    ></b-input>

                                                </b-field>
                                            </ValidationProvider>


                                            <b-field grouped>


                                                <ValidationProvider
                                                    persist
                                                    name="Category"
                                                    :rules="{required: true}"
                                                    v-slot="{ errors, valid }"
                                                    slim
                                                >

                                                    <b-field
                                                        id="category"
                                                        label="Category"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                        expanded
                                                    >

                                                        <b-select placeholder="Select a category"
                                                                  v-model="project.category_id" expanded>
                                                            <option
                                                                v-for="category  in categories"
                                                                :key="category.id"
                                                                :value="category.id">{{category.name}}
                                                            </option>

                                                        </b-select>

                                                    </b-field>


                                                </ValidationProvider>

                                                <ValidationProvider
                                                    persist
                                                    name="subcategory"
                                                    v-slot="{ errors, valid }"
                                                    :rules="{required: true}" slim
                                                >
                                                    <b-field
                                                        id="sub_category"
                                                        label="Subcategory"
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                        expanded
                                                    >
                                                        <b-select v-model="project.secondary_category_id"
                                                                  placeholder="Select a subcategory"
                                                                  expanded
                                                                  :disabled="subCategories == null">

                                                            <option
                                                                v-for="subCategory  in subCategories"
                                                                :key="subCategory.id"
                                                                :value="subCategory.id">{{subCategory.name}}
                                                            </option>

                                                        </b-select>

                                                    </b-field>


                                                </ValidationProvider>

                                            </b-field>


                                            <b-field

                                                label="Budget"
                                                label-class="t-mont t-bold"
                                                label-for="budget"
                                                expanded
                                                grouped
                                            >


                                                <ValidationProvider
                                                    :rules="{ required: true, integer:false}"
                                                    name="currency"
                                                    v-slot="{ errors, valid }" slim
                                                >

                                                    <b-field
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    >
                                                        <b-select
                                                            placeholder="  Select a
                                                                            currency"
                                                            name="currency"
                                                            v-model="selectedCurrency">

                                                            <option v-for="currency in currencies"
                                                                    :key="currency.id"
                                                                    :value="currency">
                                                                {{currency.name}}
                                                            </option>

                                                        </b-select>
                                                    </b-field>

                                                </ValidationProvider>


                                                <ValidationProvider
                                                    :rules="{ required: true,  min:1}"
                                                    name="budget"
                                                    v-slot="{ errors, valid }" slim
                                                >
                                                    <b-field
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                        expanded
                                                    >
                                                        <b-input id="budget" type="text" min="1"
                                                                 placeholder=""
                                                                 name="budget"
                                                                 expanded
                                                                 v-model="project.budget">

                                                        </b-input>

                                                    </b-field>


                                                </ValidationProvider>


                                            </b-field>


                                        </ValidationObserver>


                                        <ValidationObserver :key="2" v-if="step===2">

                                            <ValidationProvider
                                                :rules="{ required: true,}"
                                                name="skills"
                                                v-slot="{ errors, valid }"
                                            >
                                                <b-field
                                                    id="skills"
                                                    label="Skills"
                                                    label-class="t-mont t-bold"
                                                    :message="errors"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                    label-for="skills"
                                                >
                                                    <b-taginput
                                                        input-id="tags-separators"
                                                        name="skills"
                                                        :data="skillsListFiltered"
                                                        icon="label"
                                                        autocomplete
                                                        field="name"
                                                        @typing="getFilteredSkills"
                                                        placeholder="Add preferred skills"
                                                        v-model="project.skills"
                                                        aria-describedby="title-live-feedback">
                                                        <template slot-scope="props">
                                                            {{props.option.name}}
                                                        </template>
                                                        <template slot="empty">
                                                            There are no items
                                                        </template>
                                                    </b-taginput>

                                                </b-field>


                                            </ValidationProvider>
                                            <ValidationProvider
                                                :rules="{ required: false,}"
                                                v-slot="{ errors, valid }"
                                                name="Tags"
                                            >
                                                <b-field
                                                    id="tags"
                                                    label="Tags"
                                                    label-class="t-mont t-bold"
                                                    :message="errors"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                >
                                                    <b-taginput
                                                        input-id="tags-separators"

                                                        v-model="project.tags"
                                                        ellipsis
                                                        icon="label"
                                                        placeholder="Add a tag"
                                                        aria-close-label="Delete this tag">

                                                    </b-taginput>


                                                </b-field>
                                            </ValidationProvider>


                                            <ValidationProvider
                                                :rules="{ required: false,}"
                                                v-slot="{ errors, valid }"
                                                name="extra requirements"
                                            >
                                                <b-field label="Any Extra
                                                Requirements"
                                                         :message="errors"
                                                         :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                >
                                                    <b-input id="projectExtra"
                                                             v-model="project.additional_details"
                                                             rows="2"
                                                             type="textarea">
                                                    </b-input>
                                                </b-field>
                                            </ValidationProvider>

                                            <!--deadline -->
                                            <ValidationProvider
                                                :rules="{ required: true,}"
                                                name="deadline"
                                                v-slot="{ errors, valid }"
                                            >
                                                <b-field
                                                    id="deadline"
                                                    label="Expected time"
                                                    label-class="t-mont t-bold"
                                                    label-for="deadline"
                                                    :message="errors"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                >
                                                    <b-datepicker
                                                        input-id="deadline"
                                                        name="deadline"
                                                        placeholder=" Select deadline"
                                                        v-model="project.deadline"
                                                        aria-describedby="deadline-live-feedback">

                                                    </b-datepicker>

                                                </b-field>
                                            </ValidationProvider>


                                        </ValidationObserver>


                                        <div :key="4" v-if="step===3">
                                            <p class="t-mont t-bold t-orange">Title</p>
                                            <p>{{project.title}}</p>

                                            <p class="t-mont t-bold t-orange"> Description</p>
                                            <p>{{project.description}}</p>

                                            <p class="t-mont t-bold t-orange"> Category</p>
                                            <p class="mb-3"><span class="t-bold">{{project.category.name}}</span> >
                                                {{project.subcategory.name}} </p>

                                            <p class="t-mont t-bold t-orange"> Budget</p>
                                            <p>{{selectedCurrency.symbol}} {{project.budget}}</p>

                                            <p class="t-mont t-bold t-orange" v-if="project.additional_details"> Extra
                                                Requirements</p>
                                            <p>{{project.additional_details}}</p>

                                            <p class="t-mont t-bold t-orange"> skills</p>
                                            <h6>
                                                <b-taglist>
                                                    <template v-for="skill in project.skills">

                                                        <b-tag type="is-success">{{skill}}</b-tag>


                                                    </template>
                                                </b-taglist>
                                            </h6>

                                            <p class="t-mont t-bold t-orange"> tags</p>

                                            <h6>
                                                <b-taglist>
                                                    <template v-for="tag in project.tags">
                                                        <b-tag class="mr-1" type="is-success">{{tag}}</b-tag>
                                                    </template>
                                                </b-taglist>
                                            </h6>


                                        </div>


                                        <b-field class="mt-5">

                                            <div v-if="!isLoading && !isSuccessful"
                                                 class=" form-group mr-auto text-right t-white">

                                                <button type="submit" class="button bg-orange"
                                                        v-if="step> 1 && step <= totalSteps"
                                                        @click.prevent="prev()">
                                                    Previous
                                                </button>

                                                <button type="submit" class="button bg-orange t-white">
                                            <span v-if="step ===totalSteps">
                                                Update Project
                                            </span>
                                                    <span v-else>
                                                  Next
                                            </span>
                                                </button>

                                            </div>

                                            <div v-if="isSuccessful && project.id" class="text-right">
                                                <span class="text-success"><b-icon icon="check-circle"/> Your Project
                                                    was updated successfully</span>

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
                                                    <p class="mr-2 p-0 m-0">Updating... </p>
                                                    <div class="loader"></div>
                                                </div>
                                            </div>
                                        </b-field>
                                    </form>

                                </ValidationObserver>


                            </div>

                        </div>
                        <div class="column is-12 is-4-desktop">

                            <!--show and upload attachments here -->

                            <template v-if="project.attachments && project.attachments.length >0">
                                <p class="t-mont jb-project-title-small t-bold t-orange mt-3">Attachments</p>


                                <div class="columns mt-2 is-multiline is-mobile">
                                    <template v-for="(attachment,index) in project.attachments">


                                        <div class="column is-12-mobile is-6-desktop" :key="index">
                                            <div class="box is-relative">
                                                <div>

                                                    <div>
                                                        <template
                                                            v-if="['xlsx','docx'].includes(attachment.name.split('.').pop().toLowerCase() )">
                                                            <img
                                                                src="/images/file_type_icons/doc.svg"
                                                                alt="" width="35">
                                                        </template>
                                                        <template v-else>
                                                            <img
                                                                :src="`/images/file_type_icons/${attachment.name.split('.').pop()}.svg`"
                                                                alt="" width="35">
                                                        </template>

                                                    </div>

                                                    <div>
                                                        <p class="t-6">{{ attachment.name }}</p>
                                                    </div>


                                                </div>

                                                <button class="jb-close-button delete" type="button" rounded
                                                        size="is-small"
                                                        @click="deleteAttachment(attachment)"
                                                        title="Remove file">
                                                    <b-icon icon="close" size="is-small"/>
                                                </button>


                                            </div>

                                        </div>

                                    </template>
                                </div>


                            </template>


                            <attach-files v-model="uploadedFileList" class="mb-3"></attach-files>


                            <b-button @click="uploadAttachments">Upload</b-button>
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
    import {SnackbarProgrammatic as Snackbar} from 'buefy'


    export default {

        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Create Project',
        },

        data: function () {
            return {
                categories: [],
                skillsList: [],
                selectedCurrency: {},
                skillsListFiltered: [],
                uploadedFileList: [],
                isLoading: false,
                isSuccessful: false,

                dropAreaDragOver: false,
                dropAreaDragLeave: false,
                projectNotFound: false,
                project: {},
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

            getFilteredSkills(text) {
                this.skillsListFiltered = this.skillsList.filter((option) => {
                    return option.name
                        .toString()
                        .toLowerCase()
                        .indexOf(text.toLowerCase()) >= 0
                })
            },
            viewPostedProject() {
                if (this.project.id) {
                    this.$router.push({name: 'singleProject', params: {id: this.project.id}});

                }
            },

            prev() {
                this.step--;
            },
            formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            },
            updateProject() {
                if (!this.project.worker_id || !this.project.accepted_bid_id) {


                    if (this.step < this.totalSteps) {
                        this.step++
                    } else {


                        let formData = new FormData();

                        for (let key in this.project) {

                            //some filtering is going on here to reduce the request size
                            if (key === 'category' || key === 'subcategory') {
                                formData.append(key, this.project[key].id)
                            } else if (key === 'skills') {

                                formData.append(key, this.project.skills.toString());

                            } else if (key === 'deadline') {
                                formData.append(key, this.formatDate(new Date(this.project[key])))
                            } else if (key === 'currency') {
                                formData.append(key, this.selectedCurrency.id)
                            } else if (key === 'user' || key === 'attachments') {
                                // formData.append(key, this.formatDate(new Date(this.project[key])))
                            } else {
                                formData.append(key, this.project[key]);

                            }
                        }

                        // data.append(...this.project);
                        let config = {

                            headers: {
                                'Content-Type': 'multipart/form-data'
                            },

                            onUploadProgress: (progressEvent) => {
                                let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                                console.log(percentCompleted)
                            }
                        };


                        this.isLoading = true;


                        axios.post(`projects/update/${this.project.id}`, formData, config)

                            .then(({data}) => {
                                if (data.success === true) {
                                    this.createdProject = data.project;
                                    //this.resetProject();
                                    Snackbar.open(data.message)

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

            uploadAttachments() {

                if ((!this.project.worker_id || !this.project.accepted_bid_id) && this.uploadedFileList) {
                    let formData = new FormData();
                    let config = {

                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },

                        onUploadProgress: (progressEvent) => {
                            let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                            console.log(percentCompleted)
                        }
                    };

                    for (let i = 0; i < this.uploadedFileList.length; i++) {
                        formData.append('attachments[' + i + ']', this.uploadedFileList[i]);
                    }

                    formData.append('project_id', this.project.id);


                    axios.post(`/attachments`, formData, config)

                        .then(({data}) => {
                            if (data.success === true) {
                                console.log(data.attachments);
                                this.uploadedFileList = [];
                                this.project.attachments = data.attachments;

                                //this.resetProject();
                                Snackbar.open(data.message)

                                // this.isLoading = false;
                                // this.isSuccessful = true;
                            } else {
                                return
                            }

                        })
                        .catch((errorRes) => {
                            //show error
                            this.$refs.submitProject.setErrors({...errorRes.response.data.errors})
                        });


                }

            },

            deleteAttachment(attachment) {
                //TODO: delete attachments

                axios.delete(`/attachments/delete/${attachment.id}`).then(({data}) => {
                    let index = this.project.attachments.indexOf(attachment);
                    this.project.attachments.splice(index, 1);
                    console.log(this.project.attachments);
                    Snackbar.open(data.message);

                }).catch((e) => {

                })
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
            axios.get(`projects/${this.$route.params.id}`).then(({data}) => {
                this.project = data.project;

                this.selectedCurrency = this.project.currency;
                this.project.skills = (this.project.skills).split(',');
                this.project.tags = (this.project.tags).split(',');
                this.project.deadline = new Date(this.project.deadline);
            }).catch(() => {
                this.projectNotFound = true;
            });


        },
        computed: {


            subCategories() {
                let subCat = null;

                if (this.project.category != null) {
                    let selectedCategory;
                    if (this.project.category.subcategories) {
                        selectedCategory = this.project.category;
                    } else {
                        selectedCategory = this.categories.find((category) => {
                            if (category.id === this.project.category_id) {
                                return true;
                            }
                        });

                    }
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

</style>

