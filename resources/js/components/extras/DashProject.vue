<template>

    <div class="jb-project shadow">
        <div class="jb-project-content">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="jb-project-header">
                        <p class="t-mont t-bold jb-project-title">
                            <slot name="title"></slot>
                            <span
                                class="t-meri font-italic t-normal"> <slot name="time"></slot></span>
                        </p>
                        <div class="jb-project-price t-meri ">
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

                        <slot name="button"></slot>

                    </div>

                </div>
                <div class="col-12 col-md-4 text-right d-flex justify-content-between align-content-center">


                </div>
            </div>

        </div>

    </div>

</template>

<script>


    export default {}
</script>
