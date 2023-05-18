
<style scoped>
.loading {
    animation: App-logo-spin infinite 1.5s linear;
}

@keyframes App-logo-spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}
</style>

<template>
    <svg width="48" height="48" viewBox="0 0 124 124" fill="none" xmlns="http://www.w3.org/2000/svg"
        class="loading w-full flex justify-center">
        <circle cx="9.5" cy="48.5" r="7.5" fill="#4F8CF6" fill-opacity="0.1" />
        <circle cx="24" cy="22" r="8" fill="#4F8CF6" fill-opacity="0.2" />
        <circle cx="50.5" cy="8.5" r="8.5" fill="#4F8CF6" fill-opacity="0.4" />
        <circle cx="86" cy="15" r="11" fill="#4F8CF6" fill-opacity="0.6" />
        <circle cx="109" cy="49" r="12" fill="#4F8CF6" fill-opacity="0.75" />
        <circle cx="99.5" cy="91.5" r="13.5" fill="#4F8CF6" fill-opacity="0.85" />
        <circle cx="58.5" cy="108.5" r="15.5" fill="#4F8CF6" />
    </svg>
</template>
