
<template>
    <div class="container bg-light">
        <h1 class="text-center mt-4">Create Company</h1>
        <div class="mx-auto mt-4" style="max-width: 800px">
            <form @submit.prevent="submitForm">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input id="name" class="form-control" v-model="formData.name" :class="{ 'is-invalid': !formData.name }"
                        required />
                    <div class="invalid-feedback">Please enter a valid name.</div>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" class="form-control" v-model="formData.email"
                        :class="{ 'is-invalid': !formData.email || !validateEmail(formData.email) }" type="email" required />
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>

                <div class="form-group">
                    <label for="website">Website:</label>
                    <input id="website" class="form-control" v-model="formData.website" />
                </div>

                <div class="form-group">
                    <label for="logo">Logo:</label>
                    <input id="logo" class="form-control" type="file" @change="handleLogoChange"
                        :class="{ 'is-invalid': !formData.logo }" required />
                    <div class="invalid-feedback">Please choose a valid logo file.</div>
                </div>


                <button type="submit" class="btn btn-primary btn-lg text-center mt-4" :disabled="isLoading">
                    <i class="fas fa-plus"></i>
                    <span class="mr-2 text-center">{{ isLoading ? 'Sending...' : 'Create' }}</span>
                </button>
            </form>


        </div>
    </div>
</template>

<script>


import axios from 'axios';
import Swal from 'sweetalert2';


export default {

    data() {
        return {
            formData: {
                name: '',
                email: '',
                website: '',
                logo: null,
                 showSuccess: false,
            },
        };
    },
    methods: {
      submitForm() {
            // Validate fields
            const validName = this.formData.name.trim() !== '';
            const validEmail = this.validateEmail(this.formData.email);
            const validLogo = this.formData.logo !== null;

            if (!validName || !validEmail || !validLogo) {
                return;
            }

            // Start loading state
            this.isLoading = true;

            // Submission logic using axios
            const formData = new FormData();
            formData.append('name', this.formData.name);
            formData.append('email', this.formData.email);
            formData.append('website', this.formData.website);
            formData.append('logo', this.formData.logo);

            // Send request to create a company
            axios
                .post('/api/companies', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then(response => {
                    // Handle success
                    Swal.fire({
                        title: 'Success',
                        text: 'Company created successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        this.$router.push('/companies');
                    });

                    // Reset loading state
                    this.isLoading = false;
                })
                .catch(error => {
                    // Handle error
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while creating the company.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });

                    // Reset loading state
                    this.isLoading = false;
                });
        },

        validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },
        handleLogoChange(event) {
            this.formData.logo = event.target.files[0];
        },
    },
};
</script>
