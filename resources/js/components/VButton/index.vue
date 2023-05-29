<script setup>
import { string, oneOf, bool } from 'vue-types'
import VEdit from '@/components/src/icons/VEdit.vue'

// List Icon Used
const icons = {
    VEdit
}

const props = defineProps({
    label: string().def('Button'),
    size: oneOf(['extrasmall', 'small', 'medium', 'large']).def('medium'),
    isLoading: bool().def(false),
    disabled: bool().def(false),
    type: oneOf(['primary', 'danger', 'success', 'default', 'outline-primary']).def('primary'),
    icon: string().def('')
})

const emit = defineEmits(['click'])
</script>

<template>
    <div>
        <button 
            :class="[{
                'disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed shadow-none': isLoading | disabled,
                'btn-lg': size === 'large',
                'btn': size === 'medium',
                'btn-sm': size === 'small',
                'btn-xs': size === 'extrasmall',
                'bg-primary hover:bg-primary-hover text-white': type === 'primary',
                'bg-danger hover:bg-danger-hover text-white': type === 'danger',
                'bg-success hover:bg-success-hover text-white': type === 'success',
                'bg-white hover:text-tertiary-hover text-tertiary': type === 'default',
                'bg-white hover:bg-slate-200 text-blue-500': type === 'outline-primary',
            }]" 
            :disabled="isLoading | disabled" 
            @click.prevent="$emit('click')"
            type="submit"
        >
            <svg class="animate-spin w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16" v-if="isLoading">
                <path d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z" />
            </svg>
            <component :is="icons[icon]" v-if="icon"/>
            <span :class="[{ 'ml-2': isLoading || icon }]">{{ isLoading ? "Loading ..." : label }}</span>
        </button>
    </div>
</template>