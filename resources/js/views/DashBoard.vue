<template>
  <div>
    <div class="jb-main-section-wrapper">
      <div class="section no-padding-margin-top-bottom">
        <div class="container jb-dashboard">
          <div class="columns is-multiline">
            <div class="column is-4">
              <div class="jb-dash-right">
                <div class="jb-dash-profile bg-orange shadow">
                  <div class="wrapper media">
                    <figure>
                      <div class="jb-dash-profile-img">
                        <b-image
                          :rounded="true"
                          class="rounded-circle"
                          :src="user.profile.picture"
                        />
                      </div>
                    </figure>

                    <div class="media-content details">
                      <div class="jb-dash-profile-name">
                        <p class="t-mont t-bold t-white">{{ user.name }}</p>
                      </div>
                      <div class="jb-dash-profile-credit">


                        <p class="small-title t-black t-mont">Your Balance</p>


                        <p class="t-mont t-bold t-white">
                          ₵ {{ user.wallet.balance }}

                            <template v-if="user.wallet.balance > 0">
                                 <span>
                                    <router-link  v-if="profileType === 'work' || profileType === 'work&hire' "
                                                  :to="{ name: 'WithdrawFunds' }"
                                                  class="t-normal">
                                        Withdraw
                                    </router-link>
                                 </span>

                            </template>
                        </p>



                      </div>
                    </div>

                    <div class="jb-dash-profile-extra">
                      <router-link :to="{ name: 'EditProfile' }">
                        <p class="t-mont t-white text-right">Edit Profile</p>
                      </router-link>
                    </div>
                  </div>
                </div>

                <div class="jb-dash-quick-links has-text-centered">
                  <router-link
                    to="/project/create"
                    v-if="profileType === 'hire' || profileType === 'work&hire'"
                  >
                    <b-button expanded class="button bg-black t-white"
                      >Post a Project</b-button
                    >
                  </router-link>

                  <router-link
                    to="/projects"
                    v-if="profileType === 'work' || profileType === 'work&hire'"
                  >
                    <b-button class="button is-black t-white" expanded
                      >View All Projects
                    </b-button>
                  </router-link>
                </div>

                <div class="jb-dash-invite-box bg-ash-light has-text-centered">
                  <p class="invite t-mont t-bold">Invite your friends</p>
                  <p class="earn t-meri t-orange">
                    Earn a reward for each <br />friend you invite
                  </p>
                  <p class="icon t-black">
                    <i class="fa fa-users" id="jb-dash-icon"></i>
                  </p>

                  <p class="copy t-meri">Copy your Reference link to share</p>

                  <a href="#">
                    <div class="button bg-orange">
                      <i class="fa fa-clipboard"></i> Copy Link
                    </div>
                  </a>
                </div>
              </div>
            </div>

            <div class="column is-8">
              <div class="jb-dash-stats-wrapper">
                <div class="columns is-multiline is-mobile stats-container">
                  <template
                    v-if="profileType === 'work' || profileType === 'work&hire'"
                  >
                    <div
                      class="column is-6-mobile is-3-desktop has-text-centered"
                    >
                      <div class="shadow stats-item">
                        <div>
                          <p class="jb-dash-stats-number t-bold t-mont">
                            <span class="t-normal">₵</span>
                            {{ user.wallet.balance }}
                          </p>
                          <p class="jb-stats-brief">Earned This Month</p>
                        </div>
                      </div>
                    </div>

                    <div
                      class="column is-6-mobile is-3-desktop has-text-centered"

                    >
                      <div class="shadow stats-item">
                        <div>
                          <p class="jb-dash-stats-number t-bold t-mont">
                            {{ user.assigned_projects_count}}
                          </p>
                          <p class="jb-stats-brief">Assigned {{ 'Project' | pluralize(user.assigned_projects_count) }}</p>
                        </div>
                      </div>
                    </div>

                      <div
                          class="column is-6-mobile is-6-desktop has-text-centered"
                      >
                          <div class="shadow stats-item">
                              <div>
                                  <p class="jb-dash-stats-number t-bold t-mont">{{user.completed_assigned_projects_count}}</p>
                                  <p class="jb-stats-brief">
                                      Completed {{ "project" | pluralize(user.completed_assigned_projects_count) }}
                                  </p>
                              </div>
                          </div>
                      </div>
                  </template>

                  <template v-if="profileType === 'hire' || profileType === 'work&hire'">
<!--                    <div-->
<!--                      class="column is-6-mobile is-3-desktop has-text-centered"-->
<!--                    >-->
<!--                      <div class="shadow stats-item stats-item">-->
<!--                        <div>-->
<!--                          <p class="jb-dash-stats-number t-bold t-mont">-->
<!--                            <span class="t-normal">₵</span>-->
<!--                            50-->
<!--                          </p>-->
<!--                          <p class="jb-stats-brief">Spent</p>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                    </div>-->
                    <div
                      class="column is-6-mobile is-6-desktop has-text-centered"

                    >
                      <div class="shadow stats-item">
                        <div>
                          <p class="jb-dash-stats-number t-bold t-mont">
                            {{ user.projects_count }}
                          </p>
                          <p class="jb-stats-brief">Posted {{ 'project' | pluralize(user.projects_count) }}</p>
                        </div>
                      </div>
                    </div>

                      <div
                          class="column is-6-mobile is-6-desktop has-text-centered"
                      >
                          <div class="shadow stats-item">
                              <div>
                                  <p class="jb-dash-stats-number t-bold t-mont">{{user.completed_projects_count}}</p>
                                  <p class="jb-stats-brief">
                                      Completed {{ "project" | pluralize(user.completed_projects_count) }}
                                  </p>
                              </div>
                          </div>
                      </div>
                  </template>


                </div>
              </div>

              <dash-notification />
            </div>
          </div>

          <div class="columns">
            <div class="column is-12 mt-5 mt-md-0">
              <!-- Is employer -->
              <div
                v-if="profileType === 'hire' || profileType === 'work&hire'"
                class="jb-quick-projects"
              >
                <div class="jb-quick-projects-header">
                  <p class="t-mont t-bold">Recent projects</p>
                </div>

                <div class="jb-projects-wrapper mb-5 my-2">
                  <project-component
                    v-for="project in somePostedProjects"
                    :key="project.id" :project="project" :authenticated="authenticated" :user="user"
                  >

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

                  </project-component>
                </div>

                <div
                  class="has-text-centered"
                  v-if="somePostedProjectsCount > somePostedProjects.length"
                >
                  <router-link
                    :to="{ name: 'Projects', params: { owner: 'me' } }"
                    class="button bg-orange"
                  >
                    View All
                  </router-link>
                </div>
              </div>

              <!-- End is employer -->

              <!--Assigned projects and is worker -->
              <div
                v-if="
                  assignedProjects.length > 0 &&
                  (profileType === 'work' || profileType === 'work&hire')
                "
                class="jb-quick-projects"
              >
                <div class="jb-quick-projects-header">
                  <p class="t-mont t-bold">Assigned Projects</p>
                </div>

                <div class="jb-projects-wrapper my-2">
                  <project-component
                    v-for="project in assignedProjects"
                    :key="project.id" :project="project" :authenticated="authenticated"  :user="user"
                  >
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
                  </project-component>
                </div>

                <div class="has-text-centered" v-if="someProjects.length > 0">
                  <router-link
                    :to="{ name: 'Projects' }"
                    class="button bg-orange"
                    >View All</router-link
                  >
                </div>
              </div>
              <!-- End Assigned projects and is worker -->

              <!--No assigned projects and is worker -->
              <div
                v-if="
                  assignedProjects.length < 1 &&
                  (profileType === 'work' || profileType === 'work&hire')
                "
                class="jb-quick-projects"
              >
                <div class="jb-quick-projects-header">
                  <p class="t-mont t-bold">
                    Latest projects that match your skills
                  </p>
                </div>

                <div class="jb-projects-wrapper my-2">
                  <project-component
                    v-for="project in someProjects"
                    :key="project.id" :project="project" :authenticated="authenticated"  :user="user"
                  >
                    <template slot="button">
                        <router-link
                          :to="{
                            name: 'singleProject',
                            params: { id: project.id },
                          }"
                          class="button bg-orange"
                          >Bid
                        </router-link>
                    </template>
                  </project-component>
                </div>

                <div class="has-text-centered" v-if="someProjects.length > 0">
                  <router-link
                    :to="{ name: 'Projects' }"
                    class="button bg-orange"
                    >View More
                  </router-link>
                </div>
              </div>
              <!-- End No assigned projects and is worker -->
            </div>
            <div class="column is-12 col-lg-4"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DashNotification from "../components/notification/DashNotification";
import ProjectComponent from "../components/extras/ProjectComponent";
import { mapGetters, mapActions } from "vuex";

export default {
  name: "dash-board",
  metaInfo: {
    // if no subcomponents specify a metaInfo.title, this title will be used
    title: "Dashboard",
  },
  data() {
    return {
      someProjects: [],
      assignedProjects: [],
        assignedProjectsCount :0,
      somePostedProjects: [],
      somePostedProjectsCount: 0,
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
      profileType: "auth/profileType",
    }),
  },
  components: {
    DashNotification,
    ProjectComponent,
  },
  methods: {
    truncate(str, n) {
      return str.length > n ? str.substr(0, n - 1) + "&hellip;" : str;
    },

    getSomeProjects() {
      switch (this.profileType) {
        case "work":
          axios
            .get("/projects")
            .then(({ data }) => {
              this.someProjects = data.projects.data;
            })
            .catch((error) => {
              console.log(error);
            });
          axios
            .get("/projects/assigned")
            .then(({ data }) => {
              this.assignedProjects = data.projects.data;
              this.assignedProjectsCount =  data.projects.total;
            })
            .catch((error) => {
              console.log(error);
            });

          break;
        case "hire":
          axios
            .get("user/projects/?paginate=5")
            .then(({ data }) => {
              this.somePostedProjects = data.projects.data;
              this.somePostedProjectsCount = data.projects.total;
            })
            .catch((error) => {
              console.log(error);
            });

          break;
        case "work&hire":
          axios
            .get("/projects")
            .then(({ data }) => {
              this.someProjects = data.projects.data;
            })
            .catch((error) => {
              console.log(error);
            });

          axios
            .get("user/projects/?paginate=5")
            .then(({ data }) => {
              this.somePostedProjects = data.projects.data;

              this.somePostedProjectsCount = data.projects.total;
            })
            .catch((error) => {
              console.log(error);
            });
          break;
      }
    },
  },
  mounted() {
    this.getSomeProjects();
  },
};
</script>
