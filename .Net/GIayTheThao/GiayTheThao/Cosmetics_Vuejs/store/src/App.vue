<template>
  <header-view />
  <ToastMessageVue v-model="this.$store.state.loginErro.show" :content="loginErro.content" :color="loginErro.color"
    :icon="loginErro.icon" />
  <!--  -->
</template>
<script>
import HeaderView from '@/components/Admin/HeaderView.vue';
import ToastMessageVue from './components/ToastMessage.vue';
import { mapGetters, mapActions } from 'vuex';
export default {
  components: {
    HeaderView,
    ToastMessageVue
  },
  computed: {
    ...mapGetters(['loginErro'])
  },

}
</script>
<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
