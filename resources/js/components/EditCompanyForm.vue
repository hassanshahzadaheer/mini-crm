<template>
  <div class="container">
    <h1>Edit Company</h1>
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" v-model="formData.name" class="form-control" required />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="formData.email" class="form-control" required />
      </div>
      <div class="form-group">
        <label for="website">Website</label>
        <input type="text" id="website" v-model="formData.website" class="form-control" />
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    companyId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      formData: {
        name: '',
        email: '',
        website: '',
      },
    };
  },
  methods: {
    fetchCompanyData() {
      axios
        .get(`/api/companies/${this.companyId}`)
        .then(response => {
          const companyData = response.data.data;
          this.formData = { ...companyData };
        })
        .catch(error => {
          console.error('Error fetching company data:', error);
        });
    },
    submitForm() {
      axios
        .put(`/api/companies/${this.companyId}`, this.formData)
        .then(response => {
          // Handle success, show success message, etc.
          console.log('Company updated:', response.data.data);
        })
        .catch(error => {
          if (error.response.status === 422) {
            // Validation errors
            console.log('Validation errors:', error.response.data.errors);
          } else {
            // Other errors
            console.error('Error updating company:', error);
          }
        });
    },
  },
  created() {
    this.fetchCompanyData();
  },
};
</script>
