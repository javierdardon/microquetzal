<script setup>
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ModalsContainer, useModal } from "vue-final-modal";

import ModalConfirm from "@/Components/admin/DeleteConfirmModal.vue";
import DescriptionsModal from "@/Components/admin/DescriptionsModal.vue";
import FiltersModal from "@/Components/admin/FiltersModal.vue";

const props = defineProps({
    title: String,
    columns: Array,
    rows: Array,
    createRoute: String,
    deleteRoute: String,
    viewRoute: String,
    editRoute: String,
    updateRoute: String,
    saleRoute: String,
    showFilters: Boolean,
    showOnlyTable: Boolean,
});

const adminFilterStore = useAdminFilterStore();

const showImage = (item) => {
    if (/\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(item)) {
        return true;
    }
    return false;
};

const hideHTML = (item) => {
    if (/<\/?[a-z][\s\S]*>/i.test(item)) {
        return true;
    }
    return false;
};

const form = useForm({
    id: "",
});


function view(id) {
    router.get(`${props.viewRoute}/${id}`);
}

function edit(id) {
    router.get(`${props.editRoute}/${id}`);
}

function destroy(id) {
    router.delete(`${props.deleteRoute}/${id}`);
}

function update(id) {
    router.patch(`${props.updateRoute}/${id}`);
}

function editSale(id) {
    router.get(`${props.saleRoute}/${id}`);
}

const filteredColumns = computed(() => {
    return props.columns.filter(
        (col) =>
            !col.name.includes("id") &&
            !col.name.includes("_id") &&
            !col.name.includes("featured") &&
            !col.name.includes("show_price") &&
            !col.name.includes("sale")
    );
});

//modal del boton eliminar
const nameDelete = ref("");

const openConfirmDelete = (id, name) => {
    nameDelete.value = name;
    deleteModal.rowId = id;
    deleteModal.open();
};

const deleteModal = useModal({
    component: ModalConfirm,
    attrs: {
        rowId: 0,
        nameDelete: nameDelete,
        onConfirm() {
            destroy(deleteModal.rowId);
            deleteModal.close();
        },
        onClose() {
            deleteModal.close();
        },
    },
});

//modal del boton de descripcion
const descriptionPharagraph = ref("");
const titleDetails = ref("");

const openDetails = (details, title) => {
    titleDetails.value = title;
    descriptionPharagraph.value = details;
    openDescripcion.open();
};

const openDescripcion = useModal({
    component: DescriptionsModal,
    attrs: {
        description: descriptionPharagraph,
        title: titleDetails,
        onClose() {
            openDescripcion.close();
        },
    },
});

const filters = useModal({
    component: FiltersModal,
    attrs: {
        title: 'Menú de Filtros',
        onSubmit() {
            adminFilterStore.applyFilters();
            filters.close();
        },
        onConfirm() {
            adminFilterStore.emptyFilters();
            filters.close();
        },
        onClose() {
            filters.close();
        },
    },
});

//change buttons lang
if (props.linksPaginate) {
    props.linksPaginate[0].label = props.linksPaginate[0].label.replace(
        "Previous",
        "Anterior"
    );
    props.linksPaginate[props.linksPaginate.length - 1].label =
        props.linksPaginate[props.linksPaginate.length - 1].label.replace(
            "Next",
            "Siguiente"
        );
}
</script>

<template>
    <div class="w-full">
        <div class="flex flex-col sm:flex-row flex-wrap justify-between items-center mb-3 gap-3 w-full" v-if="!props.showOnlyTable">
            <p class="dark:text-white text-2xl uppercase font-bold text-start me-auto">
                {{ props.title }}
            </p>

            <form @submit.prevent="adminFilterStore.applyFilters()" autocomplete="off" class="grow w-full sm:max-w-sm">
                <AdminSearchBar />
            </form>
        </div>

        <div
          class="dark:text-white mb-3 flex sm:flex-row gap-2 justify-start sm:justify-end"
        >
        <div class="flex gap-1 sm:gap-2">
                <Button
                    v-if="props.showFilters"
                    title="Abrir filtros"
                    icon-name="mdi:filter-multiple"
                    text-color="text-white"
                    background-color="bg-[#1671AB]"
                    hover="hover:bg-[#248ACB] hover:shadow-sm hover:shadow-blue-400/100 duration-300"
                    :big-text="false"
                    :left-icon="false"
                    font-size="text-xs sm:text-xs md:text-sm lg:text-sm xl:text-sm"
                    icon-style="w-4 h-4"
                    extra="rounded-full py-1.5 px-4"
                    @click="filters.open()"
                />
                <ButtonNavigator
                    v-if="props.createRoute"
                    :navigate-to="props.createRoute"
                    text="Crear"
                    type="button"
                    method="get"
                />
            </div>
        </div>

        <div
            class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg"
        >
            <p v-if="!rows.length" class="text-center dark:text-white py-32">No se encontraron resultados.</p>

            <div
                class="table border-collapse dark:text-white mx-auto cursor-default whitespace-nowrap font-sans w-full"
                v-else
            >
                <div class="table-header-group">
                    <div
                        class="table-row border-y dark:border-t-gray-700 dark:border-b-gray-300 dark:bg-gray-800"
                    >
                        <div
                            v-if="
                                props.deleteRoute ||
                                props.updateRoute ||
                                props.editRoute
                            "
                            class="text-center table-cell py-3 px-7 font-bold text-[0.90rem] uppercase max-w-xs"
                        >
                            Acciones
                        </div>
                        <div
                            v-for="(col, index) in filteredColumns"
                            :key="index"
                            class="text-center table-cell py-3 px-3 lg:px-7 font-bold text-[0.70rem] lg:text-[0.90rem] uppercase max-w-xs"
                        >
                            {{ col.label }}
                        </div>
                    </div>
                </div>
                <div class="table-row-group">
                    <div
                        v-for="row in props.rows"
                        :key="row.name"
                        class="table-row flex text-center items-center font-mono border-y dark:border-y-gray-700 dark:text-gray-300 hover:bg-[#f3f4f6] dark:hover:bg-slate-950"
                    >
                        <div class="table-cell py-3 px-7 text-sm align-middle">
                            <IconButton
                                v-if="props.viewRoute"
                                class="mr-1 text-white"
                                icon="mdi:eye"
                                color="green-500"
                                @click="view(row.id)"
                            />

                            <IconButton
                                v-if="props.editRoute"
                                class="mr-2"
                                icon="mdi:edit-box"
                                color="blue-600"
                                @click="edit(row.id)"
                            />
                            <IconButton
                                v-if="props.updateRoute"
                                class="mr-1 text-black"
                                textColor="text-[#4b5563] dark:text-white"
                                :icon="
                                    row.featured
                                        ? 'twemoji:star'
                                        : 'heroicons:star'
                                "
                                @click="update(row.id)"
                            />
                            <IconButton
                                v-if="props.saleRoute"
                                class="mr-2 text-black"
                                icon="mdi:sale"
                                :text-color="
                                    row.sale
                                        ? 'text-[#32CD32]'
                                        : 'text-gray-600'
                                "
                                @click="editSale(row.id)"
                            />
                            <IconButton
                                v-if="props.deleteRoute"
                                icon="mdi:trash"
                                color="red-600"
                                @click="openConfirmDelete(row.id, row.Nombre)"
                            />
                        </div>
                        <div
                            v-for="(col, index) in filteredColumns"
                            :key="index"
                            class="table-cell py-3 items-center flex align-middle px-5 lg:px-7 text-sm max-w-[15rem] lg:max-w-xs h-16 lg:h-20"
                        >
                            <img
                                v-if="showImage(row[col.name])"
                                :src="`/${row[col.name]}`"
                                class="max-h-14 mx-auto"
                            />

                            <button
                                v-else-if="hideHTML(row[col.name])"
                                class="rounded-md bg-[#2563eb] text-white rounded-md text-[0.65rem] lg:text-sm text-center inline-flex items-center p-1"
                                @click="
                                    openDetails(row.Descripcion, row.Nombre)
                                "
                            >
                                DESCRIPCION
                            </button>

                            <div
                              v-else
                              :class="row[col.name] == row.show_price
                                ? 'text-overflow truncate text-[0.65rem] lg:text-sm text-[#248ACB] font-display'
                                : 'text-overflow truncate text-[0.65rem] lg:text-sm'
                              "
                              :title="row[col.name] == row.show_price ? 'Precio mostrado en la tarjeta de producto' : ''"
                            >
                                {{ row[col.name] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex w-full items-center justify-center" v-if="!props.showOnlyTable">
            <DatatablePagination />
        </div>
    </div>

    <ModalsContainer />
</template>
