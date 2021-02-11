<template>

    <div class="jb-project">
        <div class="jb-project-content">
            <div class="columns is-multiline">
                <div class=" column is-12">
                    <div class="jb-project-header">
                        <p class="t-mont t-bold jb-project-title">

                            <router-link :to="{name: 'singleProject',params: { id: project.id }}" class="t-black">
                                {{ project.title }}
                            </router-link>


                            <span
                                class="t-meri font-italic t-normal">  <timeago
                                :datetime="project.created_at"
                                :auto-update="60"
                            />
                            </span>
                        </p>
                        <div class="jb-project-price t-mont t-bold " v-if="project.accepted_bid_id">
                            <b-tag type="is-success" size="is-small">Accepted Offer: {{ project.currency.symbol }}{{
                                project.accepted_bid.amount }}
                            </b-tag>
                        </div>
                        <div class="jb-project-price t-mont t-bold " v-else>
                            <b-tag type="is-success" size="is-small">Budget: {{ project.currency.symbol }}{{
                                project.budget }}
                            </b-tag>
                        </div>
                    </div>


                    <p class="t-meri jb-project-description t-orange">
                        {{
                        truncate(project.description, 200)
                        }}
                    </p>

                    <div class="jb-project-footer-alt">
                        <div class="jb-project-tags">
                            <p class="mb-1">Tags & Skills:</p>

                            <b-taglist>
                        <span>
                          <template v-if="project.tags != null">
                            <template v-for="(tag, index ) in project.tags.split(',')">
                              <b-tag class="mr-1" type="is-success" :key="`A-${index}`">{{
                                tag
                              }}</b-tag>
                            </template>
                          </template>

                          <template v-if="project.skills != null">
                            <template
                                v-for="(skill,index) in project.skills.split(',')"
                            >
                              <b-tag class="mr-1" type="is-success" :key="`B-${index}`">{{
                                skill
                              }}</b-tag>
                            </template>
                          </template>
                        </span>
                            </b-taglist>


                        </div>

                    </div>


                    <div class="jb-project-footer">
                        <div class="jb-project-posted-by">

                            <div class="posted-by-wrap is-vcentered">
                                <div class="jb-project-posted-by-img">
                                    <template v-if="project.user.profile">
                                        <b-image
                                            :rounded="true"
                                            :src="project.user.profile.picture"
                                            alt=""
                                            class="rounded-circle"
                                        />
                                    </template>

                                </div>
                                <div class="jb-project-posted-by-name t-bold">
                                    <p
                                        class="t-meri m-0 p-0"
                                        v-if="authenticated && project.user.id === user.id"
                                    >
                                        You
                                    </p>

                                    <p class="t-meri m-0 p-0" v-else>
                                        {{ project.user.name }}
                                    </p>

                                    <div class="jb-project-posted-by-extra">
<!--                                        <span><b-icon icon="check-circle" size="is-small"/> Verified</span>-->

                                        <span v-if="project.deposit_made"><b-icon icon="cash-plus" size="is-small"/>
                                            Deposited</span>



                                        <span v-if="project.status =='completed'" >
                                            <b-icon icon="circle" size="is-small"/>
                                            Completed
                                        </span>

                                        <span v-else-if="project.accepted_bid_id" class="" style="color: crimson">
                                            <b-icon icon="circle" style="color:crimson;" size="is-small"/>
                                            Bidding closed
                                        </span>


                                    </div>
                                </div>


                            </div>


                        </div>

                        <div>
                            <div class="jb-project-bid-button text-right">
                                <slot name="button">
                                    <router-link
                                        :to="{name: 'singleProject',params: { id: project.id }}">
                                        <b-button type="is-primary" outlined> View</b-button>
                                    </router-link>
                                </slot>

                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>

    </div>


</template>

<script>
    export default {
        props: [
            'project', 'authenticated', 'user'
        ],
        methods: {
            truncate(str, n) {


                return str.length > n ? str.substr(0, n - 1).replace(/(<([^>]+)>)/gi, "").trim() + "..." : str.replace(/(<([^>]+)>)/gi, "").trim();
            },
        }

    }
</script>
