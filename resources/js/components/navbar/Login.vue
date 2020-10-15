<template>

</template>

<script>

    export default {
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Log In',

        },
        data: function () {
            return {
                ismv: true,
                ipv: false,
                showSignUp: true,
                showLogin: false,
                isLoading: false,
                loadingMessage: 'Logging in ...',

                loginCredentials: {
                    email: '',
                    password: '',
                    rememberMe: true,
                },
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
            login() {
                //this.errors is fromm the veevalidation  it automatically binds an error array to the data
                let vm = this;
                if (this.errors.any() || this.loginCredentials.email === '' || this.loginCredentials.password === '') {
                    console.log('There was an error in your form');
                    return false;
                } else {

                    vm.isLoading = true;


                    // this.$auth.login({
                    //     params: {
                    //         email: vm.loginCredentials.email,
                    //         password: vm.loginCredentials.password,
                    //     },
                    //     success: (response) => {
                    //         vm.loadingMessage = 'Login Successful';
                    //         vm.isLoading = false;
                    //
                    //
                    //     },
                    //     error: (error) => {
                    //         vm.loadingMessage = 'Oops something went wrong';
                    //         vm.isLoading = false;
                    //     },
                    //     rememberMe: vm.loginCredentials.rememberMe,
                    //     redirect: '/dashboard',
                    //     fetchUser: true,
                    // })


                }
                //REDIRECT IF LOGIN IS VALID


            },
        }


    }
</script>

<style scoped>

</style>
