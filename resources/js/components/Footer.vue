<template>
    <footer class="jb-footer has-background-pattern-white">

        <div class="section">
            <div class="container">
                <div class="columns">
                    <div class="column is-4">
                        <p class="jb-footer-essay t-meri"> Hire the right people, get work done on time and work within your
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
                            <li class="footer-item"><a class="footer-link" href="help">Help</a></li>
                            <li class="footer-item"><a class="footer-link" href="faq">FAQ</a></li>
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
                                <router-link class="footer-link " :to="{name:'About'}">Learn more about Jobs233
                                </router-link>
                            </li>
                            <li class="footer-item"><a class="footer-link" href="read.html">Read our blog</a></li>
                            <li class="footer-item"><a class="footer-link " href="login.html">Subscribe to our News
                                Letter</a>
                            </li>
                            <li class="footer-item"><a class=footer-link href="conditions.html">Conditions of Use</a></li>
                            <li class="footer-item"><a class="footer-link" href="privacy.html">Privacy Notice</a></li>
                        </ul>
                        <br>
                        <p>© Copyright {{copyrightYear}} Poe Studios </p>

                    </div>

                    <div class="column is-6 ">
                        <p>+233(0)275762217</p>
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
