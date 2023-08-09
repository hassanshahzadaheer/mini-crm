class Auth {
    constructor() {
        this.token = window.localStorage.getItem("token");
        let userData = window.localStorage.getItem("user");
        this.user = userData ? JSON.parse(userData) : null;

        if (this.token) {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + this.token;
        }
    }

    login(email, password) {
        return axios
            .post("/login", { email, password })
            .then((response) => {
                const { access_token, user } = response.data;
                this.token = access_token; // Assign the access token to this.token
                this.user = user; // Assign the user data to this.user
                window.localStorage.setItem("token", access_token);
                window.localStorage.setItem("user", JSON.stringify(user));
                axios.defaults.headers.common["Authorization"] =
                    "Bearer " + access_token;
                return response;
            })
            .catch((error) => {
                throw error;
            });
    }

    check() {
        return !!this.token;
    }

    logout() {
        window.localStorage.removeItem("token");
        window.localStorage.removeItem("user");
        this.user = null;
        delete axios.defaults.headers.common["Authorization"];
    }
}

export default new Auth();
