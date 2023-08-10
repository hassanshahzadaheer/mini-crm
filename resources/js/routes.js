// routes.js
import VueRouter from "vue-router";
import CompaniesList from "./components/companies/CompaniesList.vue";
import CreateCompanyForm from "./components/companies/CreateCompanyForm.vue";
import EditCompanyForm from "./components/companies/EditCompanyForm.vue";
import EmployeeList from "./components/employees/EmployeeList.vue";
import AddNewEmployee from "./components/employees/AddEmployee.vue";
import EditEmployee from "./components/employees/EditEmployee.vue";
import Home from "./components/home.vue";

// application routes
const routes = [
    {
        // Route for displaying a list of companies
        path: "/companies",
        component: CompaniesList,
    },
    {
        // Route for creating a new company
        path: "/companies/create",
        component: CreateCompanyForm,
        name: "create-company",
        meta: {
            requiresAuth: true,
        },
    },
    {
        // Route for editing an existing company
        path: "/companies/:companyId/edit",
        name: "edit-company",
        component: EditCompanyForm,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        // Route for displaying a list of employees
        path: "/employees",
        name: "employee-list",
        component: EmployeeList,
        meta: {
            requiresAuth: true,
        },
    },
    {
        // Route for editing an existing employee
        path: "/employees/:employeeId/edit",
        name: "edit-employee",
        component: EditEmployee,
        props: true,
    },
    {
        // Route for creating a new employee
        path: "/employees/create",
        name: "create-employee",
        component: AddNewEmployee,
        props: true,
    },
    {
        // Route for the home page
        path: "/home",
        name: "home",
        component: Home,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
];

//  VueRouter instance
const router = new VueRouter({
    mode: "history",
    routes,
});

export default router;
