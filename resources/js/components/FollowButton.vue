<template>
    <button 
        class="btn btn-primary ml-3" 
        @click="followUser" 
        v-text="buttonText">
    </button>
</template>

<script>
    export default {
        props: ['userId', 'follows'],
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                status: this.follows,
            }
        },

        methods: {
            followUser() {
                axios.post(`/follow/${this.userId}`)
                    .then(res => {
                        console.log(res)
                        this.status = !this.status;
                    })
                    .catch(err => {
                        // if it is an authorization error, it will be 401
                        // redirect the user to the login page
                        if (err.response.status == 401) {
                            window.location = '/login';
                        }
                    });
            }
        },

        computed: {
            buttonText() {
                console.log(this.status)
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }
    }
</script>
