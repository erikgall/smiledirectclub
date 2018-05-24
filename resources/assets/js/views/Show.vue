<template>
    <div class="d-flex align-items-center">
        <div class="card w-100 text-center" v-if="message">
            <div class="card-body">
                <p class="card-text">{{ message }}</p>
                <router-link :to="{ name: 'users' }" class="btn btn-sm btn-primary">Go back</router-link>
            </div>

        </div>
        <div class="card w-100 text-center" v-if="user">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ user.first_name }} {{ user.last_name }} <small class="text-muted">- {{ user.gender }}</small></h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ user.email }}</h6>
                <router-link :to="{ name: 'users' }" class="btn btn-sm btn-primary">Go back</router-link>
            </div>
            <div class="card-footer">
                <span class="text-muted text-center">Last Updated: {{ user.updated_at }}</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    methods: {
        /**
         * Fetch the user by id from the API.
         *
         * @return {void}
         */
        async fetchUser () {
            try {
                let response = await this.$http.get(`api/users/${this.$route.params.id}`)

                this.user = response.data
            } catch (e) {
                this.message = e.response.data.message
            }
        }
    },

    /**
     * The component's name.
     */
    name: 'show',

    /**
     * The component's created lifecycle hook.
     *
     * @return {void}
     */
    created () {
        this.fetchUser()
    },

    /**
     * Get the component's intial state.
     *
     * @return {Object}
     */
    data () {
        return {
            loading: false,
            message: '',
            user: null
        }
    }
}
</script>
