<template>
    <div class="jb-dash-nav bg-ash">
        <div class="container">
            <div class="jb-dash-links">
                <router-link to="/dashboard" class="jb-dash-link t-white ">My Dashboard</router-link>
                <a href="#" class="jb-dash-link t-white ">My Projects</a>
                <a href="#" class="jb-dash-link t-white ">Billing</a>
                <a href="#" class="jb-dash-link t-white ">Profile</a>
                <a href="#" class="jb-dash-link t-white ">Inbox</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "dashboard-top"
    }
</script>

<style scoped>

</style>