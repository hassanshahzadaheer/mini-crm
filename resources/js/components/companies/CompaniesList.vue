<template>
  <div class="container">
   <div class="d-flex justify-content-between align-items-center">
        <h1>Companies List</h1>

    <router-link to="/companies/create" class="btn btn-success btn-sm">Add New Company</router-link>

      </div>


    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Logo</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(company, index) in companies" :key="company.id">
          <td>{{ company.id }}</td>
          <td>
            <img v-if="company.logo" :src="company.logo" alt="Company Logo"
              style="max-width: 100px; max-height: 100px;" />
          </td>
          <td><a :href="company.website">{{ company.name }}</a></td>
          <td>{{ company.email }}</td>
          <td>
             <!-- Edit button -->

    <router-link :to="editCompanyLink(company.id)" class="btn btn-primary btn-sm">
              <i class="fas fa-pencil-alt"></i> Edit
            </router-link>
            <!--  delete button -->
             <button @click="confirmDelete(company.id)" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
          </td>
        </tr>
      </tbody>
    </table>


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
    editCompanyLink() {
      return (companyId) => `/companies/${companyId}/edit`;
    }
  },
  data() {
    return {
      companies: [],
       currentPage: 1, // Initialize currentPage
      perPage: 10,   // Set your desired perPage value
      totalRows: 0,  // Initialize totalRows
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    // Navigate to the add company page using Vue Router
    navigateToAddCompany() {
      this.$router.push({ name: 'companies.create' });
    },

    // Fetch data from the API for displaying companies
    fetchData(page = 1) {
      axios.get(`/api/companies?page=${page}`)
        .then(response => {
          this.companies = response.data.data;
          this.currentPage = page;
          this.totalRows = response.data.meta.total;
        })
        .catch(error => {
          Swal.fire({
            title: 'Error',
            text: 'An error occurred while fetching data.',
            icon: 'error',
            confirmButtonText: 'OK',
          });
        });
    },

    // Edit company logic (not implemented)
    editCompany(companyId) {

    },

    // Confirm deletion of a company using Swal alert
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
          this.deleteCompany(id);
        }
      });
    },

    // Delete a company and show Swal alert on success/error
    deleteCompany(companyId) {
      Swal.fire({
        title: 'Deleting Company',
        text: 'Please wait...',
        icon: 'info',
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
      });

      axios.delete(`/api/companies/${companyId}`)
        .then(response => {
          Swal.fire({
            title: 'Success',
            text: response.data.message,
            icon: 'success',
            confirmButtonText: 'OK',
          });
          this.fetchData();
        })
        .catch(error => {
          Swal.fire({
            title: 'Error',
            text: 'An error occurred while deleting the company.',
            icon: 'error',
            confirmButtonText: 'OK',
          });
        });
    },
  },
};
</script>
