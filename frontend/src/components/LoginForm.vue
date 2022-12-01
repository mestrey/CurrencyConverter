<template>
    <Form @submit="handleLogin" :validation-schema="schema">
        <div class="form-group pb-4">
            <label for="email">Email</label>
            <Field name="email" type="email" class="form-control" />
            <ErrorMessage name="email" class="error-feedback text-danger" />
        </div>
        <div class="form-group pb-4">
            <label for="password">Password</label>
            <Field name="password" type="password" class="form-control" />
            <ErrorMessage name="password" class="error-feedback text-danger" />
        </div>

        <div class="form-group text-center">
            <button class="btn btn-dark btn-block" :disabled="loading">
                <div v-show="loading" class="loading mr-4"></div>
                <span v-show="!loading">Login</span>
            </button>
            <div class="pt-4">
                <a class="list-group-item" href="/register">Create an account</a>
            </div>
        </div>

        <div class="form-group my-4">
            <div v-if="message" class="alert alert-danger" role="alert">
                {{ message }}
            </div>
        </div>
    </Form>
</template>

<script>

import { Form, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';

export default {
    name: 'LoginComponent',
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        const schema = yup.object().shape({
            email: yup
                .string()
                .required("Email is required!")
                .email("Email is invalid!"),
            password: yup
                .string()
                .required('Password is required!'),
        });

        return {
            loading: false,
            message: '',
            schema,
        };
    },
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
    },
    mounted() {
        if (this.loggedIn) {
            this.$router.push('/');
        }
    },
    methods: {
        handleLogin(user) {
            this.loading = true;

            this.$store.dispatch('auth/login', user).then(
                () => {
                    this.$router.push('/');
                },
                (error) => {
                    this.loading = false;
                    this.message = error.response.data.message;
                }
            );
        },
    },
};

</script>