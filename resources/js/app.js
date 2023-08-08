require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import CompaniesList from "./components/CompaniesList.vue";
import AppLayout from "./components/AppLayout.vue";
import CreateCompanyForm from "./components/CreateCompanyForm.vue";
import EditCompanyForm from "./components/EditCompanyForm.vue";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

Vue.use(VueRouter);

Vue.component("companies-list", CompaniesList);
Vue.component("create-company-form", CreateCompanyForm);
Vue.component("edit-company-form", EditCompanyForm);

const routes = [
    { path: "/companies", component: CompaniesList },
    { path: "/companies/create", component: CreateCompanyForm },
    {
        path: "/companies/:companyId/edit",
        name: "edit-company",
        component: EditCompanyForm,
        props: true,
    },
];

const router = new VueRouter({
    mode: "history",
    routes,
});

const app = new Vue({
    el: "#app",
    router,
    components: {
        AppLayout, // Register the AppLayout component
    },
    template: "<app-layout></app-layout>",
});
