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
    navigateToAddCompany() {
      //  Vue Router to handle navigation, like:
       this.$router.push({ name: 'companies.create' });
    },
 fetchData(page = 1) {
      axios.get(`/api/companies?page=${page}`)
        .then(response => {
          this.companies = response.data.data;
          this.currentPage = page;
          this.totalRows = response.data.meta.total; // Update totalRows here
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },

    editCompany(companyId) {
      // Implement your edit logic here, e.g., redirect to the edit page
      console.log(`Editing company with ID: ${companyId}`);
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
          this.deleteCompany(id);
        }
      });
    },
    deleteCompany(companyId) {
      console.log(`Deleting company with ID ${companyId}...`);
      axios.delete(`/api/companies/${companyId}`)
        .then(response => {
          console.log('Company deleted:', response.data.message);
          this.fetchData();
        })
        .catch(error => {
          console.error('Error deleting company:', error);
        });
    },

  },
};
</script>
