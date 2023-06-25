<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <router-link to="/" class="navbar-brand">Logo</router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item" v-for="item in navItems" :key="item.id">
            <router-link :to="item.path" class="nav-link">{{ item.label }}</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      navItems: [
        { id: 1, label: 'Home', path: '/' },
        { id: 2, label: 'About', path: '/about' },
        { id: 3, label: 'Contact', path: '/contact' }
      ]
    };
  }
};
</script>

<style scoped>
/* Add any custom styles here */

.navbar-brand {
  font-weight: bold;
}
</style>
