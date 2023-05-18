<script>
import AuthLayout from "@/layouts/auth.vue"
export default {
    layout: AuthLayout,
}
</script>
<script setup>
import axios from "axios";
import { string } from "vue-types";
import { notify } from "notiwind";
import { ref, reactive } from "vue";
import VInput from "@/components/VInput/index.vue";
import VButton from "@/components/VButton/index.vue";
import { Head } from "@inertiajs/inertia-vue3";

const show = ref(false);
const form = reactive({});
const isLoading = ref(false)
const login = async () => {
    isLoading.value = true
    axios.post(route('login'), form).then((res) => {
        window.location.reload()
    }).catch((res) => {
        notify({
            type: "error",
            group: "top",
            text: res.response.data.message
        }, 2500)
    }).finally(() => isLoading.value = false)
};

const props = defineProps({
    title: string()
})
</script>

<template>
    <Head :title="title"></Head>
    <div class="min-h-screen h-full flex flex-col after:flex-1">
        <div class="flex-1" />
        <div class="max-w-sm p-8 w-full border rounded-md shadow-md">
            <h1 class="text-3xl text-slate-800 font-bold mb-6">
                Log in to start your Session
            </h1>
            <form>
                <div class="space-y-4">
                    <VInput type="email" placeholder="Email Address" label="Email Address" v-model="form.email"/>
                    <VInput :type="show ? 'text' : 'password'" placeholder="Password" label="Password" v-model="form.password">
                        <template v-slot:icon>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-2 cursor-pointer" @click="show = !show">
                                <svg v-if="!show" width="24" height="24" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.5 7L10 15.25" stroke="#475569" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7.51074 12.5123C7.16664 12.8275 6.71645 13.0016 6.2498 12.9998C5.87136 12.9998 5.50179 12.8852 5.18968 12.6712C4.87756 12.4572 4.63751 12.1537 4.50108 11.8008C4.36465 11.4478 4.33823 11.0617 4.42529 10.6935C4.51235 10.3252 4.70882 9.99185 4.98886 9.7373" stroke="#475569" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3.71875 8.34082C1.80625 9.30645 1 11.1252 1 11.1252C1 11.1252 2.5 14.5002 6.25 14.5002C7.12871 14.5074 7.99645 14.3049 8.78125 13.9096" stroke="#475569" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.0277 13.0516C11.0496 12.1375 11.4996 11.125 11.4996 11.125C11.4996 11.125 9.99961 7.75001 6.24961 7.75001C5.92451 7.74937 5.59993 7.77603 5.2793 7.8297" stroke="#475569" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.60156 9.2832C7.0003 9.35875 7.36365 9.56195 7.63677 9.86213C7.90989 10.1623 8.07797 10.5432 8.11563 10.9473" stroke="#475569" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg v-else width="24" height="24" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 7.625C2.25 7.625 0.75 11 0.75 11C0.75 11 2.25 14.375 6 14.375C9.75 14.375 11.25 11 11.25 11C11.25 11 9.75 7.625 6 7.625Z" stroke="#475569" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6 12.875C7.03553 12.875 7.875 12.0355 7.875 11C7.875 9.96447 7.03553 9.125 6 9.125C4.96447 9.125 4.125 9.96447 4.125 11C4.125 12.0355 4.96447 12.875 6 12.875Z" stroke="#475569" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </template>
                    </VInput>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <VButton :is-loading="isLoading" @click="login" label="Log In" />
                </div>
            </form>
        </div>
    </div>
</template>
