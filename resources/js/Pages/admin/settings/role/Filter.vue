<script setup>
import { ref } from "vue"
import { any } from "vue-types";
import VInput from '@/components/VInput/index.vue';

const searchValue = ref("")

const props = defineProps({
    additional: any()
})

const search = () => {
    emit('search', searchValue.value)
}

const emit = defineEmits(['search'])
</script>

<template>
    <!-- Search -->
    <VInput placeholder="Search by name" is-prefix v-model="searchValue" @update:model-value="search">
        <template v-slot:icon>
            <span class="absolute inset-y-0 left-0 flex items-center px-2 cursor-pointer">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.4375 9.375C7.61212 9.375 9.375 7.61212 9.375 5.4375C9.375 3.26288 7.61212 1.5 5.4375 1.5C3.26288 1.5 1.5 3.26288 1.5 5.4375C1.5 7.61212 3.26288 9.375 5.4375 9.375Z"
                        stroke="#8C8C8C" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8.22192 8.22168L10.5 10.4998" stroke="#8C8C8C" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </span>
        </template>
    </VInput>
</template>