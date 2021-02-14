<template>
    <div class="hero is-fullheight has-background-pattern-white is-full-screen">
        <div class="hero-body">
            <div class="container">

                <div class="columns is-multiline">
                    <div class="column is-12 is-8-tablet is-offset-2-tablet is-4-desktop is-offset-4-desktop">


                        <div class="card">

                            <div class="card-header py-2">
                                <div class="is-centered has-text-centered " style="width: 100%">
                                    <img src="/images/logo.png" width="120px"/>
                                </div>
                            </div>
                            <div class="card-content">
                                <ValidationObserver>

                                    <form action="">


                                        <ValidationProvider
                                            mode="lazy"
                                            slim
                                        >
                                            <b-field label="Email" label-class="t-bold t-mont" expanded>
                                                <b-input expanded></b-input>
                                            </b-field>
                                        </ValidationProvider>

                                        <ValidationProvider>

                                            <b-field label="Password" label-class="t-bold t-white t-mont" expanded>
                                                <b-input expanded>

                                                </b-input>
                                            </b-field>
                                        </ValidationProvider>

                                        <b-checkbox class="mt-3" type="is-success">Remember me
                                        </b-checkbox>


                                        <b-field label="" class="has-text-centered">
                                            <b-button class="mt-5 " type="submit is-primary" expanded>
                                                Login
                                            </b-button>
                                        </b-field>

                                    </form>
                                </ValidationObserver>
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
    name: "AdminLogin"
}
</script>

<style scoped>

</style>
