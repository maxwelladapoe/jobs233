<template>
</template>

<script>


    export default {
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Sign Up',

        },
        data: function () {
            return {
                ismv: true,
                ipv: false,
                showSignUp: true,
                showLogin: false,

                signupCredentials: {
                    name: '',
                    email: '',
                    password: '',
                    action: ''
                },
                error: false,
                success: false
            }
        },
        methods: {
            reqSignUp() {
                this.errors.clear();// clearing the errors array incase there are any errors
                this.ismv = true;
                this.showLogin = false;
                this.showSignUp = true;
            },
            reqLogin() {
                this.errors.clear();
                this.ismv = true;
                this.showSignUp = false;
                this.showLogin = true;

            },
        },
        created() {

        },


    }
</script>

<style scoped>

</style>
