<template>
    <footer class="jb-footer has-background-pattern-white">

        <div class="section">
            <div class="container">
                <div class="columns">
                    <div class="column is-4">
                        <p class="jb-footer-essay t-meri"> Hire the right people, get work done, on time and
                            within your
                            budget. Expert freelances are just a click away</p>
                    </div>
                    <div class="column is-3  is-offset-2">
                        <p class="jb-footer-header  t-bold ">LINKS</p>
                        <ul class="footer-align">
                            <li class="footer-item">
                                <router-link to="/projects" class="footer-link">Projects</router-link>
                            </li>
                            <li class="footer-item">
                                <router-link class="footer-link" to="/signup">Sign Up</router-link>
                            </li>
                            <li class="footer-item"><router-link class="footer-link " to="/login">Login</router-link></li>
                        </ul>
                    </div>
                    <div class="column is-3">
                        <p class="jb-footer-header  t-bold ">ASSIST</p>
                        <ul class="footer-align">
                            <li class="footer-item"><router-link class="footer-link" :to="{name:'HowItWorks'}">How it
                                works</router-link></li>
                            <li class="footer-item"><router-link class="footer-link"
                                                                 :to="{name:'HowItWorks',params:{type:'faq'}}">FAQ
                            </router-link></li>
                            <li class="footer-item">
                                <router-link class="footer-link" :to="{name:'Contact'}">Contact us</router-link>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="container mt-3">
                <div class="columns">
                    <div class="column is-6">
                        <ul class="footer-align">
                            <li class="footer-item">
                                <router-link class="footer-link " :to="{name:'About'}">Learn more about Jobs 233
                                </router-link>
                            </li>
                            <li class="footer-item"><router-link class="footer-link" :to="{name:'Blog'}">Read our
                                blog</router-link></li>


                            <li
                                class="footer-item">
                                <router-link class=footer-link :to="{name:'ConditionsOfUse'}">Conditions of
                                Use</router-link>
                            </li>
                            <li class="footer-item">
                                <router-link class="footer-link" :to="{name:'PrivacyPolicy'}">Privacy
                                    Policy</router-link></li>
                        </ul>
                        <br>
                        <p>© Copyright {{copyrightYear}} Poe Studios </p>

                    </div>

                    <div class="column is-6 ">
                        <p><a href="tel:233553795656">+233(0)55-379-5656</a></p>
                        <p><a href="mailto:support@jobs233.com" >support@jobs233.com</a></p>

                        <div class="jb-social">
                            <router-link class="social-link" to="#">
                                <b-icon icon="linkedin"/>
                            </router-link>
                            <router-link class="social-link" to="#">
                                <b-icon icon="facebook"/>
                            </router-link>
                            <router-link class="social-link" to="#">
                                <b-icon icon="instagram"/>
                            </router-link>
                            <router-link class="social-link" to="#">
                                <b-icon icon="twitter"/>
                            </router-link>
                        </div>
                    </div>


                </div>

            </div>
        </div>



    </footer>
</template>

<script>
    export default {

        data() {
            return {}
        },
        computed: {
            copyrightYear() {

                let year = new Date().getFullYear();
                if (year !== 2020) {

                    return 2020 + '-' + year;
                }
                return 2020;
            }
        }
    }
</script>

<style scoped lang="scss">

</style>
