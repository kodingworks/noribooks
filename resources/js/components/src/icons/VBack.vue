<script setup>
import { bool, string } from 'vue-types'

const props = defineProps({
    isActive: bool().def(false),
    width: string().def("20"),
    height: string().def("20")
})
</script>

<template>
    <svg :width="width" :height="height" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path class="stroke-black" :class="isActive && '!stroke-blue-500'"
            d="M16.6 19.4L13 15.8L16.6 12.2M5 15.8C5 14.3817 5.27935 12.9773 5.8221 11.667C6.36486 10.3567 7.16037 9.16612 8.16325 8.16325C9.16612 7.16037 10.3567 6.36486 11.667 5.8221C12.9773 5.27935 14.3817 5 15.8 5C17.2183 5 18.6226 5.27935 19.933 5.8221C21.2433 6.36486 22.4338 7.16037 23.4368 8.16325C24.4396 9.16612 25.2351 10.3567 25.7779 11.667C26.3206 12.9773 26.6 14.3817 26.6 15.8C26.6 18.6643 25.4622 21.4113 23.4368 23.4368C21.4113 25.4622 18.6643 26.6 15.8 26.6C12.9357 26.6 10.1886 25.4622 8.16325 23.4368C6.13785 21.4113 5 18.6643 5 15.8Z"
            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</template>
