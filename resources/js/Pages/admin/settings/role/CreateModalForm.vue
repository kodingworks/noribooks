<script setup>
import { ref } from "vue";
import { bool, object } from "vue-types";
import VDialog from '@/components/VDialog/index.vue';
import VButton from '@/components/VButton/index.vue';

const props = defineProps({
    openDialog: bool(),
    data: object().def({}),
    additional: object().def({})
})

const emit = defineEmits(['close', 'successSubmit'])

const previousForm = ref({})
const form = ref({})
const title = ref('')

const openForm = () => {
    form.value = JSON.parse(JSON.stringify(props.additional))
    previousForm.value = JSON.parse(JSON.stringify(props.additional))
    transformTitle(props.data[0]['sub_group'])
}

const resetForm = () => {
    form.value = JSON.parse(JSON.stringify(previousForm.value))
}

const cek = (subGroup) => {
    let permission = form.value.permissions.find(e => e.id === subGroup.id)
    permission.status = !permission.status
}

const handleClose = () => {
    resetForm()
    emit('close')
}

const transformTitle = (data) => {
    const sub_group = data.replace(/_/g, ' ')
    let words = sub_group.split(" ")
    for (let i = 0; i < words.length; i++) {
        words[i] = words[i][0].toUpperCase() + words[i].substr(1);
    }
    const newWords = words.join(" ").replace(/,/g, ' ')
    title.value = newWords
}
</script>

<template>
    <VDialog :showModal="openDialog" :title="'Manage ' + title + ' Permission'" @opened="openForm" size="xl">
        <template v-slot:close>
            <button class="text-slate-400 hover:text-slate-500" @click="handleClose">
                <div class="sr-only">Close</div>
                <svg class="w-4 h-4 fill-current">
                    <path
                        d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                </svg>
            </button>
        </template>
        <template v-slot:content>
            <div class="w-full flex justify-between my-4 " v-for="(subGroup, index) in data" :key="index">
                <div class="max-w-[60%]">
                    <p class="text-base text-slate-800 font-semibold">{{ subGroup.label }}</p>
                    <p class="text-sm text-slate-400 font-normal">{{ subGroup.label }}</p>
                </div>
                <div class="flex my-auto">
                    <div class="text-sm font-normal text-slate-400 italic mr-2">Active</div>
                    <div class="form-switch">
                        <input type="checkbox" :id="subGroup.group + '_' + index" class="sr-only" @change="cek(subGroup)"
                            :checked="form.permissions.find(x => x.id === subGroup.id).status" />
                        <label class="bg-slate-400" :for="subGroup.group + '_' + index">
                            <span class="bg-white shadow-sm" aria-hidden="true"></span>
                            <span class="sr-only">Enable smart sync</span>
                        </label>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:footer>
            <div class="flex flex-wrap justify-end space-x-2">
                <VButton label="Discard" type="default" @click="resetForm" />
                <VButton label="Save" type="primary" @click="$emit('successSubmit', form)" />
            </div>
        </template>
    </VDialog>
</template>

<style>
.dp__select {
    color: #4F8CF6 !important;
}

.date_error {
    --dp-border-color: #dc3545 !important;
}
</style>