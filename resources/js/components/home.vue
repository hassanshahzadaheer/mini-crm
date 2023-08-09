<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                      <div v-if="userData">
          <p>You are logged in as {{ userData.name }}!</p>
        </div>
        <div v-else>
          Loading user data...
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
        };
    },
    async mounted() {
        // Set CSRF token in axios headers
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await axios.get('/api/user');
            this.userData = response.data.user;
        } catch (error) {
            console.error('Error fetching user data:', error);
        }
    },
};
</script>
