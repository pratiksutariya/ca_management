<script setup lang="ts">
import { UserIcon, MailIcon, ListCheckIcon } from 'vue-tabler-icons';
import { useToast } from 'vue-toastification';
const toast = useToast();
import store from '@/store';
import { useRouter, useRoute } from 'vue-router';
const router = useRouter();
const logoutSubmit = () => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to log out!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Logout it!'
    }).then((result) => {
        if (result.isConfirmed) {
            store.dispatch('auth/logout').then((response) => {
                if (response.data.status) {
                    router.push('/login');
                    toast.success('Logout Successfully');
                    Swal.fire({
                        title: 'Logout!',
                        text: 'You are logged out.',
                        icon: 'success'
                    });
                }
            });
        }
    });
};
</script>

<template>
    <!-- ---------------------------------------------- -->
    <!-- notifications DD -->
    <!-- ---------------------------------------------- -->
    <v-menu :close-on-content-click="false">
        <template v-slot:activator="{ props }">
            <v-btn class="profileBtn custom-hover-primary" variant="text" v-bind="props" icon>
                <v-avatar size="35">
                    <img src="@/assets/images/users/avatar-1.jpg" height="35" alt="user" />
                </v-avatar>
            </v-btn>
        </template>
        <v-sheet rounded="md" width="200" elevation="10" class="mt-2">
            <v-list class="py-0" lines="one" density="compact">
                <v-list-item value="item1" active-color="primary">
                    <template v-slot:prepend>
                        <UserIcon stroke-width="1.5" size="20" />
                    </template>
                    <v-list-item-title class="pl-4 text-body-1">My Profile</v-list-item-title>
                </v-list-item>
                <v-list-item value="item2" active-color="primary">
                    <template v-slot:prepend>
                        <MailIcon stroke-width="1.5" size="20" />
                    </template>
                    <v-list-item-title class="pl-4 text-body-1">My Account</v-list-item-title>
                </v-list-item>
                <v-list-item value="item3" active-color="primary">
                    <template v-slot:prepend>
                        <ListCheckIcon stroke-width="1.5" size="20" />
                    </template>
                    <v-list-item-title class="pl-4 text-body-1">My Task</v-list-item-title>
                </v-list-item>
            </v-list>
            <div class="pt-4 pb-4 px-5 text-center">
                <v-btn @click="logoutSubmit" color="primary" variant="outlined" block>Logout</v-btn>
            </div>
        </v-sheet>
    </v-menu>
</template>
