<template>
  <div class="container">
   <div class="d-flex justify-content-between align-items-center">
        <h1>Companies List</h1>
        <router-link class="btn btn-success btn-sm text-right" to="/companies/create">
        Add New Company
      </router-link>
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
          <td>{{ index + 1 }}</td>
          <td>
            <img v-if="company.logo" :src="company.logo" alt="Company Logo"
              style="max-width: 100px; max-height: 100px;" />
          </td>
          <td><a :href="company.website">{{ company.name }}</a></td>
          <td>{{ company.email }}</td>
          <td>
            <!-- New delete button -->
             <button @click="confirmDelete(company.id)" class="btn btn-danger btn-sm">Delete</button>
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
          <template #ellipsis-text>
            <b-spinner small type="grow"></b-spinner>
            <b-spinner small type="grow"></b-spinner>
            <b-spinner small type="grow"></b-spinner>
          </template>
        </b-pagination>
      </div>





  </div>
</template>
<script>
import axios from 'axios';


export default {
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

    confirmDelete(id) {
      if (window.confirm('Are you sure you want to delete this company?')) {
        this.deleteCompany(id);
      }
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
