// app.js
require("./bootstrap");

import Vue from "vue";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import VueRouter from "vue-router";
import router from "./routes";

import CompaniesList from "./components/companies/CompaniesList.vue";
import CreateCompanyForm from "./components/companies/CreateCompanyForm.vue";
import EditCompanyForm from "./components/companies/EditCompanyForm.vue";
import EmployeeList from "./components/employees/EmployeeList.vue";
import AddNewEmployee from "./components/employees/AddEmployee.vue";
import EditEmployee from "./components/employees/EditEmployee.vue";
import Home from "./components/home.vue";

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueRouter);

Vue.component("companies-list", CompaniesList);
Vue.component("create-company-form", CreateCompanyForm);
Vue.component("edit-company-form", EditCompanyForm);
Vue.component("edit-employee-form", EditEmployee);
Vue.component("add-new-employee", AddNewEmployee);
Vue.component("home", Home);

const app = new Vue({
    el: "#app",
    router, // Use the router instance from routes.js
});
