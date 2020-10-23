<template>
    <div class="jb-dash-nav bg-ash">
        <div class="container">
            <div class="jb-dash-links">
                <router-link :to="{name:'Dashboard'}" class="jb-dash-link t-white ">My Dashboard</router-link>
                <a href="#" class="jb-dash-link t-white ">My Projects</a>
                <a href="#" class="jb-dash-link t-white ">Wallet</a>
                <router-link :to="{name:'Messages'}" class="jb-dash-link t-white ">Messages</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "dash-nav"
    }
</script>

<style scoped>

</style>
