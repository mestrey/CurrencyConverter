<template>
    <Form @submit="handleLogin" :validation-schema="schema">
        <div class="form-group">
            <label for="email">Email</label>
            <Field name="email" type="email" class="form-control" />
            <ErrorMessage name="email" class="error-feedback" />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <Field name="password" type="password" class="form-control" />
            <ErrorMessage name="password" class="error-feedback" />
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-block" :disabled="loading">
                <span v-show="loading" class="spinner-border spinner-border-sm"></span>
                <span>Login</span>
            </button>
        </div>

        <div class="form-group">
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
    created() {
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
                    this.message =
                        (error.response &&
                            error.response.data &&
                            error.response.data.message) ||
                        error.message ||
                        error.toString();
                }
            );
        },
    },
};

</script>