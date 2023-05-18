<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import VHamburgerHalf from "@/components/src/icons/VHamburgerHalf.vue";
import VHamburgerFull from "@/components/src/icons/VHamburgerFull.vue";
import VDashboard from "@/components/src/icons/VDashboard.vue";
import VTag from "@/components/src/icons/VTag.vue";
import VProduct from "@/components/src/icons/VProduct.vue";
import VSetting from "@/components/src/icons/VSetting.vue";
import VTransaction from "@/components/src/icons/VTransaction.vue";
import VBook from "@/components/src/icons/VBook.vue";
import { array, bool } from "vue-types";
import VSidebarGroup from "@/components/VSidebarGroup/index.vue";
import { usePage } from "@inertiajs/inertia-vue3";

const icons = {
    VDashboard,
    VSetting,
    VTag,
    VProduct,
    VTransaction,
    VBook
}
const props = defineProps({
    sidebarOpen: bool().def(false),
    module: array().isRequired
})
const emit = defineEmits(['close-sidebar'])
const trigger = ref(null);
const sidebar = ref(null);

const sidebarExpanded = ref(false);
const sidebarGroupExpanded = ref(false);
const clickHandler = ({ target }) => {
    if (!sidebar.value || !trigger.value) return;
    if (!props.sidebarOpen || sidebar.value.contains(target) || trigger.value.contains(target))
        return;
    emit("close-sidebar");
}

// close if the esc key is pressed
const keyHandler = ({ keyCode }) => {
    if (!props.sidebarOpen || keyCode !== 27) return;
    emit("close-sidebar");
};
const getUrlPathName = (route) => {
    return new URL(route).pathname;
};
onMounted(() => {
    document.addEventListener("click", clickHandler);
    document.addEventListener("keydown", keyHandler);
    const storedSidebarExpanded = localStorage.getItem("sidebar-expanded");
    sidebarExpanded.value = storedSidebarExpanded === null ? false : storedSidebarExpanded === "true";
});
onUnmounted(() => {
    document.removeEventListener("click", clickHandler);
    document.removeEventListener("keydown", keyHandler);
});
watch(sidebarExpanded, () => {
    localStorage.setItem("sidebar-expanded", sidebarExpanded.value);
    if (sidebarExpanded.value) {
        document.querySelector("body").classList.add("sidebar-expanded");
    } else {
        document.querySelector("body").classList.remove("sidebar-expanded");
    }
});
</script>

<template>
    <div>
        <!-- Sidebar backdrop (mobile only) -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" />
        <!-- Sidebar -->
        <div id="sidebar" ref="sidebar"
            class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 transform h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-60 lg:w-[72px] lg:sidebar-expanded:!w-60 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'">
            <!-- Sidebar header -->
            <div class="mb-4 w-full">
                <!-- Close button -->
                <div class="flex w-full sidebar-expanded:justify-between justify-end">
                    <Link :class="sidebarExpanded ?  'block' : 'hidden'" class="pl-2 transition-all duration-200" href="/">
                        <div class="flex justify-start w-full">
                            <img class="w-8 h-8 rounded-full" src="/img/laravel-icon.svg" alt="Logo" />
                            <div class="ml-2 my-auto text-white font-bold text-lg">POS</div>
                        </div>
                    </Link>
                    <div @click.prevent="sidebarExpanded = !sidebarExpanded" :class="!sidebarExpanded ? 'mx-1' : ''"
                        class="cursor-pointer hidden lg:block lg:justify-end transition-all duration-200">
                        <VHamburgerHalf v-if="sidebarExpanded" />
                        <VHamburgerFull v-else />
                    </div>
                    <div class="cursor-pointer lg:hidden" ref="trigger" @click.stop="$emit('close-sidebar')">
                        <VHamburgerHalf />
                    </div>
                </div>
            </div>
            <!-- Links -->
            <div class="space-y-8">
                <div>
                    <ul class="mt-[18px]">
                        <div v-for="(route, index) in module" :key="index">
                            <Link :href="route.url" v-if="!route.group" @click="sidebarGroupExpanded = false">
                            <li class="rounded mb-[18px] last:mb-0"
                                :class="$page.url.split('/')[2] === getUrlPathName(route.url).split('/')[2] && 'bg-slate-900'">
                                <a
                                    class="block rounded text-slate-200 hover:text-white truncate transition duration-150 p-2">
                                    <div class="flex items-center justify-between">
                                        <div class="grow flex items-center">
                                            <component :is="icons[route.icon]"
                                                :isActive="$page.url.split('/')[2] === getUrlPathName(route.url).split('/')[2]">
                                            </component>
                                            <span
                                                class="text-sm font-medium ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 duration-200">{{
                                                route.text }}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            </Link>
                            <VSidebarGroup v-else ref="sideBar" v-slot="parentLink"
                                :activeCondition="$page.url.split('/')[2] === getUrlPathName(route.submenu[0].url).split('/')[2]"
                                class="cursor-pointer">
                                <a class="block text-slate-200 hover:text-white truncate transition duration-150 p-2"
                                    :class="$page.url.split('/')[2] === getUrlPathName(route.submenu[0].url).split('/')[2] && 'hover:text-slate-200'"
                                    @click.prevent="parentLink.handleClick()">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <component :is="icons[route.icon]"
                                                :isActive="$page.url.split('/')[2] === getUrlPathName(route.submenu[0].url).split('/')[2]">
                                            </component>
                                            <span
                                                class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ route.text }}</span>
                                        </div>
                                        <!-- Icon -->
                                        <div class="flex shrink-0 ml-2">
                                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                                :class="parentLink.expanded && 'transform rotate-180'"
                                                viewBox="0 0 12 12">
                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                                <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                    <ul class="pl-9" :class="!parentLink.expanded && 'hidden'">
                                        <div v-for="(item, index) in route.submenu" :key="index" class="last:pb-2">
                                            <Link :href="item.url">
                                            <li>
                                                <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                                    :class="($page.url.split('/')[3] === getUrlPathName(item.url).split('/')[3] && $page.url.split('/')[2] === getUrlPathName(route.submenu[0].url).split('/')[2]) && '!text-blue-500'">
                                                    <span
                                                        class="text-sm font-medium ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{
                                                        item.text }}</span>
                                                </a>
                                            </li>
                                            </Link>
                                        </div>
                                    </ul>
                                </div>
                            </VSidebarGroup>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>