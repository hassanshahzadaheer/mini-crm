require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import CompaniesList from "./components/CompaniesList.vue";
import CreateCompanyForm from "./components/CreateCompanyForm.vue";
import EditCompanyForm from "./components/EditCompanyForm.vue";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

import Home from "./components/home.vue";


// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

Vue.use(VueRouter);

Vue.component("companies-list", CompaniesList);
Vue.component("create-company-form", CreateCompanyForm);
Vue.component("edit-company-form", EditCompanyForm);
Vue.component("home", Home);

const routes = [
    { path: "/companies", component: CompaniesList },
    {
        path: "/companies/create",
        component: CreateCompanyForm,
        name: "create-company",
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/companies/:companyId/edit",
        name: "edit-company",
        component: EditCompanyForm,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/home",
        name: "home",
        component: Home,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
];

const router = new VueRouter({
    mode: "history",
    routes,
});

const app = new Vue({
    el: "#app",
    router,
});
