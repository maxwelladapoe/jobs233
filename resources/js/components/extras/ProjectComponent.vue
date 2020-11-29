<template>

    <div class="jb-project">
        <div class="jb-project-content">
            <div class="columns is-multiline">
                <div class=" column is-12">
                    <div class="jb-project-header">
                        <p class="t-mont t-bold jb-project-title">
                            <slot name="title"></slot>
                            <span
                                class="t-meri font-italic t-normal"> <slot name="time"></slot></span>
                        </p>
                        <div class="jb-project-price t-mont t-bold ">
                            <slot name="budget"></slot>
                        </div>
                    </div>


                    <p class="t-meri jb-project-description t-orange">
                        <slot name="description"></slot>
                    </p>

                    <div class="jb-project-footer-alt">
                        <div class="jb-project-tags">
                            <slot name="tags"></slot>
                        </div>

                    </div>


                    <div class="jb-project-footer">
                        <div class="jb-project-posted-by">

                            <div class="posted-by-wrap is-vcentered">
                                <div class="jb-project-posted-by-img">
                                    <slot name="image"></slot>
                                </div>
                                <div class="jb-project-posted-by-name t-bold">
                                    <slot name="posted_by"></slot>

                                    <div class="jb-project-posted-by-extra">
                                        <span><b-icon icon="check-circle" size="is-small"/> Verified</span>
                                        <span><b-icon icon="cash-plus" size="is-small" />  Deposited</span>

                                    </div>
                                </div>


                            </div>


                        </div>

                        <div>
                            <slot name="button"></slot>
                        </div>
                    </div>


                </div>
            </div>

        </div>

    </div>


</template>

<script>
    export default {}
</script>
