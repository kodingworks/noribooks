<script setup>
import { string, oneOf, bool, any } from 'vue-types'

const props = defineProps({
    label: string(),
    modelValue: any(),
    placeholder: string().isRequired.def('Input ...'),
    type: oneOf(['text', 'email', 'number', 'password']).def('text'),
    disabled: bool().def(false),
    errorMessage: string(),
    successMessage: string(),
    isPrefix: bool().def(false),
    required: bool().def(false)
})
const emit = defineEmits(['update:modelValue'])
const updateValue = (event) => {
    emit('update:modelValue', event.target.value)
}

</script>

<template>
    <div>
        <div class="mb-1" v-if="label">
            <label class="block text-sm font-medium text-slate-600" :for="placeholder" v-if="label">{{ label }} <span class="text-rose-500" v-if="required">*</span> </label>
        </div>
        <div class="relative">
            <slot name="icon" />
            <input 
                :id="placeholder" 
                :class="[{ 
                    'border-danger hover:border-danger-hover focus:border-danger': errorMessage, 
                    'border-slate-200 hover:border-slate-300 focus:border-primary': !errorMessage && !successMessage,
                    'border-success hover:border-success-hover focus:border-success': successMessage,
                    'disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed': disabled,
                    'pl-7': isPrefix,
                }]" 
                class="leading-5 shadow-sm placeholder-slate-400 rounded text-sm text-slate-800 bg-white border w-full focus:ring-0" 
                :type="type" 
                :placeholder="placeholder" 
                :autocomplete="'new-'+type" 
                :disabled="disabled"
                @input="updateValue"
                :value="modelValue"
            />
        </div>
        <div 
            class="text-xs mt-1" 
            :class="[{
                'text-rose-500': errorMessage,
                'text-emerald-500': successMessage
            }]" 
            v-if="errorMessage || successMessage"
        >
            {{ errorMessage || successMessage }}
        </div>
    </div>
</template>
