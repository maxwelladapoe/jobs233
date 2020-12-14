<template>
    <div class="jb-main-section-wrapper">

        <div class="jb-section">
            <div class="section no-padding-margin-top-bottom">
                <div class="container">

                    <div class=" is-small">
                        <template v-if="owner">
                            <p class="t-bold t-mont title">My Projects</p>
                            <p class="text-left t-meri t-normal subtitle ">Review your projects</p>
                        </template>
                        <template v-else>
                            <p class="t-bold t-4 t-mont">Start Working Now</p>
                            <p class="text-left t-meri t-normal ">Place your bid on any project to start work</p>
                        </template>
                    </div>

                </div>
            </div>

        </div>

        <div class="jb-section">
            <div class="section no-padding-margin-top-bottom">
                <div class="container">


                    <div class="jb-project-search">
                        <form class=" mb-5">
                            <b-field expanded>
                                <b-input placeholder="Search..." type="search" expanded v-model="search.term"></b-input>
                                <p class="control">
                                    <b-button @click.prevent="searchSubmit" class="button is-black">
                                        <b-icon icon="magnify"/>
                                        <span>Search</span></b-button>
                                </p>
                            </b-field>

                        </form>

                        <div class="is-hidden-desktop">
                            <div class="columns my-3 ">
                                <div class="column is-6">
                                    <b-select expanded v-model="selectedCategory"
                                              @change="fetchWithSelectedCategoryDropDown()">
                                        <option value="all">All Categories</option>
                                        <option v-for="category in categories" :key="category.id"
                                                :value="category.name">
                                            {{category.name}}
                                        </option>
                                    </b-select>
                                </div>
                                <div class="column is-6">
                                    <b-select v-model="selectedSortOption" expanded>
                                        <option value="latest">Latest</option>
                                        <option value="oldest">Oldest</option>
                                        \
                                    </b-select>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="columns is-multiline">
                        <div class="column is-12 is-8-desktop">
                            <div class="jb-projects-wrapper">

                                <template v-if="allProjects.length>0 || allProjects">

                                    <project-component v-for="project in allProjects" :key="project.id">
                                        <template slot="title">{{project.title}}</template>
                                        <template slot="time">

                                            <timeago :datetime="project.created_at" :auto-update="60"/>

                                        </template>
                                        <template slot="description">{{truncate(project.description,200)}}</template>
                                        <template slot="tags">

                                            <p class="mb-1">Tags & Skills:</p>
                                            <b-taglist>

<template v-if="project.tags !=null">
                                                <template v-for="(tag,index) in project.tags.split(',')">
                                                    <b-tag class="mr-1" type="is-success" v-bind:key="index">{{tag}}</b-tag>
                                                </template>
</template>

<template v-if="project.skills !=null">
                                                <template v-for="(skill,index) in project.skills.split(',')">
                                                    <b-tag class="mr-1" type="is-success" v-bind:key="index">{{skill}}</b-tag>
                                                </template>

</template>
                                            </b-taglist>


                                        </template>
                                        <template slot="budget"> {{project.currency.symbol}}{{project.budget}}
                                        </template>
                                        <template slot="image">

                                            <b-image :rounded='true' :src="project.user.profile.picture" alt=""
                                                     class="rounded-circle"/>
                                        </template>

                                        <template slot="posted_by">

                                            <p class="t-meri m-0 p-0"
                                               v-if=" authenticated && project.user.id === user.id">
                                                You</p>

                                            <p class="t-meri m-0 p-0" v-else>{{project.user.name}}</p>
                                        </template>

                                        <template>

                                            <template
                                                v-if=" !authenticated">
                                                <template slot="button">
                                                    <div class="jb-project-bid-btn text-right">


                                                        <router-link
                                                            :to="{name:'singleProject' , params:{id:project.id}}"
                                                            class="button bg-orange">View
                                                        </router-link>


                                                    </div>
                                                </template>
                                            </template>


                                            <template
                                                v-if="(profileType ==='hire' || profileType ==='work&hire' ) && authenticated">
                                                <template slot="button">
                                                    <div class="jb-project-bid-btn text-right">


                                                        <template
                                                            v-if="(project.accepted_bid_id !== null
                                                             && project.accepted_bid_id !== 0 &&
                                                              project.accepted_bid_id !=='') &&
                                                              (project.user.id === user.id || project.worker_id
                                                              ===user.id)">
                                                            <router-link
                                                                :to="{name:'assignedProject' , params:{id:project.id}}"
                                                                class="button bg-orange">View
                                                            </router-link>
                                                        </template>

                                                        <template v-else>
                                                            <router-link
                                                                :to="{name:'singleProject' , params:{id:project.id}}"
                                                                class="button bg-orange">View
                                                            </router-link>
                                                        </template>


                                                    </div>
                                                </template>
                                            </template>


                                            <template
                                                v-if="(profileType ==='work' || profileType ==='work&hire')  && authenticated">


                                                <template slot="button">


                                                    <template
                                                        v-if="(project.accepted_bid_id !== null
                                                             && project.accepted_bid_id !== 0 &&
                                                              project.accepted_bid_id !=='') &&
                                                              ( project.worker_id===user.id)">
                                                        <router-link
                                                            :to="{name:'assignedProject' , params:{id:project.id}}"
                                                            class="button bg-orange">View
                                                        </router-link>
                                                    </template>

                                                    <template v-else>
                                                        <div class="jb-project-bid-btn text-right">
                                                            <router-link
                                                                :to="{name:'singleProject' , params:{id:project.id}}"
                                                                class="button bg-orange">Bid
                                                            </router-link>
                                                        </div>
                                                    </template>

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
                        <div class="column is-4  is-hidden-touch">
                            <div class="jb-project-filter-wrapper  d-none d-lg-block">
                                <div class="jb-project-filter p-3 has-text-right">
                                    <div class="jb-arrow-left">

                                    </div>

                                    <div class="jb-project-filter-element ">
                                        <p class="t-mont t-bold">Categories</p>
                                        <ul class="jb-filter-item">
                                            <li><a href="" @click.prevent="fetchWithSelectedCategory('all')"
                                                   class="t-orange">All Categories</a></li>
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

                let link = `/projects?category=${(this.selectedCategory).toLowerCase().trim()}`

                if (this.owner) {
                    link += '&' + `owner=${(this.owner).toLowerCase().trim()}`
                }
                if (this.assignedTo) {
                    link += '&' + `assigned_to=${(this.assignedTo).toLowerCase().trim() + '&'}`
                }
                if (this.page) {
                    link += '&' + `page=${(this.currentPage + 1)}`
                }


                return link;

            }
        }

    }


</script>
