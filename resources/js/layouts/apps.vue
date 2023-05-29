<script setup>
import axios from "axios";
import { ref, computed } from "vue";
import { notify } from "notiwind";
import { array } from "vue-types";
import { usePage } from "@inertiajs/inertia-vue3";
import VSidebar from "@/components/VSidebar/index.vue";
import VHeader from "@/components/VHeader/index.vue";
import VNotification from "@/components/VNotification/Index.vue";

const sidebarOpen = ref(true);
const user = computed(() => usePage().props.value.admin_data)
const userRole = computed(() => usePage().props.value.admin_role)

const logoutSubmit = async () => {
    axios.post(route('logout')).then((res) => {
        window.location.reload()
    }).catch((res) => {
        notify({
            type: "error",
            group: "top",
            text: res.response.data.message
        }, 2500)
    })
};

const props = defineProps({
    modules: array()
})

</script>

<template>
    <VNotification></VNotification>
    <div class="flex h-screen overflow-hidden font-inter">
        <VSidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" :module="modules" />
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <VHeader :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" @logout="logoutSubmit" :user="user" :userRole="userRole"/>
            <main>
                <div class="px-4 sm:px-6 lg:px-12 pt-8 pb-6 bg-slate-100 w-full mx-auto min-h-[calc(100vh-64px)]">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>