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
                          <span>
                            <router-link
                              :to="{ name: 'AddFunds' }"
                              class="t-normal"
                              >Add Funds</router-link
                            ></span
                          >
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
                      >View All Ongoing Projects
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
                            {{ user.projects_count }}
                          </p>
                          <p class="jb-stats-brief">Projects assigned</p>
                        </div>
                      </div>
                    </div>
                  </template>

                  <template
                    v-if="profileType === 'hire' || profileType === 'work&hire'"
                  >
                    <div
                      class="column is-6-mobile is-3-desktop has-text-centered"
                    >
                      <div class="shadow stats-item stats-item">
                        <div>
                          <p class="jb-dash-stats-number t-bold t-mont">
                            <span class="t-normal">₵</span>
                            50
                          </p>
                          <p class="jb-stats-brief">Spent</p>
                        </div>
                      </div>
                    </div>
                    <div
                      class="column is-6-mobile is-3-desktop has-text-centered"
                    
                    >
                      <div class="shadow stats-item">
                        <div>
                          <p class="jb-dash-stats-number t-bold t-mont">
                            {{ user.projects_count }}
                          </p>
                          <p class="jb-stats-brief">Projects posted</p>
                        </div>
                      </div>
                    </div>
                  </template>

                  <div
                    class="column is-6-mobile is-3-desktop has-text-centered"
                  >
                    <div class="shadow stats-item">
                      <div>
                        <p class="jb-dash-stats-number t-bold t-mont">0</p>
                        <p class="jb-stats-brief">
                          Completed {{ "project" | pluralize(0) }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div
                    class="column is-6-mobile is-3-desktop has-text-centered"
                  >
                    <div class="shadow stats-item">
                      <div>
                        <p class="jb-dash-stats-number t-bold t-mont">0</p>
                        <p class="jb-stats-brief">
                          Completed {{ "project" | pluralize(0) }}
                        </p>
                      </div>
                    </div>
                  </div>
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
                    :key="project.id"
                  >
                    <template slot="title">
                      <router-link
                        :to="{
                          name: 'singleProject',
                          params: { id: project.id },
                        }"
                        class="t-black"
                      >
                        {{ project.title }}
                      </router-link>
                    </template>

                    <template slot="time">
                      <timeago
                        :datetime="project.created_at"
                        :auto-update="60"
                      />
                    </template>
                    <template slot="description">{{
                      truncate(project.description, 200)
                    }}</template>
                    <template slot="tags">
                      <p class="mb-1">Tags & Skills:</p>

                      <h6>
                        <span>
                          <template v-if="project.tags != null">
                            <template v-for="(tag, index ) in project.tags.split(',')">
                              <b-tag class="mr-1" type="is-success" v-bind:key="index">{{
                                tag
                              }}</b-tag>
                            </template>
                          </template>

                          <template v-if="project.skills != null">
                            <template
                              v-for="(skill,index) in project.skills.split(',')"
                            >
                              <b-tag class="mr-1" type="is-success" v-bind:key="index">{{
                                skill
                              }}</b-tag>
                            </template>
                          </template>
                        </span>
                      </h6>
                    </template>

                    <template slot="image">
                      <b-image
                        :rounded="true"
                        :src="project.user.profile.picture"
                        alt=""
                        class="rounded-circle"
                      />
                    </template>

                    <template slot="posted_by">
                      <p
                        class="t-meri m-0 p-0"
                        v-if="authenticated && project.user.id === user.id"
                      >
                        You
                      </p>

                      <p class="t-meri m-0 p-0" v-else>
                        {{ project.user.name }}
                      </p>
                    </template>

                    <template slot="budget">
                      {{ project.currency.symbol }}{{ project.budget }}
                    </template>
                    <template slot="button">
                      <div class="jb-project-bid-button text-right">
                        <router-link
                          :to="{
                            name: 'singleProject',
                            params: { id: project.id },
                          }"
                          class="button bg-orange t-mont"
                        >
                          View
                        </router-link>
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
                    :key="project.id"
                  >
                    <template slot="title">
                      <router-link
                        :to="{
                          name: 'assignedProject',
                          params: { id: project.id },
                        }"
                        class="t-black"
                      >
                        {{ project.title }}
                      </router-link>
                    </template>
                    <template slot="time">
                      <timeago
                        :datetime="project.created_at"
                        :auto-update="60"
                      />
                    </template>
                    <template slot="description">{{
                      truncate(project.description, 200)
                    }}</template>
                    <template slot="tags">
                      <p class="mb-1">Tags & Skills:</p>
                      <b-taglist>
                        <template v-if="project.tags != null">
                          <template
                            v-for="(tag,index) in project.tags.split(',')"
                          >
                            <b-tag class="mr-1" type="is-success" v-bind:key="index">{{
                              tag
                            }}</b-tag>
                          </template>
                        </template>

                        <template v-if="project.skills">
                          <template v-for="(skill,index)  in project.skills.split(',')">
                            <b-tag class="mr-1" type="is-success" v-bind:key="index">{{
                              skill
                            }}</b-tag>
                          </template>
                        </template>
                      </b-taglist>
                    </template>

                    <template slot="image">
                      <b-image
                        :rounded="true"
                        :src="project.user.profile.picture"
                        alt=""
                        class="rounded-circle"
                      />
                    </template>

                    <template slot="budget">
                      {{ project.currency.symbol }}{{ project.budget }}
                    </template>
                    <template slot="button">
                      <div class="jb-project-bid-button text-right">
                        <router-link
                          :to="{
                            name: 'assignedProject',
                            params: { id: project.id },
                          }"
                          class="button bg-orange"
                          >View
                        </router-link>
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
                    :key="project.id"
                  >
                    <template slot="title">
                      <router-link
                        :to="{
                          name: 'singleProject',
                          params: { id: project.id },
                        }"
                        class="t-black"
                      >
                        {{ project.title }}
                      </router-link>
                    </template>
                    <template slot="time">
                      <timeago
                        :datetime="project.created_at"
                        :auto-update="60"
                      />
                    </template>
                    <template slot="description">{{
                      truncate(project.description, 200)
                    }}</template>
                    <template slot="tags">
                      <p class="mb-1">Tags & Skills:</p>
                      <b-taglist>
                        <template v-if="project.tags != null">
                          <template v-for="(tag,index)  in project.tags.split(',')">
                            <b-tag class="mr-1" type="is-success" v-bind:key="index">{{
                              tag
                            }}</b-tag>
                          </template>
                        </template>

                        <template v-if="project.skills != null">
                          <template v-for="(skill,index)  in project.skills.split(',')">
                            <b-tag class="mr-1" type="is-success" v-bind:key="index">{{
                              skill
                            }}</b-tag>
                          </template>
                        </template>
                      </b-taglist>
                    </template>
                    <template slot="budget">
                      {{ project.currency.symbol }}{{ project.budget }}
                    </template>

                    <template slot="image">
                      <b-image
                        :rounded="true"
                        :src="project.user.profile.picture"
                        alt=""
                        class="rounded-circle"
                      />
                    </template>
                    <template slot="button">
                      <div class="jb-project-bid-button text-right">
                        <router-link
                          :to="{
                            name: 'singleProject',
                            params: { id: project.id },
                          }"
                          class="button bg-orange"
                          >Bid
                        </router-link>
                      </div>
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
