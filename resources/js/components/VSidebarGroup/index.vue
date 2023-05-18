<script setup>
import { ref, watch } from "vue";
import { bool } from "vue-types";

const props = defineProps({
    activeCondition: bool().def(false)
})
const expanded = ref(props.activeCondition);
const handleClick = () => {
    expanded.value = !expanded.value;
};

watch(() => props.activeCondition, (first, second) => {
    expanded.value = first
});
</script>

<template>
    <li class="rounded mb-[18px] last:mb-0" :class="activeCondition && 'bg-slate-900'">
        <slot :handleClick="handleClick" :expanded="expanded" />
    </li>
</template>

