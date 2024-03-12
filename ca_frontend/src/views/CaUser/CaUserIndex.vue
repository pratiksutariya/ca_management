<script setup lang="ts">
import { ref } from 'vue';
import { required, helpers, email } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useToast } from 'vue-toastification';
import store from '@/store';
const toast = useToast();
const userDialog = ref<boolean>(false);
const passwordShow = ref<boolean>(false);
const user_form = ref<any>({
    user_id: null,
    name: '',
    email: '',
    password: ''
});

const rules = {
    user_form: {
        name: {
            required: helpers.withMessage('The Name field is required', required)
        },
        email: {
            required: helpers.withMessage('The Email field is required', required),
            email: helpers.withMessage('Please Enter a valid Email Address', email)
        },
        password: {
            required: helpers.withMessage('The Password field is required', required)
        }
    }
};
const vv = useVuelidate(rules, { user_form });
const openModel = () => {
    user_form.value = {
        user_id: null,
        name: '',
        email: '',
        password: ''
    };
    vv.value.user_form.$reset();
    userDialog.value = true;
};
const autogenaratePassword = () => {
    user_form.value.password = '';
    let password = Math.random().toString(36).slice(2, 10);
    user_form.value.password = password;
};

const submitForm = () => {
    vv.value.user_form.$touch();
    if (vv.value.user_form.$invalid) return;
    let data = user_form.value;
    store
        .dispatch('superadmin/addNewCA', data)
        .then((response) => {})
        .catch((error) => {});
};
</script>
<template>
    <v-row>
        <v-col cols="12" md="12">
            <v-card elevation="10" class="withbg">
                <v-card-title>
                    <v-row>
                        <v-col cols="6" class="pt-4"></v-col>
                        <v-col cols="6" class="text-right"><v-btn small color="primary" @click="openModel()">Add New CA</v-btn> </v-col>
                    </v-row>
                </v-card-title>
            </v-card>
        </v-col>
    </v-row>

    <!-- Dialog Modal -->
    <v-dialog v-model="userDialog" persistent width="600">
        <v-card>
            <v-card-title>
                <span class="text-h5">{{ user_form.user_id ? 'Edit CA Account' : 'Create New CA' }}</span>
            </v-card-title>
            <v-card-text>
                <v-container class="user_form_container">
                    <v-label class="font-weight-bold mb-2"
                        >Enter CA Name
                        <span class="text-error ml-1 text-h6"> * </span>
                    </v-label>
                    <v-text-field
                        variant="outlined"
                        v-model="vv.user_form.name.$model"
                        :hide-details="vv?.user_form.name?.$errors[0] ? false : true"
                        :error-messages="vv?.user_form.name?.$errors[0]?.$message || ''"
                        color="primary"
                        class="mb-5"
                    ></v-text-field>
                    <v-label class="font-weight-bold mb-2"
                        >Email ID
                        <span class="text-error ml-1 text-h6"> * </span>
                    </v-label>
                    <v-text-field
                        variant="outlined"
                        v-model="vv.user_form.email.$model"
                        :hide-details="vv?.user_form.email?.$errors[0] ? false : true"
                        :error-messages="vv?.user_form.email?.$errors[0]?.$message || ''"
                        :autocomplete="false"
                        color="primary"
                        class="mb-5"
                    ></v-text-field>
                    <v-label class="font-weight-bold mb-2"
                        >Password
                        <span class="text-error ml-1 text-h6"> * </span>
                    </v-label>
                    <v-text-field
                        variant="outlined"
                        :append-inner-icon="passwordShow ? 'mdi-eye' : 'mdi-eye-off'"
                        append-icon="mdi-lock-plus"
                        :type="passwordShow ? 'text' : 'password'"
                        color="primary"
                        :autocomplete="false"
                        v-model="vv.user_form.password.$model"
                        class="mb-5"
                        :hide-details="vv?.user_form.password?.$errors[0] ? false : true"
                        :error-messages="vv?.user_form.password?.$errors[0]?.$message || ''"
                        @click:append-inner="passwordShow = !passwordShow"
                        @click:append="autogenaratePassword"
                    ></v-text-field>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error" small variant="outlined" @click="userDialog = false"> Close </v-btn>
                <v-btn color="primary" small variant="outlined" @click="submitForm()">
                    {{ user_form.user_id ? 'Update CA' : 'Add New CA' }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
