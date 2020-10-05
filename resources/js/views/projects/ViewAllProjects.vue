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
                    <form method="post" action="">
                        <div class="input-group mb-5">
                            <input type="text" class="form-control" placeholder="Search by Skill, Title, Description"
                                   aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn bg-black" type="button"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <div class="jb-projects-wrapper">

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

                                    <template v-if="profileType ==='hire' || profileType ==='work&hire' || !authenticated" >
                                        <template slot="button">
                                            <div class="jb-project-bid-btn text-right">
                                                <router-link :to="{name:'singleProject' , params:{id:project.id}}"
                                                             class="btn bg-orange  t-mont">View
                                                </router-link>
                                            </div>
                                        </template>
                                    </template>

                                    <template v-if="profileType ==='work' || profileType ==='work&hire'" >
                                        <template slot="button">
                                            <div class="jb-project-bid-btn text-right">
                                                <router-link :to="{name:'singleProject' , params:{id:project.id}}"
                                                             class="btn bg-orange  t-mont">Bid
                                                </router-link>
                                            </div>
                                        </template>
                                    </template>
                                </template>


                            </project-component>


                            <infinite-loading @infinite="infiniteHandler">
                                <template slot="spinner">
                                    <div class="jb-project-loading text-center">
                                        <img src="/images/loading.gif" alt="">
                                    </div>

                                </template>

                                <template slot="no-more">No more Projects</template>
                            </infinite-loading>


                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="jb-project-filter-wrapper">
                            <div class="jb-project-filter p-3 bg-ash-light shadow">
                                <div class="jb-arrow-left">

                                </div>

                                <div class="jb-project-filter-element">
                                    <p class="t-mont t-bold">Categories</p>
                                    <ul class="jb-filter-item">
                                        <li><a href="" class="t-orange t-bold">All Categories</a></li>

                                        <li v-for="category in categories"><a href="" class="t-orange t-bold" >{{category.name}}</a></li>
                                    </ul>
                                </div>
                                <div class="jb-project-filter-element">
                                    <p class="t-mont t-bold">Sort By</p>
                                    <ul class="jb-filter-item">
                                        <li><a href="" class="t-orange t-bold">Latest</a></li>
                                        <li><a href="" class="t-orange t-bold">Popular</a></li>
                                        <li><a href="" class="t-orange t-bold">Featured</a></li>
                                        <li><a href="" class="t-orange t-bold">Budget</a></li>
                                        <li><a href="" class="t-orange t-bold">Skill</a></li>
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

        data: function () {
            return {

                categories: {},
                allProjects: [],
                lastPage: 1,
                numItems: 7,
                currentPage: 0,
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
                    console.log(errors)
                })
            },
            infiniteHandler($state) {

                if (this.currentPage < this.lastPage) {

                    setTimeout(() => {
                        const temp = [];


                        axios.get('/projects?page=' + (this.currentPage + 1)).then(({data}) => {

                            console.log(data);
                            this.lastPage = parseInt(data.projects.last_page);


                            this.numItems = parseInt(data.projects.total);
                            this.currentPage = parseInt(data.projects.current_page);
                            console.log(data.projects);

                            let projects = data.projects.data;
                            console.log(projects);

                            for (let i = 0; i < projects.length; i++) {
                                temp.push(projects[i]);
                            }

                            this.allProjects = this.allProjects.concat(temp);
                            $state.loaded();


                        }).catch(errors => {
                            console.log(errors)
                        })


                    }, 100);
                } else {
                    $state.complete();
                }
            },

        },
        mounted() {

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
        }

    }


</script>
