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
                                    <timeago :since="project.created_at.date" :auto-update="60"/>
                                </template>
                                <template slot="description">{{project.details}}</template>
                                <template slot="tags">Tags & Skills: IOS, Mobile Applications, Programming
                                </template>
                                <template slot="budget"> ₵{{project.price}}</template>

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
                                        <li><a href="" class="t-orange t-bold">IT & Programming</a></li>
                                        <li><a href="" class="t-orange t-bold">Graphic Design & Branding</a></li>
                                        <li><a href="" class="t-orange t-bold">Website Development</a></li>
                                        <li><a href="" class="t-orange t-bold">Photography</a></li>
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


    export default {

        data: function () {
            return {
                allProjects: [],
                lastPage: 1,
                numItems: 7,
                currentPage: 0,
            }
        },
        methods: {
            getAllPosts() {

                let vm = this;
                axios.get('/projects').then(response => {

                    vm.allProjects = response.data.data;
                    vm.lastPage = parseInt(response.data.meta.last_page);
                    vm.numItems = parseInt(response.data.meta.total);
                    vm.currentPage = parseInt(response.data.meta.current_page);


                }).catch(errors => {
                    console.log(errors)
                })
            },
            infiniteHandler($state) {

                let vm = this;
                console.log("loading");
                if (this.currentPage < this.lastPage) {

                    setTimeout(() => {
                        const temp = [];


                        axios.get('/projects?page=' + (vm.currentPage + 1)).then(response => {

                            let data = response.data.data;
                            vm.lastPage = parseInt(response.data.meta.last_page);
                            vm.numItems = parseInt(response.data.meta.total);
                            vm.currentPage = parseInt(response.data.meta.current_page);

                            for (let i = 0; i < data.length; i++) {
                                temp.push(data[i]);
                            }
                            this.allProjects = this.allProjects.concat(temp);
                            $state.loaded();


                        }).catch(errors => {
                            console.log(errors)
                        })


                    }, 1000);
                } else {
                    $state.complete();
                }
            },

        },
        mounted() {
            // this.getAllPosts();
        },
        components: {
            ProjectComponent,
            InfiniteLoading,

        }

    }


</script>
