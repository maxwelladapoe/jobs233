<template>

    <div>

        <div class="hero is-medium has-background-primary">

            <div class="hero-body">
                <div class="container">

                    <div class="columns is-multiline">
                        <div class="column ">
                            <h1 class="title t-black t-1 t-bold">Browse through our categories.</h1>
                            <p class="subtitle t-white">Get work done in different categories
                            </p>
                            <b-button type="is-black">Get Started</b-button>
                        </div>
                        <div class="column">

                        </div>
                    </div>

                </div>

            </div>


        </div>


        <div class="jb-main-section-wrapper-alt">

            <template v-for="category in categories">

                <div class="section">

                    <div class="container">

                        <p class="title">{{category.name}}</p>

                        <b-taglist>
                            <template v-for="subcategory in category.subcategories">
                                <b-tag>
                                    {{subcategory.name}}
                                </b-tag>

                            </template>
                        </b-taglist>

                    </div>
                </div>

            </template>

        </div>


    </div>

</template>

<script>
    export default {
        name: "Categories",
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Categories',
        },

        data() {
            return {
                categories: []
            }
        },

        beforeCreate() {
            axios.get('projects/categories-skills').then(({data}) => {
                this.categories = data.categories;
            });
        }
    }
</script>

<style scoped>

</style>
