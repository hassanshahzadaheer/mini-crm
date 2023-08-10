require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import CompaniesList from "./components/companies/CompaniesList.vue";
import CreateCompanyForm from "./components/companies/CreateCompanyForm.vue";
import EditCompanyForm from "./components/companies/EditCompanyForm.vue";
import EmployeeList from "./components/employees/EmployeeList.vue";
import AddNewEmployee from "./components/employees/AddEmployee.vue";
import EditEmployee from './components/employees/EditEmployee.vue';


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
Vue.component("edit-employee-form", EditEmployee);
Vue.component("add-new-employee", AddNewEmployee);
Vue.component("home", Home);

const routes = [
    { path: "/companies", component: CompaniesList },
    {
        path: "p",
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
        path: "/employees",
        name: "employee-list",
        component: EmployeeList,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/employees/:employeeId/edit",
        name: "edit-employee",
        component: EditEmployee,
        props: true,
    },
    {
        path: "/employees/create",
        name: "create-employee",
        component: AddNewEmployee,
        props: true,
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
