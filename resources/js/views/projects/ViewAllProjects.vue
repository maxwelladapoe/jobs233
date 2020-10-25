<template>
    <div class="jb-main-section-wrapper">

        <div class="jb-section">
            <div class="container">
                <h1 class="t-mont">Start Working Now</h1>
                <p class="text-left t-meri t-normal ">Place your bid on any project to start work</p>
            </div>
        </div>

        <div class="jb-section">
            <div class="container">

                <div class="jb-project-search">
                    <form @submit.prevent="searchSubmit">
                        <div class="input-group mb-5">
                            <input type="text" class="form-control" placeholder="Search by Skill, Title, Description"
                                   aria-label="" aria-describedby="basic-addon2" v-model="search.term">
                            <div class="input-group-append">
                                <button class="btn bg-black" type="submit">
                                    <span><md-search-icon/></span> Search
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="d-lg-none">
                        <div class="row my-3 ">
                            <div class="col-4">
                                <b-form-select v-model="selectedCategory" @change="fetchWithSelectedCategoryDropDown()">
                                    <b-form-select-option value="all">All Categories</b-form-select-option>
                                    <b-form-select-option v-for="category in categories" :key="category.id"
                                                          :value="category.name">
                                        {{category.name}}
                                    </b-form-select-option>
                                </b-form-select>
                            </div>
                            <div class="col-4">
                                <b-form-select v-model="selectedSortOption">
                                    <b-form-select-option value="latest">Latest</b-form-select-option>
                                    <b-form-select-option value="oldest">Oldest</b-form-select-option>

                                </b-form-select>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-8">
                        <div class="jb-projects-wrapper">

                            <template v-if="allProjects.length>0 || allProjects">


                                <project-component v-for="project in allProjects" :key="project.id">
                                    <template slot="title">{{project.title}}</template>
                                    <template slot="time">

                                        <timeago :datetime="project.created_at" :auto-update="60"/>

                                    </template>
                                    <template slot="description">{{truncate(project.description,200)}}</template>
                                    <template slot="tags">

                                        Tags & Skills:
                                        <h6>
                                            <template v-for="tag in project.tags.split(',')">
                                                <b-badge class="mr-1" variant="success">{{tag}}</b-badge>
                                            </template>
                                            <template v-for="skill in project.skills.split(',')">
                                                <b-badge class="mr-1" variant="success">{{skill}}</b-badge>
                                            </template>
                                        </h6>


                                    </template>
                                    <template slot="budget"> {{project.currency.symbol}}{{project.budget}}</template>
                                    <template slot="image">

                                        <img :src="project.user.profile.picture" alt=""
                                             class="rounded-circle">
                                    </template>

                                    <template slot="posted_by">

                                        <p class="t-meri m-0 p-0" v-if=" authenticated && project.user.id === user.id">
                                            You</p>

                                        <p class="t-meri m-0 p-0" v-else>{{project.user.name}}</p>
                                    </template>

                                    <template>

                                        <template
                                            v-if="profileType ==='hire' || profileType ==='work&hire' || !authenticated">
                                            <template slot="button">
                                                <div class="jb-project-bid-btn text-right">
                                                    <router-link :to="{name:'singleProject' , params:{id:project.id}}"
                                                                 class="btn bg-orange">View
                                                    </router-link>
                                                </div>
                                            </template>
                                        </template>

                                        <template v-if="profileType ==='work' || profileType ==='work&hire'">
                                            <template slot="button">
                                                <div class="jb-project-bid-btn text-right">
                                                    <router-link :to="{name:'singleProject' , params:{id:project.id}}"
                                                                 class="btn bg-orange">Bid
                                                    </router-link>
                                                </div>
                                            </template>
                                        </template>
                                    </template>


                                </project-component>


                                <infinite-loading @infinite="infiniteHandler" :identifier="infiniteId">
                                    <template slot="spinner">
                                        <div class="jb-project-loading text-center">
                                            <img src="/images/loading.gif" alt="">
                                        </div>

                                    </template>

                                    <template slot="no-more">No more Projects</template>
                                </infinite-loading>
                            </template>

                            <template v-else>
                                <p class="t-ash">there are no project items</p>
                            </template>

                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="jb-project-filter-wrapper  d-none d-lg-block">
                            <div class="jb-project-filter p-3 text-right">
                                <div class="jb-arrow-left">

                                </div>

                                <div class="jb-project-filter-element ">
                                    <p class="t-mont t-bold">Categories</p>
                                    <ul class="jb-filter-item">
                                        <li><a href="" class="t-orange t-bold">All Categories</a></li>
                                        <li v-for="category in categories">
                                            <a href="" class="t-orange"
                                               @click.prevent="fetchWithSelectedCategory(category.name)">{{category.name}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="jb-project-filter-element">
                                    <p class="t-mont t-bold">Sort By</p>
                                    <ul class="jb-filter-item">
                                        <li><a href="" class="t-orange">Latest</a></li>
                                        <li><a href="" class="t-orange">Oldest</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import ProjectComponent from '../../components/extras/ProjectComponent'
    import InfiniteLoading from 'vue-infinite-loading';
    import {mapGetters} from "vuex";


    export default {
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Projects',
        },
        data() {
            return {

                categories: {},
                allProjects: [],
                lastPage: 1,
                numItems: 7,
                currentPage: 0,
                selectedCategory: 'all',
                selectedSortOption: 'latest',
                owner: '',
                assignedTo: '',
                search: {
                    term: '',
                },
                temp: [],
                infiniteId: +new Date(),

            }
        },
        methods: {

            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n - 1) + '&hellip;' : str;
            },

            getAllPosts() {

                axios.get('/projects').then(response => {

                    this.allProjects = response.data.data;
                    this.lastPage = parseInt(response.data.meta.last_page);
                    this.numItems = parseInt(response.data.meta.total);
                    this.currentPage = parseInt(response.data.meta.current_page);


                }).catch(errors => {

                })
            },

            fetchWithSelectedCategory(category) {
                this.selectedCategory = category;

                this.temp = [];
                this.currentPage = 0;
                this.infiniteId += 1;
                this.allProjects = [];


                // this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');


            },
            fetchWithSelectedCategoryDropDown() {
                this.temp = [];
                this.currentPage = 0;
                this.infiniteId += 1;
                this.allProjects = [];
                // this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
            },
            infiniteHandler($state) {

                if (this.currentPage < this.lastPage) {


                    axios.get(this.api).then(({data}) => {

                        console.log(data);
                        this.lastPage = parseInt(data.projects.last_page);


                        this.numItems = parseInt(data.projects.total);
                        this.currentPage = parseInt(data.projects.current_page);


                        let projects = data.projects.data;


                        for (let i = 0; i < projects.length; i++) {
                            this.temp.push(projects[i]);
                        }

                        this.allProjects = this.allProjects.concat(this.temp);
                        $state.loaded();


                    }).catch(errors => {

                    })


                } else {
                    $state.complete();
                }
            },

            searchSubmit() {
                axios.post('projects/search', this.search).then(({data}) => {
                    this.allProjects = data.projects;
                })
            }

        },

        mounted() {
            if (this.$route.query.owner) {
                this.owner = this.$route.query.owner;
            }
            if (this.$route.query.category) {
                this.selectedCategory = this.$route.query.category;
            }
            if (this.$route.query.assigned_to) {
                console.log(this.$route.query.assigned_to)
                this.assignedTo = this.$route.query.assigned_to;
            }
            if (this.$route.query.page) {
                //doing this inorder use the currentPage variable.
                //in the creating the api link +1 is added to the link
                this.currentPage = parseInt(this.$route.query.page) - 1;
            }
            axios.get('projects/categories').then(({data}) => {
                this.categories = data.categories;
            })
        },
        components: {
            ProjectComponent,
            InfiniteLoading,

        },

        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            }),

            api() {

                let link = `/projects?category=${(this.selectedCategory).toLowerCase().trim()}&`

                if (this.owner) {
                    link += `owner=${(this.owner).toLowerCase().trim() + '&'}`
                }
                if (this.assignedTo) {
                    link += `assigned_to=${(this.assignedTo).toLowerCase().trim() + '&'}`
                }
                if (this.page) {
                    link += `page=${(this.currentPage + 1)}`
                }


                return link;

            }
        }

    }


</script>
