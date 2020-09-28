<template>
    <div class="jb-project shadow">
        <div class="jb-project-content">
            <div class="row">
                <div class="col-md-8">
                    <p class="t-mont t-bold jb-project-title">
                        <slot name="title"></slot>
                        <span class="t-meri font-italic t-normal"><slot name="time"></slot> </span>
                    </p>
                    <p class="t-meri jb-project-description t-orange">
                        <slot name="description"></slot>

                    </p>

                    <div class="jb-project-tags">
                        Tags & Skills: IOS, Mobile Applications, Programming
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="jb-project-price t-meri ">

                        <slot name="budget"></slot>
                    </div>
                    <div class="jb-project-bids t-meri t-orange">
                        15 bids
                    </div>
                </div>
            </div>

        </div>


        <div class="jb-project-footer">

            <div class="row">
                <div class="col-md-8">
                    <div class="jb-project-posted-by">

                        <div class="row">
                            <div class="col-md-1">
                                <div class="jb-project-posted-by-img">
                                    <img src="../../../img/img1.jpg" alt=""
                                         class="rounded-circle">
                                </div>
                            </div>

                            <div class="col-md-11">
                                <div class="jb-project-posted-by-name t-bold">Mr. Alfred Appiah
                                    <span class="t-normal">posted
                                                            this</span>
                                </div>
                                <div class="jb-project-posted-by-extra">
                                    <span><i class="fas fa-check-circle"></i> Verified</span>
                                    <span><i class="fas fa-money-bill-alt"></i> Deposited</span>

                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="col-md-4">
                    <div class="jb-project-bid-btn text-right">
                        <a href="" class="btn bg-orange  t-mont"> Bid</a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</template>

<script>
    export default {}
</script>