<script setup>
import { watch } from 'vue';
import { bool, string, oneOf } from 'vue-types'

const props = defineProps({
    size: oneOf(['sm', 'md', 'lg', 'xl']).def('md'),
    showModal: bool().def(false).isRequired,
    id: string().def("scrollbar-modal"),
    wrapperClass: string(),
    mobile: bool().def(false)
})

const emit = defineEmits(['opened', 'closed']);

watch(() => props.showModal, (newValue, oldValue) => {
    if (newValue) {
        emit('opened')
    } else {
        emit('closed')
    }
});
</script>

<template>
    <div>
        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition ease-out duration-100"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-show="showModal" class="fixed inset-0 bg-slate-900 bg-opacity-30 z-30 transition-opacity"
                aria-hidden="true"></div>
        </transition>
        <transition enter-active-class="transition ease-in-out duration-200" enter-from-class="opacity-0 translate-y-4"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in-out duration-200"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-4">
            <div v-show="showModal" :id="id"
                class="fixed inset-0 z-30 flex items-center my-4 justify-center transform px-4 sm:px-6 overflow-y-scroll  no-scrollbar"
                role="dialog" aria-modal="true" :class="wrapperClass">
                <div ref="modalContent" class="bg-white rounded shadow-lg w-full max-h-full no-scrollbar overflow-auto"
                    :class="{
                        'max-w-[438px]': mobile,
                        'max-w-sm': size === 'sm',
                        'max-w-md': size === 'md',
                        'max-w-lg': size === 'lg',
                        'max-w-xl': size === 'xl',
                        'max-w-5xl': size === '5xl',
                    }">
                    <div class="px-5 py-4">
                        <slot name="content" />
                    </div>
                    <div class="px-5">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
