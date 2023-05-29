<script setup>
import UserMenu from '@/components/VDropdownProfile/index.vue'
import { bool, object, array } from 'vue-types';

const props = defineProps({
    sidebarOpen: bool(),
    user: object().def({}),
    userRole: array().def([])
})
</script>

<template>
    <header class="sticky top-0 bg-white shadow-[0_0px_2px_2px_rgba(0,0,0,0.04)] z-30">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 -mb-px">
                <!-- Header: Left side -->
                <div class="flex items-center">
                    <!-- Hamburger button -->
                    <button class="text-slate-500 hover:text-slate-600 lg:hidden" @click.stop="$emit('toggle-sidebar')" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="5" width="16" height="2" />
                            <rect x="4" y="11" width="16" height="2" />
                            <rect x="4" y="17" width="16" height="2" />
                        </svg>
                    </button>
                    <!-- <SearchForm /> -->
                </div>
                <div class="flex items-center space-x-2 w-[151px] h-[32px]">
                    <UserMenu align="left" @logout-click="$emit('logout')" :user="user" :userRole="userRole"/>
                </div>
            </div>
        </div>
    </header>
</template>