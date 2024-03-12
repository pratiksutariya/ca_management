<script setup lang="ts">
import { ref } from 'vue';
import { required, helpers, email } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useToast } from "vue-toastification";
const toast = useToast();
import { useRouter, useRoute } from 'vue-router'
import store from '@/store'
const login_form = <any>ref({
    email: 'ca_admin@gmail.com',
    password: 'Animal12!@'
});
const router = useRouter()
const rules = {
    login_form: {
        email: {
            required: helpers.withMessage('The Email field is required', required),
            email: helpers.withMessage('Please Enter a valid Email Address', email)
        },
        password: {
            required: helpers.withMessage('The Password field is required', required)
        }
    }
};
const vv = useVuelidate(rules, { login_form });

const submitLogin = () => {
    vv.value.login_form.$touch();
    if (vv.value.login_form.$invalid) return;
    let data = login_form.value;
    store.dispatch('auth/login' , data).then((response) => {
        if(response.data.status){
            router.push('/');
            toast.success('Login Successfully')
        }
    })
};
</script>

<template>
    <v-row class="d-flex mb-3">
        <v-col cols="12">
            <v-label class="font-weight-bold mb-1">Email ID</v-label>
            <v-text-field
                variant="outlined"
                v-model="vv.login_form.email.$model"
                :hide-details="vv?.login_form.email?.$errors[0] ? false : true"
                :error-messages="vv?.login_form.email?.$errors[0]?.$message || ''"
                color="primary"
            ></v-text-field>
        </v-col>
        <v-col cols="12">
            <v-label class="font-weight-bold mb-1">Password</v-label>
            <v-text-field
                variant="outlined"
                type="password"
                v-model="vv.login_form.password.$model"
                :hide-details="vv?.login_form.password?.$errors[0] ? false : true"
                :error-messages="vv?.login_form.password?.$errors[0]?.$message || ''"
                color="primary"
            ></v-text-field>
        </v-col>
        <v-col cols="12" class="pt-0">
            <div class="d-flex flex-wrap align-center ml-n2">
                <!-- <v-checkbox v-model="checkbox"  color="primary" hide-details>
                    <template v-slot:label class="text-body-1">Remeber this Device</template>
                </v-checkbox> -->
                <div class="ml-sm-auto">
                    <RouterLink to="/" class="text-primary text-decoration-none text-body-1 opacity-1 font-weight-medium"
                        >Forgot Password ?</RouterLink
                    >
                </div>
            </div>
        </v-col>
        <v-col cols="12" class="pt-0">
            <v-btn @click="submitLogin" color="primary" size="large" block flat>Sign in</v-btn>
        </v-col>
    </v-row>
</template>
