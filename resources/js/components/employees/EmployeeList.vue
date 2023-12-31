<template>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Employees List</h1>

        <router-link to="/employees/create" class="btn btn-success btn-sm">Add New Employee</router-link>

          </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(employee, index) in employees" :key="employee.id">
                    <td>{{ employee.id }}</td>
                    <td>{{ employee.first_name }}</td>
                    <td>{{ employee.last_name }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.phone }}</td>
                    <td>
                        <!-- Edit button -->
                        <router-link :to="editEmployeeLink(employee.id)" class="btn btn-primary btn-sm">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </router-link>
                        <!-- Delete button -->
                        <button @click="confirmDelete(employee.id)" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- pagination -->
    <div class="d-flex justify-content-center">
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            @input="fetchData"
          >
          </b-pagination>
        </div>


    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    computed: {
        editEmployeeLink() {
            return (employeeId) => `/employees/${employeeId}/edit`;
        },
    },
    data() {
        return {
            employees: [],
            currentPage: 1, // Initialize currentPage
            perPage: 10,   // Set your desired perPage value
            totalRows: 0,  // Initialize totalRows
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
     fetchData(page = 1) {
            axios.get(`/api/employees?page=${page}`)
                .then(response => {
                    this.employees = response.data.data;
                    this.currentPage = page;
                    this.totalRows = response.data.meta.total; // Update totalRows here
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteEmployee(id);
                }
            });
        },
        deleteEmployee(employeeId) {
            axios.get(`/api/employees/${employeeId}`)
                .then(response => {
                    const employee = response.data.data;
                    if (employee.company_id !== null) {
                        // Employee has a company reference, show alert
                        Swal.fire({
                            title: 'Cannot Delete Employee',
                            text: 'This employee is associated with a company. Please remove the company reference before deleting.',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        // No company reference, proceed with deletion
                        axios.delete(`/api/employees/${employeeId}`)
                            .then(response => {
                                console.log('Employee deleted:', response.data.message);
                                this.fetchData();
                            })
                            .catch(error => {
                                console.error('Error deleting employee:', error);
                            });
                    }
                })
                .catch(error => {
                    console.error('Error fetching employee details:', error);
                });
        },

    },
};
</script>
