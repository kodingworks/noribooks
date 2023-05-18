<style scoped>
    .medium{
        --ms-py: 7px;
        --ms-font-size: 0.875rem;
        --ms-option-font-size: 0.875rem;
    }

    .danger{
        --ms-border-color: rgb(244 63 94)
    }
</style>

<script setup>
import axios from "axios";
import { ref } from "vue";
import { string, oneOf, bool, object, any } from 'vue-types'
import { useModelWrapper } from '@/composables/modelWrapper'
import Multiselect from '@vueform/multiselect'

const props = defineProps({
    size: oneOf(['sm', 'md', 'lg']).def('md'),
    label: string(),
    modelValue: any(),
    placeholder: string().isRequired.def('Input ...'),
    type: oneOf(['async-tags', 'tags', 'select', 'multiple', 'async-single']).def('select'),
    errorMessage: string(),
    successMessage: string(),
    required: bool().def(false),
    optionRoute: string(),
    options: any(),
    disabled: bool().def(false),
    clearable: bool().def(true),
    defaultValue: object().def({})
})

const multiselect = ref();

const getAsyncOptions = async (query) => {
    let result = await axios.get(props.optionRoute, {
        params: {
            search: query
        }
    })

    return result.data
};

const clearSelected = () => {
    multiselect.value.clear()
}

const value = useModelWrapper(props, emit, 'modelValue')
const emit = defineEmits(['update:modelValue'])
defineExpose({
    clearSelected,
});
</script>

<template>
    <div>
        <label class="block text-sm font-medium text-slate-600 mb-1" :for="placeholder" v-if="label">{{ label }} <span class="text-rose-500" v-if="required">*</span></label>

        <!-- Select Type -->
        <Multiselect v-if="type === 'select'" v-model="value" v-bind="{ value: value, options: options }" :options="options" :searchable="true" ref="multiselect" :canClear="clearable" :canDeselect="clearable" :placeholder="placeholder" :disabled="disabled" :class="{
            'medium' : size === 'md',
            'danger': errorMessage
        }"/>

        <!-- Multiple Type -->
        <Multiselect v-if="type === 'multiple'" v-model="value" :options="options" ref="multiselect" mode="multiple" :placeholder="placeholder" :close-on-select="false" :disabled="disabled" :class="{
            'medium' : size === 'md',
            'danger': errorMessage
        }"/>

        <!-- Tags Type -->
        <Multiselect v-if="type === 'tags'" v-model="value" :disabled="disabled" :class="{
            'medium' : size === 'md',
            'danger': errorMessage
        }" mode="tags" :placeholder="placeholder" :close-on-select="true" :searchable="true" :create-option="false" :options="options" :infinite="true" :limit="3" ref="multiselect"/>

        <!-- Async Tags Type -->
        <Multiselect v-if="type === 'async-tags'" v-model="value" mode="tags" :placeholder="placeholder"
            :class="{
                'medium' : size === 'md',
                'danger': errorMessage
            }" :close-on-select="true" :filter-results="false" :min-chars="1" :resolve-on-load="false" :clear-on-search="true"
            :delay="500" :searchable="true" :options="getAsyncOptions" :disabled="disabled" ref="multiselect"/>

        <!-- Async Single Type -->
        <Multiselect v-if="type === 'async-single'" v-model="value" :placeholder="placeholder" :class="{
            'medium' : size === 'md',
            'danger': errorMessage
        }" :close-on-select="true" :filter-results="false" :min-chars="1" :resolve-on-load="false" :object="true"
            :clear-on-search="true" :delay="500" :searchable="true" :options="getAsyncOptions" :disabled="disabled"
            ref="multiselect"/>
            
            <div class="text-xs mt-1" :class="[{
            'text-rose-500': errorMessage,
            'text-emerald-500': successMessage
        }]" v-if="errorMessage || successMessage">
            {{ errorMessage || successMessage }}
        </div>
    </div>
</template>
