<template>
    <Form @submit="handleRegister" :validation-schema="schema">
        <div v-if="!successful">
            <div class="form-group pb-4">
                <label for="name">Name</label>
                <Field name="name" type="text" class="form-control" />
                <ErrorMessage name="name" class="error-feedback text-danger" />
            </div>
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
                    <span v-show="!loading">Sign Up</span>
                </button>
                <div class="pt-4">
                    <a class="list-group-item" href="/login">Login instead</a>
                </div>
            </div>
        </div>
    </Form>

    <div v-if="message" class="alert my-4" :class="successful ? 'alert-success' : 'alert-danger'">
        {{ message }}
    </div>
</template>
  
<script>

import { Form, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';

export default {
    name: 'RegisterComponent',
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        const schema = yup.object().shape({
            name: yup
                .string()
                .required('Name is required!')
                .min(3, 'Must be at least 3 characters!')
                .max(20, 'Must be maximum 20 characters!'),
            email: yup
                .string()
                .required('Email is required!')
                .email('Email is invalid!')
                .max(50, 'Must be maximum 50 characters!'),
            password: yup
                .string()
                .required('Password is required!')
                .min(6, 'Must be at least 6 characters!')
                .max(40, 'Must be maximum 40 characters!'),
        });

        return {
            successful: false,
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
        handleRegister(user) {
            this.message = '';
            this.successful = false;
            this.loading = true;

            this.$store.dispatch('auth/register', user).then(
                () => {
                    this.$router.push('/');
                },
                (error) => {
                    this.message = error.response.data.message;
                    this.successful = false;
                    this.loading = false;
                }
            );
        },
    },
};

</script>