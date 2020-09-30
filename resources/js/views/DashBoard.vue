<template>

    <div>
        <dash-nav/>

        <div class="jb-main-section-wrapper">
            <div class="container jb-dashboard">
                <div class="row">

                    <div class="col-12 col-md-5 col-lg-3">
                        <div class=" jb-dash-profile bg-orange">

                            <div class="wrapper">

                                <div class="jb-dash-profile-img">
                                    <img class="rounded-circle"
                                         :src="user.profile.picture"/>
                                </div>

                                <div class="details">
                                    <div class="jb-dash-profile-name">
                                        <p class="t-mont t-bold t-white">{{user.name}}</p>
                                    </div>
                                    <div class="jb-dash-profile-credit">
                                        <p class="small-title t-black t-mont">Credit Balance</p>
                                        <p class="t-mont t-bold t-white">₵ 100</p>
                                    </div>


                                </div>

                                <div class="jb-dash-profile-extra">
                                    <router-link :to="{name:'editProfile'}">
                                        <p class="t-mont t-white text-right ">Edit Profile</p>
                                    </router-link>
                                </div>
                            </div>


                        </div>


                        <div class="jb-dash-quick-links">
                            <router-link to="/project/create"
                                         v-if="profileType ==='hire' || profileType ==='work&hire'">
                                <div class="btn bg-black t-white">Post a Project</div>
                            </router-link>

                            <router-link to="/projects" v-if="profileType ==='work' || profileType ==='work&hire'">
                                <div class="btn bg-black t-white">View All Ongoing Projects</div>
                            </router-link>
                        </div>

                        <div class="jb-dash-invite-box bg-ash-light text-center shadow">
                            <p class="invite t-mont t-bold">Invite your friends</p>
                            <p class="earn t-meri t-orange">Earn a reward for each <br>friend you invite</p>
                            <p class="icon t-black">
                                <i class="fa fa-users" id="jb-dash-icon"></i>
                            </p>

                            <p class="copy t-meri">Copy your Reference link to share </p>

                            <a href="#">
                                <div class="btn bg-orange"><i class="fa fa-clipboard"></i> Copy Link
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-12 col-md-7 col-lg-9 mt-5 mt-md-0">

                        <div class="jb-dash-stats-wrapper shadow">
                            <div class="container stats-container">

                                <template v-if="profileType ==='work' || profileType ==='work&hire'">


                                    <div class="stats-item text-center">
                                        <p class="jb-dash-stats-number t-bold t-mont">
                                            <span class="t-normal">₵</span>
                                            50
                                        </p>
                                        <p class="jb-stats-brief">Earned This Month</p>
                                    </div>

                                </template>


                                <template v-if="profileType ==='hire' || profileType ==='work&hire'">

                                    <div class="stats-item text-center">
                                        <p class="jb-dash-stats-number t-bold t-mont">
                                            <span class="t-normal">₵</span>
                                            50
                                        </p>
                                        <p class="jb-stats-brief">Spent</p>
                                    </div>


                                </template>


                                <div class="stats-item text-center">
                                    <p class="jb-dash-stats-number t-bold t-mont">0</p>
                                    <p class="jb-stats-brief">Completed {{'project' | pluralize(0)}}
                                    </p>
                                </div>


                                <div class="stats-item text-center">
                                    <p class="jb-dash-stats-number t-bold t-mont">1</p>
                                    <p class="jb-stats-brief">Pending Projects</p>
                                </div>


                            </div>

                        </div>

                        <dash-notification/>


                        <div v-if="profileType ==='hire' || profileType ==='work&hire'" class="jb-quick-projects">
                            <div class="jb-quick-projects-header">
                                <p class="t-mont t-bold">Recent projects</p>
                            </div>

                            <div class="jb-projects-wrapper my-2">

                                <dash-project v-for="project in somePostedProjects" :key="project.id">
                                    <template slot="title">{{project.title}}</template>
                                    <template slot="time">
                                        <timeago :datetime="project.created_at" :auto-update="60"/>
                                    </template>
                                    <template slot="description">{{project.description.replace(/(.{150})..+/, "$1&hellip;")}}</template>
                                    <template slot="tags">Tags & Skills: IOS, Mobile Applications, Programming
                                    </template>
                                    <template slot="budget"> ₵{{project.budget}}</template>
                                    <template slot="button">
                                        <div class="jb-project-bid-btn text-right">
                                            <a href="" class="btn bg-orange  t-mont"> View</a>
                                        </div>
                                    </template>
                                </dash-project>
                            </div>


                            <div class="text-center">
                                <button class="btn bg-orange">View More</button>
                            </div>


                        </div>
                        <div v-if="profileType ==='work' || profileType ==='work&hire'" class="jb-quick-projects">
                            <div class="jb-quick-projects-header">
                                <p class="t-mont t-bold">Latest projects that match your skills</p>
                            </div>

                            <div class="jb-projects-wrapper my-2">

                                <dash-project v-for="project in someProjects" :key="project.id">
                                    <template slot="title">{{project.title}}</template>
                                    <template slot="time">
                                        <timeago :datetime="project.created_at" :auto-update="60"/>
                                    </template>
                                    <template slot="description">{{project.description.replace(/(.{150})..+/, "$1&hellip;")}}</template>
                                    <template slot="tags">Tags & Skills: IOS, Mobile Applications, Programming
                                    </template>
                                    <template slot="budget"> ₵{{project.budget}}</template>
                                    <template slot="button">
                                        <div class="jb-project-bid-btn text-right">
                                            <a href="" class="btn bg-orange  t-mont">Bid</a>
                                        </div>
                                    </template>
                                </dash-project>
                            </div>


                            <div class="text-center">
                                <button class="btn bg-orange">View More</button>
                            </div>


                        </div>


                    </div>


                </div>

            </div>


        </div>
    </div>
</template>

<script>

    import DashNav from '../components/navbar/DashBoardTop'
    import DashNotification from '../components/notification/DashNotification'
    import DashProject from '../components/extras/DashProject'
    import {mapGetters, mapActions} from 'vuex';


    export default {
        name: "dash-board",

        data() {
            return {
                someProjects: [],
                somePostedProjects: [],
            }
        },
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
                profileType: 'auth/profileType',
            })
        },
        components: {
            DashNav,
            DashNotification,
            DashProject,
        },
        methods: {

            getSomeProjects() {

                switch (this.profileType) {

                    case ('work'):
                        axios.get('/projects')
                            .then(({data}) => {
                                this.someProjects = data.projects.data;
                            }).catch(error => {
                            console.log(error)
                        });

                        break;
                    case ('hire'):
                        axios.get('user/projects')
                            .then(({data}) => {
                                this.somePostedProjects = data.projects;
                            }).catch(error => {
                            console.log(error)
                        });

                        break;
                    case ('work&hire'):
                        axios.get('/projects')
                            .then(({data}) => {
                                this.someProjects = data.projects.data;
                            }).catch(error => {
                            console.log(error)
                        });
                        axios.get( 'user/projects')
                            .then(({data}) => {
                                this.somePostedProjects = data.projects.data;
                            }).catch(error => {
                            console.log(error)
                        });
                        break;
                }


            },

        },
        mounted() {
            this.getSomeProjects();
        },


    }
</script>
