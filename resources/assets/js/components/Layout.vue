<template>
    <div class="app">
        <navbar></navbar>
        <div class="container mt-4">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import Navbar from './Navbar.vue'
export default {
    components: {
        Navbar
    },
    name: 'layout'
}
</script>
