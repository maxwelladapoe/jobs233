<template>


  <normal-nav v-if="!authenticated"/>
    <user-nav v-else/>

</template>

<script>

  import NormalNav from './NormalNav';
  import UserNav from './UserNav';
  import {mapGetters, mapActions} from 'vuex';

  export default {
    components:{
      normalNav: NormalNav,
      userNav: UserNav
    },
      computed:{
          ...mapGetters({
              authenticated: 'auth/authenticated',
              user: 'auth/user',
          })
      }


  }
</script>

