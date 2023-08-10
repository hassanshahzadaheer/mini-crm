<template>
    <div class="container bg-light">
        <h1 class="text-center mt-4">Create Employee</h1>
        <div class="mx-auto mt-4" style="max-width: 800px">
            <form @submit.prevent="submitForm">
                 <div class="form-group">
        <label for="company">Select Company:</label>
        <select id="company" v-model="selectedCompanyId" class="form-control">
          <option v-for="company in companies" :value="company.id" :key="company.id">{{ company.name }}</option>
        </select>
      </div>
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input id="first_name" class="form-control" v-model="formData.first_name"
                        :class="{ 'is-invalid': !formData.first_name }" required />
                    <div class="invalid-feedback">Please enter a valid first name.</div>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input id="last_name" class="form-control" v-model="formData.last_name"
                        :class="{ 'is-invalid': !formData.last_name }" required />
                    <div class="invalid-feedback">Please enter a valid last name.</div>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" class="form-control" v-model="formData.email"
                        :class="{ 'is-invalid': !formData.email || !validateEmail(formData.email) }" type="email"
                        required />
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input id="phone" class="form-control" v-model="formData.phone"
                        :class="{ 'is-invalid': !formData.phone }" required />
                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg text-center mt-4">
                    <i class="fas fa-plus"></i>
                    <span class="mr-2 text-center">Create</span>
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
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
            },
              companies: [], // Store the list of companies to populate dropdown
            selectedCompanyId: null, // Store the selected company ID
        };
    },
    methods: {
       fetchCompanies() {
            axios.get('/api/companies').then(response => {
                this.companies = response.data.data;
                console.log(response.data.data);
                if (this.companies.length > 0) {
                    this.selectedCompanyId = this.companies[0].id;
                }
            });
        },
        submitForm() {
            // Validate fields
            const validFirstName = this.formData.first_name.trim() !== '';
            const validLastName = this.formData.last_name.trim() !== '';
            const validEmail = this.validateEmail(this.formData.email);
            const validPhone = this.formData.phone.trim() !== '';

            if (!validFirstName || !validLastName || !validEmail || !validPhone) {
                return;
            }


            // Submission logic using axios
            this.formData.company_id = this.selectedCompanyId;

            axios
                .post('/api/employees', this.formData)
                .then(response => {
                    // Handle success, show success message, etc.
                    console.log('Employee created:', response.data.data);
                    Swal.fire({
                        title: 'Success',
                        text: 'Employee created successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        // Redirect to the /employees URL after clicking "OK"
                        this.$router.push('/employees');
                    });
                })
                .catch(error => {
                    // Handle error, show error message, etc.
                    console.error('Error creating employee:', error);
                });
        },
        validateEmail(email) {
            // Add your email validation logic here
            // For example, you can use a regular expression
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },
    },
    created() {
        this.fetchCompanies();
    },
};
</script>
