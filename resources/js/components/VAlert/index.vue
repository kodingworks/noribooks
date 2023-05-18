<script setup>
import { bool, oneOf, string } from 'vue-types'
import VDialog from '@/components/VBlankDialog/index.vue';

const props = defineProps({
    openDialog: bool(),
    size: oneOf(['sm', 'md', 'lg', 'xl']).def('md'),
    type: oneOf(['danger', 'info']).def('info'),
    headerLabel: string(),
    contentLabel: string(),
    closeLabel: string().def('cancel'),
    submitLabel: string().def('submit'),
})

const emit = defineEmits(['submitAlert', 'closeAlert'])
</script>

<template>
    <VDialog :showModal="openDialog" :size="size">
        <template v-slot:content>
            <div class="text-center w-full">
                <!-- Icon -->
                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-rose-100 mx-auto" v-if="type === 'danger'">
                    <svg class="w-4 h-4 shrink-0 fill-current text-rose-500" viewBox="0 0 16 16">
                        <path
                            d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                    </svg>
                </div>
                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-indigo-100 mx-auto" v-else-if="type === 'info'">
                    <svg class="w-4 h-4 shrink-0 fill-current text-indigo-500" viewBox="0 0 16 16">
                        <path
                            d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm1 12H7V7h2v5zM8 6c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1z" />
                    </svg>
                </div>

                <!-- Modal header -->
                <div class="mb-2 mt-4">
                    <div class="text-lg font-semibold text-slate-800">{{ headerLabel }}</div>
                </div>
                <!-- Modal content -->
                <div class="text-sm mb-4">
                    <p>{{ contentLabel }}</p>
                </div>
                <!-- Modal footer -->
                <div class="flex flex-wrap justify-end space-x-2">
                    <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="$emit('closeAlert')"> {{
                        closeLabel
                        }} </button>
                    <button class="btn-sm bg-rose-500 hover:bg-rose-600 text-white" @click="$emit('submitAlert')"
                        v-if="type === 'danger'"> {{ submitLabel
                        }}</button>
                </div>
            </div>
        </template>
    </VDialog>
</template>