import { createApp } from "vue";

import App from "./App.vue";
import { createWebHistory, createRouter } from "vue-router";
import routes from "./Routes";

import "bootstrap/dist/css/bootstrap.css";
import 'bootstrap'

// Vue.use(VueRouter);

const router = createRouter({
  history: createWebHistory(),
  routes,
});

createApp(App).use(router).mount("#app");
