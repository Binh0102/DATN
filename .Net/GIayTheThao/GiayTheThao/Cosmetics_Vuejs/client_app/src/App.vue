<template>
  <v-app>
    <nav-bar />
    <v-main>
      <router-view />
    </v-main>
    <foo-ter />


  <ToastMessage v-model="this.$store.state.loginErro.show" :content="loginErro.content" :color="loginErro.color" :icon="loginErro.icon"/>
  </v-app>
</template>
<script>
import NavBar from './components/NavBar.vue';
import FooTer from './components/FooTer.vue';
import ToastMessage from './components/ToastMessage.vue';
import { mapGetters, mapActions } from 'vuex';
export default {
  components: { NavBar, FooTer,ToastMessage },
  data: () => ({
    length: 3,
    window: 0,
  }),
  methods:{
    ...mapActions(['getsessionStorage_token']),
    ok()
    {
      console.log(loginErro)
    }
  },
  created()
  {
    this.getsessionStorage_token()
  },
  computed:{
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
