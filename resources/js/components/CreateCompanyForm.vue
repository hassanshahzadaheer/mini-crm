<template>
    <div class="container">
        <h1>Create Company</h1>
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
            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" id="logo" @change="handleFileChange" class="form-control-file" />
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            formData: {
                name: '',
                email: '',
                website: '',
                logo: null,
            },
        };
    },
    methods: {
        handleFileChange(event) {
            this.formData.logo = event.target.files[0];
        },
        submitForm() {
            const formData = new FormData();
            formData.append('name', this.formData.name);
            formData.append('email', this.formData.email);
            formData.append('website', this.formData.website);
            formData.append('logo', this.formData.logo);

            axios
                .post('/api/companies', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then(response => {
                    // Handle success, show success message, etc.
                    console.log('Company created:', response.data.data);
                })
                .catch(error => {
                    // Handle error, show error message, etc.
                    console.error('Error creating company:', error);
                });
        },
    },
};
</script>
