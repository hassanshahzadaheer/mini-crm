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
        </tr>
      </thead>
      <tbody>
        <tr v-for="(company, index) in companies" :key="company.id">
          <td>{{ index + 1 }}</td>
          <td>
              <img
                v-if="company.logo"
                :src="company.logo"
                alt="Company Logo"
                style="max-width: 100px; max-height: 100px;"
              />
            </td>
          <td><a :href="company.website">{{ company.name }}</a></td>
          <td>{{ company.email }}</td>
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
    console.log('Fetching data...');
    axios.get('/api/companies')
      .then(response => {
        console.log('Data received:', response.data.data);
        this.companies = response.data.data;
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  },
};
</script>
