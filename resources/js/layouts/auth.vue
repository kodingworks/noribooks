<script setup>
import VNotification from "@/components/VNotification/Index.vue";
</script>

<template>
    <VNotification></VNotification>
    <main class="bg-white">
        <!-- Content -->
        <div class="w-full flex justify-center">
            <slot />
        </div>
    </main>
</template>

