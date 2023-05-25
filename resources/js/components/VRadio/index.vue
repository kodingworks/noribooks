<script setup>
import { string, bool, array } from 'vue-types'

const props = defineProps({
    label: string(),
    modelValue: string(),
    disabled: bool().def(false),
    errorMessage: string(),
    required: bool().def(false),
    name: string(),
    options: array().isRequired,
})

const emit = defineEmits(['update:modelValue'])
const updateValue = (event) => {
    emit('update:modelValue', event.target.value)
}
</script>

<template>
    <div>
        <label class="block text-sm font-medium text-slate-600 mb-1" :for="name" v-if="label">{{ label }} <span class="text-rose-500" v-if="required">*</span></label>
        <!-- Start -->
        <label class="flex items-center" v-for="(option, index) in options" :key="option.value+index" :for="option.value+index">
            <input type="radio" :name="name" class="form-radio cursor-pointer" @change="updateValue" :value="option.value" :id="option.value+index" :disabled="disabled" :checked="option.value == modelValue"/>
            <span class="text-sm ml-2">{{ option.label }}</span>
        </label>
        <!-- End -->
        <div 
            class="text-xs mt-1" 
            :class="[{
                'text-rose-500': errorMessage
            }]" 
            v-if="errorMessage"
        >
            {{ errorMessage }}
        </div>
    </div>
</template>
