<template>
    <div class="d-flex">
        <form class="form-register mx-auto" @submit.prevent="onSubmit">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">User Registration</h1>
                <h6 v-if="message" class="font-weight-normal" :class="messageClass">{{ message }}</h6>
            </div>
            <div class="form-group form-label-group">
                <input type="email" id="email" class="form-control" :class="{ 'is-invalid': hasEmailErrors }" placeholder="E-mail Address" required autofocus v-model="email">
                <label for="email">E-Mail Address</label>
                <div v-if="hasEmailErrors" class="invalid-feedback" v-for="error in errors.email" v-text="error"></div>
            </div>
            <div class="form-group form-label-group">
                <input type="text" id="name" class="form-control" :class="{ 'is-invalid': hasNameErrors }" placeholder="Name" required v-model="name">
                <label for="name">Name</label>
                <div v-if="hasNameErrors" class="invalid-feedback" v-for="error in errors.name" v-text="error"></div>
                <p class="help-text text-muted">**Using a name like "Sombaji Doe" will result in an accuracy < 70.**</p>
            </div>
            <div class="form-group form-label-group" v-if="hasGenderErrors">
                <div class="form-check">
                    <input class="form-check-input" :class="{ 'is-invalid': hasGenderErrors }" type="radio" name="gender" id="male" value="male" v-model="gender">
                    <label class="form-check-label" for="male">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" :class="{ 'is-invalid': hasGenderErrors }" type="radio" name="gender" id="female" value="female" v-model="gender">
                    <label class="form-check-label" for="female">
                        Female
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" :class="{ 'is-invalid': hasGenderErrors }" type="radio" name="gender" id="other" value="other" v-model="gender">
                    <label class="form-check-label" for="other">
                        Other
                    </label>
                    <div class="invalid-feedback" v-for="error in errors.gender" v-text="error"></div>
                </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Register</button>
            <router-link v-if="success" :to="{ name: 'users' }" class="btn btn-success btn-block">View all Users</router-link>
        </form>
    </div>
</template>
<script>
export default {

    /**
     * The component's computed properties.
     */
    computed: {

        /**
         * Check if the form has any errors.
         *
         * @return {Boolean}
         */
        hasErrors () {
            return this.hasEmailErrors || this.hasNameErrors || this.hasGenderErrors
        },

        /**
         * Check if the email input has errors.
         *
         * @return {Boolean}
         */
        hasEmailErrors () {
            return this.errors.email.length > 0
        },

        /**
         * Check if the email input has errors.
         *
         * @return {Boolean}
         */
        hasGenderErrors () {
            return this.errors.gender.length > 0
        },

        /**
         * Check if the name input has errors.
         *
         * @return {Boolean}
         */
        hasNameErrors () {
            return this.errors.name.length > 0
        },

        /**
         * Get the css class for the form message.
         *
         * @return {String}
         */
        messageClass () {
            if (this.success) {
                return 'text-success'
            }

            return this.hasErrors ? 'text-danger' : ''
        }
    },

    /**
     * The component's local methods.
     */
    methods: {

        /**
         * Get the form data object.
         *
         * @return {Object}
         */
        getFormData () {
            let data = {
                name: this.name,
                email: this.email,
                country: this.clientData.countryCode
            }

            if (this.gender) {
                data.gender = this.gender
            }

            return data
        },

        /**
         * Fetch the client's location data.
         *
         * @return {Promise}
         */
        fetchClientData() {
            return new Promise(resolve => {
                $.getJSON('http://ip-api.com/json?callback=?', data => resolve(data))
            })
        },

        /**
         * Handle an API error response.
         *
         * @param {Object} response
         * @return {void}
         */
        handleErrorResponse ({ errors, message }) {
            this.message = message

            if (errors && typeof errors === 'object') {
                this.errors.name = errors.name || []
                this.errors.email = errors.email || []
                this.errors.gender = errors.gender || []
            }
        },

        /**
         * Handle an API success response.
         *
         * @param {Object} response
         * @return {void}
         */
        handleSuccessResponse (response) {
            this.resetForm()
            this.success = true
            this.message = response.message
        },

        /**
         * Handle the form submit event.
         *
         * @return {void}
         */
        async onSubmit () {
            this.resetFormErrors()

            try {
                let response = await this.$http.post('api/users', this.getFormData())

                this.handleSuccessResponse(response.data)
            } catch (e) {
                this.handleErrorResponse(e.response.data)
            }
        },

        /**
         * Reset the form's values.
         *
         * @return {void}
         */
        resetForm () {
            this.name = ''
            this.email = ''
            this.gender = null
        },

        /**
         * Reset the form's errors.
         *
         * @return {void}
         */
        resetFormErrors () {
            this.errors = {
                name: [],
                email: [],
                gender: [],
            }
        }
    },

    /**
     * The component's name.
     */
    name: 'home',

    /**
     * The component's created lifecycle hook.
     *
     * @return {void}
     */
    created() {
        this.fetchClientData().then(data => this.clientData = data)
    },

    /**
     * Get the component's initial state.
     *
     * @return {Object}
     */
    data() {
        return {
            errors: {
                name: [],
                email: [],
                gender: [],
            },
            clientData: null,
            success: false,
            message: '',
            name: '',
            email: '',
            gender: null,
        }
    }
}
</script>
