<template>

    <div class="jb-project shadow">
        <div class="jb-project-content">
            <div class="row">
                <div class="col-md-8">
                    <p class="t-mont t-bold jb-project-title"><slot name="title"></slot> <span
                                class="t-meri font-italic t-normal"> <slot name="time"></slot></span>
                    </p>
                    <p class="t-meri jb-project-description t-orange">
                       <slot name="description"></slot></p>

                    <div class="jb-project-tags">
                        <slot name="tags"></slot>

                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="jb-project-price t-meri ">


                        <slot name="budget"></slot>
                    </div>
                    <div class="jb-project-bid-btn text-right">
                        <a href="" class="btn bg-orange  t-mont"> Bid</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</template>

<script>


  export default {
  }
</script>
