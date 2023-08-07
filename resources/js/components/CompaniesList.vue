<template>
  <div class="container">
    <h1>Companies List</h1>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Logo</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Actions</th> <!-- New column for delete buttons -->
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
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      companies: [],
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      axios.get('/api/companies')
        .then(response => {
          this.companies = response.data.data;
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
