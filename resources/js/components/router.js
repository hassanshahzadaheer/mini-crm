import Vue from "vue";
import VueRouter from "vue-router";
import AppLayout from "./components/AppLayout.vue"; // Import the AppLayout component
import CompaniesList from "./components/CompaniesList.vue";
import CreateCompanyForm from "./components/CreateCompanyForm.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: AppLayout, // Use the AppLayout component as the main layout
        children: [
            { path: "companies", component: CompaniesList },
            { path: "companies/create", component: CreateCompanyForm },
        ],
    },
];

const router = new VueRouter({
    mode: "history",
    routes,
});

export default router;
