
<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                         <ul class="navbar-nav me-auto">
                               <li class="nav-item">
                                       <router-link to="/companies">Companies</router-link>
                                    </li>

                                     <li class="nav-item">
                                           <router-link to="/companies/edit">Edit Company</router-link>
                                        </li>

                        </ul>
                    </div>


            </div>

        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "AppLayout",
};
</script>
