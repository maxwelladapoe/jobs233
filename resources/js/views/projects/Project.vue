<template>

    <div class="jb-main-section-wrapper">

        <template v-if="!projectNotFound && project">
            <div class="jb-section">
                <div class="container">

                    <div class="row">
                        <div class="col-md-8">


                            <p class="t-bold jb-project-title-big t-mont">{{project.title}}</p>

                            <p class="t-mont jb-project-title-small t-orange">Description</p>
                            <p class="t-meri">{{project.description}}</p>

                            <p class="t-mont jb-project-title-small t-orange">Skills</p>
                            <p> {{project.skills}}</p>

                            <template v-if="project.complexity">
                                <p class="t-mont jb-project-title-small t-orange">Complexity</p>
                                <p>{{project.complexity}}</p>
                            </template>


                            <template v-if="project.tags">
                                <p class="t-mont jb-project-title-small t-orange">Tags</p>
                                <p>{{project.tags}}</p>
                            </template>

                        </div>

                        <div class="col-md-12 col-lg-3 offset-lg-1">
                            <p class="t-mont jb-project-title-small t-orange">Budget</p>
                            <p class="t-meri">{{project.currency.symbol}} {{project.budget}}</p>

                            <p class="t-mont jb-project-title-small t-orange">Created</p>
                            <p class="t-meri">
                                <timeago :datetime="project.created_at" :auto-update="60"/>
                            </p>

                            <p class="t-mont jb-project-title-small t-orange">Created By</p>

                            <p class="t-meri mt-2">

                                <img :src="project.user.profile.picture" width="50" class="mr-2 rounded-circle"/>
                                <span class="mr-auto">{{project.user.name}}</span>

                            </p>

                        </div>
                    </div>


                </div>
            </div>
        </template>


        <template v-if="projectNotFound">
            <div class="jb-section">
                <div class="jb-404 text-center">

                    <div>
                        <p class="error t-mont t-orange">404</p>
                        <p class="t-mont">OOPS! the page you requested for was not found</p>
                    </div>

                </div>
            </div>
        </template>


    </div>

</template>

<script>
    export default {
        name: "projects",

        data() {
            return {
                project: {
                    user: {
                        profile: {}
                    },
                },
                projectNotFound: false,
            }
        },
        beforeCreate() {

            axios.get(`projects/${this.$route.params.id}`).then(({data}) => {
                this.project = data.project;
            }).catch(() => {
                this.projectNotFound = true;
            })
        }
    }
</script>

<style scoped>

</style>
