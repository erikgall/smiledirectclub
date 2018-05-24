<template>
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container">
            <router-link :to="{ name: 'home' }" class="navbar-brand">SmileDirectClub</router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li>
                        <router-link class="nav-link" :to="{ name: 'home' }">Register</router-link>
                    </li>
                    <li>
                        <router-link class="nav-link" :to="{ name: 'users' }">View all Users</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
export default {
    name: 'navbar'
}
</script>
