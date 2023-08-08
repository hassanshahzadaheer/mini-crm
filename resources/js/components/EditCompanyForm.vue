<template>
  <div class="container">
      <h1 class="text-center mt-4">Edit Company</h1>
  <div class="mx-auto mt-4" style="max-width: 800px">
    <form @submit.prevent="submitForm">
      <!-- name -->
      <div class="form-group">
        <label for="name">Name</label>
       <input
    type="text"
    id="name"
    v-model="formData.name"
    class="form-control"
    :class="{ 'is-invalid': !validationState.name }"
    required
    @blur="validateName"
  />
  <div v-if="!validationState.name" class="invalid-feedback">
    Please enter a valid name.
  </div>
      </div>
      <!-- email -->
      <div class="form-group">
        <label for="email">Email</label>
       <input
    type="email"
    id="email"
    v-model="formData.email"
    class="form-control"
    :class="{ 'is-invalid': !validationState.email }"
    required
    @blur="validateEmail"
  />
  <div v-if="!validationState.email" class="invalid-feedback">
    Please enter a valid email.
  </div>
      </div>
      <!-- website -->
      <div class="form-group">
        <label for="website">Website</label>
        <input type="text" id="website" v-model="formData.website" class="form-control" />
      </div>

      <!-- logo -->
      <div class="form-group">
          <label for="website">Website</label>
           <input id="logo" class="form-control" type="file" accept=".jpg, .jpeg, .png" @input="validateLogo"
                          :class="{ 'is-invalid': !formData.logo }" required />
                      <div class="invalid-feedback">Please choose a valid logo file.</div>
        </div>

        <button type="submit" class="btn btn-success btn-lg text-center mt-4">
                <i class="fas fa-pencil-alt"></i>
                  <span class="mr-2 text-center">Save</span>

              </button>

    </form>
</div>

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
      validationState: {
        name: true, // Initialize as valid
        email: true,
        logo: true, // Initialize as valid
      },
    };
  },

  methods: {
    validateName() {
      if (this.formData.name.trim() === '') {
        this.validationState.name = false;
      } else {
        this.validationState.name = true;
      }
    },
    validateLogo() {
      this.validationState.logo = !!this.formData.logo;
    },
     validateEmail() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      this.validationState.email = emailRegex.test(this.formData.email);
    },
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
      this.validateName();
      this.validateEmail();
      this.validateLogo();

      if (!this.validationState.name || !this.validationState.email || !this.validationState.logo) {
        return; // Don't submit if any validation fails
      }


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
    console.log(this.companyId)
  },
};
</script>
