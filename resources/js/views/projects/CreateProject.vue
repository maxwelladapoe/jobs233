<template>

    <div class="jb-main-section-wrapper" v-if="authenticated">

        <div class="jb-section">
            <div class="section no-padding-margin-top-bottom">
                <div class="container">
                    <h1 class="t-mont title">Create a project</h1>
                    <p class="text-left t-meri t-normal subtitle">Don't waste any more time. Post your project for free
                        <br>
                        and start getting responses in minutes</p>
                </div>
            </div>

        </div>

        <div class="jb-section-small-special bg-ash-light">
            <div class="section no-padding-margin-top-bottom">
                <div class="container">


                    <div class="columns">
                        <div class="col-md-8">
                            <div class="jb-step-wrapper ">

                                <div class="jb-step">
                                    <p>
                                        <span class="jb-step-circle">1</span> Description
                                        <b-icon icon="chevron-right" size="is-small"/>
                                    </p>
                                </div>
                                <div class="jb-step">
                                    <p>
                                        <span class="jb-step-circle">2</span> Extra Requirements
                                        <b-icon icon="chevron-right" size="is-small"/>
                                    </p>
                                </div>
                                <div class="jb-step">
                                    <p>
                                        <span class="jb-step-circle">3</span> Publish

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
        </div>

        <div class="jb-section">
            <div class="section no-padding-margin-top-bottom">


                <div class="container">


                    <div class="columns is-desktop">
                        <div class="column is-12 is-8-desktop">
                            <div class="jb-project-form p-3">

                                <ValidationObserver v-slot="{handleSubmit}" ref="submitProject">
                                    <form @submit.prevent="handleSubmit(submitProject)">


                                        <ValidationObserver :key="1" v-if="step ===1">
                                            <ValidationProvider
                                                persist
                                                mode="lazy"
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
                                                             placeholder="Project title here"
                                                             v-model="project.title"
                                                             aria-describedby="title-live-feedback">

                                                    </b-input>

                                                </b-field>

                                            </ValidationProvider>

                                            <b-field grouped>


                                                <ValidationProvider
                                                    persist
                                                    mode="lazy"
                                                    name="category"
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
                                                                  v-model="project.category" expanded>
                                                            <option
                                                                v-for="category  in categories"
                                                                :key="category.id"
                                                                :value="category">{{ category.name }}
                                                            </option>

                                                        </b-select>

                                                    </b-field>


                                                </ValidationProvider>

                                                <ValidationProvider
                                                    persist
                                                    mode="lazy"
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
                                                        <b-select v-model="project.subcategory"
                                                                  placeholder="Select a subcategory"
                                                                  expanded
                                                                  :disabled="subCategories == null">

                                                            <option
                                                                v-for="subCategory  in subCategories"
                                                                :key="subCategory.id"
                                                                :value="subCategory">{{ subCategory.name }}
                                                            </option>

                                                        </b-select>

                                                    </b-field>


                                                </ValidationProvider>

                                            </b-field>
                                            <ValidationProvider
                                                persist
                                                mode="lazy"
                                                name="description"
                                                :rules="{ required: true, min: 3, }"
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


                                                    <quill-editor
                                                        class="textarea editor p-0"
                                                        ref="myTextEditor"
                                                        :content="project.description"
                                                        v-model="project.description"
                                                        :options="editorOption"
                                                        @change="onEditorChange($event)"
                                                    />


                                                </b-field>
                                            </ValidationProvider>


                                            <b-field

                                                label="Budget"
                                                label-class="t-mont t-bold"
                                                label-for="budget"
                                                expanded grouped
                                            >


                                                <!--                                                <ValidationProvider-->
                                                <!--                                                    :rules="{ required: true, integer:false}"-->
                                                <!--                                                    name="currency"-->
                                                <!--                                                    v-slot="{ errors, valid }" slim-->
                                                <!--                                                >-->

                                                <!--                                                    <b-field-->
                                                <!--                                                        :message="errors"-->
                                                <!--                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"-->
                                                <!--                                                    >-->
                                                <!--                                                        <b-select-->
                                                <!--                                                            placeholder="  Select a-->
                                                <!--                                                                            currency"-->
                                                <!--                                                            name="currency"-->
                                                <!--                                                            v-model="project.currency">-->

                                                <!--                                                            <option v-for="currency in currencies"-->
                                                <!--                                                                    :key="currency.id"-->
                                                <!--                                                                    :value="currency.id">-->
                                                <!--                                                                {{currency.name}}-->
                                                <!--                                                            </option>-->

                                                <!--                                                        </b-select>-->
                                                <!--                                                    </b-field>-->

                                                <!--                                                </ValidationProvider>-->


                                                <ValidationProvider
                                                    mode="lazy"
                                                    :rules="{ required: true, integer:true, min:1}"
                                                    name="budget"
                                                    v-slot="{ errors, valid }" slim
                                                >
                                                    <b-field
                                                        :message="errors"
                                                        :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                        expanded
                                                    >

                                                        <p class="control">
                                                            <span class="button is-static">{{
                                                                    user.profile
                                                                        .currency.name
                                                                }} </span>
                                                        </p>
                                                        <b-input id="budget" type="number" min="1"
                                                                 placeholder="120"
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
                                                mode="lazy"
                                                :rules="{ required: false,}"
                                                name="skills" slim
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
                                                        maxtags="5"
                                                        field="name"
                                                        @typing="getFilteredSkills"
                                                        placeholder="Add preferred skills"
                                                        v-model="project.skills"

                                                        aria-describedby="title-live-feedback">
                                                        <template slot-scope="props">
                                                            {{ props.option.name }}
                                                        </template>
                                                        <template slot="empty">
                                                            There are no skills
                                                        </template>
                                                    </b-taginput>

                                                </b-field>


                                            </ValidationProvider>
                                            <ValidationProvider
                                                mode="lazy"
                                                :rules="{ required: false,}"
                                                v-slot="{ errors, valid }"
                                                name="Tags" slim
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
                                                mode="lazy"
                                                :rules="{ required: false,}"
                                                v-slot="{ errors, valid }"
                                                name="extra requirements" slim
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
                                                mode="lazy"
                                                :rules="{ required: true}"
                                                name="deadline"
                                                v-slot="{ errors, valid }" slim
                                            >
                                                <b-field
                                                    id="deadline"
                                                    label="Deadline"
                                                    label-class="t-mont t-bold"
                                                    label-for="deadline"
                                                    :message="errors"
                                                    :type="{ 'is-danger': errors[0], 'is-success': valid }"
                                                >
                                                    <b-datepicker
                                                        input-id="deadline"
                                                        name="deadline"
                                                        :min-date="minDate"
                                                        icon="calendar-today"
                                                        placeholder=" Select deadline"
                                                        v-model="project.deadline"
                                                        aria-describedby="deadline-live-feedback">

                                                    </b-datepicker>

                                                </b-field>
                                            </ValidationProvider>

                                            <attach-files v-model="uploadedFileList" class="mb-3"></attach-files>


                                        </ValidationObserver>


                                        <div :key="4" v-if="step===3">
                                            <p class="t-mont t-bold t-orange">Title</p>
                                            <p class="mb-3">{{ project.title }}</p>

                                            <p class="t-mont t-bold t-orange"> Description</p>
                                            <div class="mb-3 content" v-html="project.description"></div>

                                            <p class="t-mont t-bold t-orange"> Category</p>
                                            <p class="mb-3"><span class="t-bold">{{ project.category.name }}</span> >
                                                {{ project.subcategory.name }} </p>

                                            <p class="t-mont t-bold t-orange"> Budget</p>

                                            <p class="mb-3">{{
                                                    user.profile
                                                        .currency.name
                                                }} {{ project.budget }}</p>

                                            <p class="t-mont t-bold t-orange" v-if="project.additional_details"> Extra
                                                Requirements</p>
                                            <p class="mb-3">{{ project.additional_details }}</p>

                                            <p class="t-mont t-bold t-orange" v-if="project.skills.length>0"> Skills</p>
                                            <b-taglist class="mb-3">
                                                <template v-for="(skill,index) in project.skills">
                                                    <b-tag class="mr-1" type="is-success" v-bind:key="index">
                                                        {{ skill.name }}
                                                    </b-tag>
                                                </template>
                                            </b-taglist>


                                            <p class="t-mont t-bold t-orange" v-if="project.tags.length>0"> Tags</p>


                                            <b-taglist>
                                                <template v-for="(tag,index) in project.tags">
                                                    <b-tag class="mr-1" type="is-success" v-bind:key="index">{{ tag }}
                                                    </b-tag>
                                                </template>
                                            </b-taglist>


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
                                                Create Project
                                            </span>
                                                    <span v-else>
                                                  Next
                                            </span>
                                                </button>

                                            </div>

                                            <div v-if="isSuccessful && createdProject.id" class="text-right">
                                                <span class="text-success"><b-icon icon="check-circle"/> Your Project was Posted Successfully</span>

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
                                        </b-field>
                                    </form>

                                </ValidationObserver>


                            </div>

                        </div>
                        <div class="column is-12 is-4-desktop">


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
import {quillEditor} from "vue-quill-editor";


export default {

    metaInfo: {
        // if no subcomponents specify a metaInfo.title, this title will be used
        title: 'Create Project',
    },

    data() {
        const today = new Date();

        return {


            editorOption: {
                theme: 'bubble',
                placeholder: "Describe what you want done. eg. Logo design for ...",
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{'list': 'ordered'}, {'list': 'bullet'}],
                        [{'header': 2}, {'header': 3}],
                        ['link']
                    ]
                }
            },
            content: '',


            categories: [],
            skillsList: [],
            skillsListFiltered: [],
            uploadedFileList: [],
            isLoading: false,
            isSuccessful: false,

            minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1),


            dropAreaDragOver: false,
            dropAreaDragLeave: false,
            createdProject: null,

            project: {
                title: '',
                description: '',
                category: null,
                budget: '',
                currency: null,
                subcategory: null,
                additional_details: '',
                skills: [],
                tags: [],
                deadline: new Date(),
            },
            currencies: [],

            titleLength: 0,
            step: 1,
            totalSteps: 3,


        }
    },
    mounted() {
        this.project.currency = this.user.profile.currency.id;
    },
    methods: {
        onEditorChange({html, text}) {
            this.project.description = html;
        },

        getFilteredSkills(text) {
            this.skillsListFiltered = this.skillsList.filter((option) => {
                return option.name
                    .toString()
                    .toLowerCase()
                    .indexOf(text.toLowerCase()) >= 0
            })
        },
        viewPostedProject() {
            if (this.createdProject.id) {
                this.$router.push({name: 'singleProject', params: {id: this.createdProject.id}});

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
            this.isLoading=false;
            this.isSuccessful = false;
            this.project = {
                title: '',
                description: '',
                category: null,
                budget: '',
                currency: this.user.profile.currency.id,
                subcategory: null,
                additional_details: '',
                skills: '',
                tags: [],
                deadline: new Date(),
            }
            this.step = 1;
            this.$refs.submitProject.reset();
            //reset the errors
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
        submitProject() {


            if (this.step < this.totalSteps) {
                this.step++
            } else {
                this.project.currency = this.user.profile.currency.id;

                let formData = new FormData();


                for (let i = 0; i < this.uploadedFileList.length; i++) {
                    formData.append('attachments[' + i + ']', this.uploadedFileList[i]);
                }

                for (let key in this.project) {

                    //some filtering is going on here to reduce the request size
                    if (key === 'category' || key === 'subcategory') {
                        formData.append(key, this.project[key].id)
                    } else if (key === 'skills') {

                        let skillArray = []
                        for (let i = 0; i < this.project[key].length; i++) {
                            skillArray.push(this.project[key][i].name)
                        }

                        formData.append(key, skillArray.toString())

                    } else if (key === 'deadline') {
                        formData.append(key, this.formatDate(new Date(this.project[key])))
                    } else {
                        formData.append(key, this.project[key]);

                    }
                }

                // data.append(...this.project);
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },

                    onUploadProgress: (progressEvent) => {
                        let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                        // console.log(percentCompleted)
                    }
                };


                this.isLoading = true;

                if (this.createdProject === null) {
                    axios.post('projects', formData, config)

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
            let subCat = [];

            if (this.project.category != null) {
                let selectedCategory = this.project.category;
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
    watch: {},
    components: {AttachFiles, quillEditor}
}
</script>


<style lang="scss">

</style>

