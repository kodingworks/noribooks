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
import { Head } from "@inertiajs/inertia-vue3";
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
import VEdit from "@/components/src/icons/VEdit.vue";
import VTrash from "@/components/src/icons/VTrash.vue";
import VFilter from "./Filter.vue";
import VModalForm from "./ModalForm.vue";

// const props = defineProps({
//     openDialog: bool(),
//     updateAction: bool().def(false),
//     data: object().def({}),
//     additional: object().def({}),
// });

// const isLoading = ref(false);
const formError = ref({});
const form = ref({});
const query = ref([]);
const searchFilter = ref("");
const filter = ref({});

const breadcrumb = [
    {
        name: "Dashboard",
        active: false,
        to: route("dashboard.index"),
    },
    {
        name: "Accounting",
        active: true,
        to: route("accounting.journal.index"),
    },
    {
        name: "Journal",
        active: true,
        to: route("accounting.journal.index"),
    },
    {
        name: "Journal Entry",
        active: true,
        to: route("accounting.journal.createPage"),
    },
];

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
const heads = ["Date", "Description", "Amount", ""];
const isLoading = ref(true);

const props = defineProps({
    title: string(),
    additional: object(),
});

const getData = debounce(async (page) => {
    axios
        .get(route("accounting.journal.getdata"), {
            params: {
                page: page,
                search: searchFilter.value,
                // filter_journal: filter.value.filter_journal,
            },
        })
        .then((res) => {
            query.value = res.data.data;
            pagination.value = res.data.meta.pagination;
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
        })
        .finally(() => (isLoading.value = false));
}, 500);

const nextPaginate = () => {
    pagination.value.current_page += 1;
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const previousPaginate = () => {
    pagination.value.current_page -= 1;
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const searchHandle = (search) => {
    searchFilter.value = search;
    isLoading.value = true;
    getData(1);
};

const applyFilter = (data) => {
    filter.value = data;
    isLoading.value = true;
    getData(1);
};

const clearFilter = (data) => {
    filter.value = data;
    isLoading.value = true;
    getData(1);
};

const handleAddModalForm = () => {
    updateAction.value = false;
    openModalForm.value = true;
};

const handleEditModal = (data) => {
    updateAction.value = true;
    itemSelected.value = data;
    openModalForm.value = true;
};

const successSubmit = () => {
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const closeModalForm = () => {
    itemSelected.value = ref({});
    openModalForm.value = false;
};

const alertDelete = (data) => {
    itemSelected.value = data;
    openAlert.value = true;
    alertData.headerLabel = "Are you sure to delete this?";
    alertData.contentLabel = "You won't be able to revert this!";
    alertData.closeLabel = "Cancel";
    alertData.submitLabel = "Delete";
};

const closeAlert = () => {
    itemSelected.value = ref({});
    openAlert.value = false;
};

const handleDate = () => {
    if (form.value.date) {
        formError.value.date = "";
        // form.value.date = dayjs(form.value.date).format("YYYY-MM-DD");
    }
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

onMounted(() => {
    getData(1);
});
</script>

<template>
    <Head :title="props.title" />
    <div class="mb-4 sm:mb-6 flex justify-between items-center">
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
            Journal Entry
        </h1>
    </div>
    <div
        class="bg-white shadow-lg rounded-sm border border-slate-200"
        :class="isLoading && 'min-h-[40vh] sm:min-h-[50vh]'"
    >
        <div class="p-10 flex gap-4">
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
                    :class="{ date_error: formError.date }"
                />
            </div>
            <VInput
                placeholder="Description"
                label="Description"
                :required="true"
                v-model="form.description"
                :errorMessage="formError.description"
                @update:modelValue="formError.description = ''"
            />
        </div>
    </div>
    <VAlert
        :open-dialog="openAlert"
        @closeAlert="closeAlert"
        @submitAlert="deleteHandle"
        type="danger"
        :headerLabel="alertData.headerLabel"
        :content-label="alertData.contentLabel"
        :close-label="alertData.closeLabel"
        :submit-label="alertData.submitLabel"
    />
    <!-- <VModalForm
        :data="itemSelected"
        :update-action="updateAction"
        :open-dialog="openModalForm"
        @close="closeModalForm"
        @successSubmit="successSubmit"
        :additional="additional"
    /> -->
</template>
