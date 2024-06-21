import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/about",
    name: "about",
    component: () => import("../views/AboutView.vue"),
  },
  {
    path: "/header",
    name: "header",
    component: () => import("../components/Admin/HeaderView.vue"),
  },
  {
    path: "/TestTable",
    name: "TestTable",
    component: () => import("@/views/TestTable.vue"),
  },
  {
    path: "/CategoryView",
    name: "CategoryView",
    component: () => import("@/views/Admin/Category/CategoryView.vue"),
  },
  {
    path: "/ProductView",
    name: "ProductView",
    component: () => import("@/views/Admin/Product/ProductView.vue"),
  },
  {
    path: "/Dashboard",
    name: "Dashboard",
    component: () => import("@/views/Admin/Dashboard/IndexView.vue"),
  },
  {
    path: "/DonHang",
    name: "DonHang",
    component: () => import("@/views/Admin/DonHang/IndexView.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
