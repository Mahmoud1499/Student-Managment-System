<template>
  <div>
    <SideNav />
    <router-view></router-view>

    <AppFooter />
  </div>
</template>

<script>
import SideNav from "./components/Shared/nav-bar.vue";
import AppFooter from "./components/Shared/app-footer.vue";

export default {
  name: "App",
  components: {
    SideNav,
    AppFooter,
  },
};
</script>

<style>
#app {
}
</style>
