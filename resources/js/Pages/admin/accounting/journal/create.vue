<script>
export default {
    layout: AppLayout,
};
</script>
<script setup>
import axios from "axios";
import dayjs from "dayjs";
import { notify } from "notiwind";
import { object, string } from "vue-types";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref, onMounted, reactive } from "vue";
import AppLayout from "@/layouts/apps.vue";
import debounce from "@/composables/debounce";
import VDropdownEditMenu from "@/components/VDropdownEditMenu/index.vue";
import VDataTable from "@/components/VDataTable/index.vue";
import VPagination from "@/components/VPagination/index.vue";
import VBreadcrumb from "@/components/VBreadcrumb/index.vue";
import VLoading from "@/components/VLoading/index.vue";
import VEmpty from "@/components/src/icons/VEmpty.vue";
import VButton from "@/components/VButton/index.vue";
import VInput from "@/components/VInput/index.vue";
import VAlert from "@/components/VAlert/index.vue";
import VBack from "@/components/src/icons/VBack.vue";
import VEdit from "@/components/src/icons/VEdit.vue";
import VTrash from "@/components/src/icons/VTrash.vue";
import VFilter from "./Filter.vue";
import VModalForm from "./ModalForm.vue";
import VSelect from "@/components/VSelect/index.vue";

const formError = ref({});
const query = ref([]);
const searchFilter = ref("");
const journalEntry = ref({ id: "" });
const stopDelete = ref(true);

const form = ref({
    date: "",
    description: "",
});

const journalEntries = ref([
    {
        account_id: "",
        description: "",
        debit: 0,
        credit: 0,
        total_debit: 0,
        total_credit: 0,
    },
]);

const pagination = ref({
    count: "",
    current_page: 1,
    per_page: "",
    total: 0,
    total_pages: 1,
});

const alertData = reactive({
    headerLabel: "",
    contentLabel: "",
    closeLabel: "",
    submitLabel: "",
});

const updateAction = ref(false);
const itemSelected = ref({});
const openAlert = ref(false);
const openModalForm = ref(false);
const isLoading = ref(true);
const backActive = ref(false);
const heads = ["Account", "Description", "Debit", "Credit"];

const props = defineProps({
    title: string(),
    additional: object(),
});

const handleDebitInput = () => {
    if (journalEntries.value.credit !== "") {
        journalEntries.value.credit = "";
    }
};

const handleCreditInput = () => {
    if (journalEntries.value.debit !== "") {
        journalEntries.value.debit = "";
    }
};

const handleAddAnotherJournal = () => {
    stopDelete.value = false;
    journalEntries.value.push({
        account_id: "",
        description: "",
        debit: 0,
        credit: 0,
        total_debit: 0,
        total_credit: 0,
    });
};

const closeAlert = () => {
    itemSelected.value = ref({});
    openAlert.value = false;
};

const handleDate = () => {
    if (form.value.date) {
        formError.value.date = "";
        form.value.date = dayjs(form.value.date).format("YYYY-MM-DD");
    }
};

const handleDeleteJournal = (index) => {
    journalEntries.value.splice(index, 1);
    journalEntries.value.length <= 1
        ? (stopDelete.value = true)
        : (stopDelete.value = false);
};

const deleteHandle = async () => {
    axios
        .delete(
            route("accounting.journal.delete", {
                id: itemSelected.value.id,
            })
        )
        .then((res) => {
            notify(
                {
                    type: "success",
                    group: "top",
                    text: res.data.meta.message,
                },
                2500
            );
            openAlert.value = false;
            isLoading.value = true;
            getData(pagination.value.current_page);
        })
        .catch((res) => {
            notify(
                {
                    type: "error",
                    group: "top",
                    text: res.response.data.message,
                },
                2500
            );
        });
};

const submit = () => {
    let total_debit = 0;
    let total_credit = 0;
    journalEntries.value.map((journal) => {
        (total_debit += journal.total_debit),
            (total_credit += journal.total_credit);
    });
    const data = {
        account_id: +form.account,
        journal_entries: journalEntries.value,
        total_debit: total_debit,
        total_credit: total_credit,
    };

    console.log(data);
    axios
        .post(route("accounting.journal.store"), data)
        .then((res) => {
            form.reset();
            journalEntries.value = [
                {
                    account_id: "",
                    description: "",
                    debit: 0,
                    credit: 0,
                    total_debit: 0,
                    total_credit: 0,
                },
            ];
            notify(
                {
                    type: "success",
                    group: "top",
                    text: res.data.message,
                },
                2500
            );
        })
        .catch((res) => {
            console.log(res.response.data);
            notify(
                {
                    type: "error",
                    group: "top",
                    text: res.response.data.meta,
                },
                2500
            );
        });
};
</script>

<template>
    <Head :title="props.title" />
    <div class="mb-4 sm:mb-6 flex justify-between items-center">
        <div class="flex items-center">
            <Link
                :href="route('accounting.journal.index')"
                class="cursor-pointer"
            >
                <VBack
                    width="32"
                    height="32"
                    :is-active="backActive"
                    @mouseover="backActive = true"
                    @mouseout="backActive = false"
                />
            </Link>
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                Journal Entry
            </h1>
        </div>
    </div>
    <div
        class="bg-white shadow-lg rounded-sm border border-slate-200"
        :class="isLoading && 'min-h-[40vh] sm:min-h-[50vh]'"
    >
        <section class="px-10 py-6 flex gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">
                    Date<span class="text-rose-500"></span>
                </label>
                <Datepicker
                    v-model="form.date"
                    @update:modelValue="handleDate"
                    :enableTimePicker="false"
                    position="left"
                    :clearable="false"
                    format="dd MMMM yyyy"
                    previewFormat="dd MMMM yyyy"
                    placeholder="Date"
                />
            </div>
            <VInput
                placeholder="Description"
                label="Description"
                v-model="form.description"
                :errorMessage="formError.description"
                @update:modelValue="formError.description = ''"
            />
            <!-- <VInput
                placeholder="Amount"
                label="Amount"
                v-model="form.amount"
                :errorMessage="formError.amount"
                @update:modelValue="formError.amount = ''"
            /> -->
        </section>
        <section class="px-7">
            <VDataTable :heads="heads">
                <tr v-for="(journal, index) in journalEntries" :key="index">
                    <td class="w-1/3">
                        <VSelect
                            placeholder="Choose Account"
                            v-model="journalEntries[index].account_id"
                            :options="additional.account_list"
                            :errorMessage="formError.account_id"
                            @update:modelValue="formError.account_id = ''"
                            class="w-full"
                        />
                    </td>
                    <td class="w-1/3">
                        <VInput
                            placeholder="Description"
                            v-model="journalEntries[index].description"
                            :errorMessage="formError.description"
                            @update:modelValue="formError.description = ''"
                        />
                    </td>
                    <td>
                        <VInput
                            v-model="journalEntries[index].debit"
                            :errorMessage="formError.debit"
                            @input="handleDebitInput"
                            @update:modelValue="formError.debit = ''"
                        />
                    </td>
                    <td>
                        <VInput
                            v-model="journalEntries[index].credit"
                            :errorMessage="formError.credit"
                            @input="handleCreditInput"
                            @update:modelValue="formError.credit = ''"
                        />
                    </td>
                    <td class="cursor-pointer whitespace-nowrap text-right">
                        <div
                            class="flex justify-between items-center space-x-2 p-3"
                            @click="handleDeleteJournal(index)"
                        >
                            <span>
                                <VTrash color="danger" />
                            </span>
                        </div>
                    </td>
                    <!-- <VSelect
                            placeholder="Account Name"
                            label="Select Account Name"
                            :required="true"
                            v-model="journalEntries[index].account_id"
                            :options="additional.account_list"
                            /> -->
                </tr>
            </VDataTable>
            <div class="py-5 px-3">
                <VButton
                    label="Add line"
                    type="primary"
                    @click="handleAddAnotherJournal"
                    class="mt-auto"
                />
            </div>
        </section>
        <footer>
            <div class="flex flex-col px-6 py-3 border-slate-200">
                <div class="flex self-end space-x-3">
                    <!-- <VButton
                        :is-loading="isLoading"
                        label="Discard"
                        type="default"
                        @click="discard"
                    /> -->
                    <VButton label="Save" type="primary" @click="submit" />
                </div>
            </div>
        </footer>
    </div>
</template>
