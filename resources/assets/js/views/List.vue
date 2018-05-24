<template>
    <div class="d-flex flex-column">
        <h1 class="h3 border-bottom pb-1 mb-3 font-weight-normal">Registered Users</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col" @click.prevent="setSortKey('id')">
                            <span class="btn-link">ID</span>
                        </th>
                        <th scope="col" @click.prevent="setSortKey('first_name')">
                            <span class="btn-link">First Name</span>
                        </th>
                        <th scope="col" @click.prevent="setSortKey('last_name')">
                            <span class="btn-link">Last Name</span>
                        </th>
                        <th scope="col" @click.prevent="setSortKey('gender')">
                            <span class="btn-link">Gender</span>
                        </th>
                        <th scope="col" @click.prevent="setSortKey('email')">
                            <span class="btn-link">E-Mail Address</span>
                        </th>
                        <th scope="col">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td colspan="6">Loading... Please wait..</td>
                    </tr>
                    <tr v-else-if="users.length == 0">
                        <td colspan="6">No users have been registered.</td>
                    </tr>
                    <tr v-else v-for="user in filteredData" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.first_name }}</td>
                        <td>{{ user.last_name }}</td>
                        <td>{{ user.gender }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <router-link :to="{ name: 'users.show', params: { id: user.id } }" class="btn btn-sm btn-primary">View</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h6 class="mt-3 font-weight-normal">Total Users: {{ users.length }}</h6>
    </div>
</template>
<script>
export default {
    computed: {
        /**
         * Sort and filter the data.
         *
         * @return {Array}
         */
        filteredData () {
            let data = this.users

            if (this.sortKey) {
                data = data.slice().sort((a, b) => {
                    a = a[this.sortKey]
                    b = b[this.sortKey]

                    if (a === b) {
                        return 0
                    }

                    if (this.reversed) {
                        return a < b ? 1 : -1
                    }

                    return a > b ? 1 : -1
                })
            }

            return data
        }
    },
    methods: {
        /**
         * Fetch the registered users from the API.
         *
         * @return {void}
         */
        async fetchUsers () {
            try {
                let response = await this.$http.get('api/users')

                this.users = response.data || []
            } catch (e) {
                this.users = []
            }
            setTimeout(() => this.loading = false, 500)
        },

        /**
         * Set the table's sort by key.
         *
         * @return {void}
         */
        setSortKey (sortKey) {
            this.reversed = this.sortKey === sortKey ? !this.reversed : false
            this.sortKey = sortKey
        }
    },

    /**
     * The component's name.
     */
    name: 'list',

    /**
     * The component's mounted lifecycle hook.
     *
     * @return {void}
     */
    mounted () {
        this.fetchUsers()
    },

    /**
     * Get the component's initial state.
     *
     * @return {Object}
     */
    data() {
        return {
            users: [],
            loading: true,
            sortKey: 'id',
            reversed: false,
        }
    }
}
</script>
