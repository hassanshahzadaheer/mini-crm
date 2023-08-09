<template>
    <div class="container">
        <h1 class="text-center mt-4">Edit Employee</h1>
        <div class="mx-auto mt-4" style="max-width: 800px">
            <form @submit.prevent="submitForm">
                <!-- first_name -->
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" v-model="formData.first_name" class="form-control"
                        :class="{ 'is-invalid': !validationState.first_name }" required @blur="validateFirstName" />
                    <div v-if="!validationState.first_name" class="invalid-feedback">
                        Please enter a valid first name.
                    </div>
                </div>
                <!-- last_name -->
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" v-model="formData.last_name" class="form-control"
                        :class="{ 'is-invalid': !validationState.last_name }" required @blur="validateLastName" />
                    <div v-if="!validationState.last_name" class="invalid-feedback">
                        Please enter a valid last name.
                    </div>
                </div>
                <!-- email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" v-model="formData.email" class="form-control"
                        :class="{ 'is-invalid': !validationState.email }" required @blur="validateEmail" />
                    <div v-if="!validationState.email" class="invalid-feedback">
                        Please enter a valid email.
                    </div>
                </div>
                <!-- phone -->
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" v-model="formData.phone" class="form-control"
                        :class="{ 'is-invalid': !validationState.phone }" required @blur="validatePhone" />
                    <div v-if="!validationState.phone" class="invalid-feedback">
                        Please enter a valid phone number.
                    </div>
                </div>
                <!-- submit button -->
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
import Swal from 'sweetalert2';

export default {
    props: {
        employeeId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            formData: {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
            },
            validationState: {
                first_name: true,
                last_name: true,
                email: true,
                phone: true,
            },
        };
    },
    methods: {
        validateFirstName() {
            this.validationState.first_name = !!this.formData.first_name.trim();
        },
        validateLastName() {
            this.validationState.last_name = !!this.formData.last_name.trim();
        },
        validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.validationState.email = emailRegex.test(this.formData.email);
        },
        validatePhone() {
            this.validationState.phone = !!this.formData.phone.trim();
        },
        fetchEmployeeData() {
            axios
                .get(`/api/employees/${this.employeeId}`)
                .then(response => {
                    const employeeData = response.data.data;
                    this.formData = { ...employeeData };
                })
                .catch(error => {
                    console.error('Error fetching employee data:', error);
                });
        },
        submitForm() {
            this.validateFirstName();
            this.validateLastName();
            this.validateEmail();
            this.validatePhone();

            if (!this.validationState.first_name || !this.validationState.last_name ||
                !this.validationState.email || !this.validationState.phone) {
                return;
            }

            axios
                .put(`/api/employees/${this.employeeId}`, this.formData)
                .then(response => {
                    console.log('Employee updated:', response.data.data);
                    Swal.fire({
                        title: 'Success',
                        text: response.data.data.first_name + ' ' + response.data.data.last_name + ' updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        this.$router.push('/employees');
                    });
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        console.log('Validation errors:', error.response.data.errors);
                    } else {
                        console.error('Error updating employee:', error);
                    }
                });
        },
    },
    created() {
        this.fetchEmployeeData();
    },
};
</script>
