<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

            <div class="row mt-4">
                <div class="col-md-6">
                   <div class="card bg-light mb-3" >
                        <div class="card-header">Total Companies</div>
                        <div class="card-body text-center">
                            <h1 class="card-title text-success">{{ totalCompanies }}</h1>
                            <router-link to="/companies" class="btn btn-link">View Companies</router-link>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="card bg-light mb-3" >
                            <div class="card-header">Total Employees</div>
                            <div class="card-body text-center">
                                <h1 class="card-title text-success">{{ totalEmployees }}</h1>
                                <router-link to="/employees" class="btn btn-link">View Employees</router-link>
                            </div>
                        </div>
                </div>
            </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            userData: null,
            totalEmployees: 0,
            totalCompanies: 0,
        };
    },
    created() {
        this.fetchUserData();
         this.fetchTotalCounts();
    },
    methods: {
        async fetchUserData() {
            try {
                const response = await axios.get('/api/user');
                this.userData = response.data.user;
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },
      async fetchTotalCounts() {
            try {
                const response = await axios.get('/api/totals'); // Update the endpoint
                this.totalEmployees = response.data.totalEmployees;
                this.totalCompanies = response.data.totalCompanies;
            } catch (error) {
                console.error('Error fetching total counts:', error);
            }
        },
    },
};
</script>
