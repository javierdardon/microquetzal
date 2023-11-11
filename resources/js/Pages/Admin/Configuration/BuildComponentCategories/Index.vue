<script setup>
import { ModalsContainer, useModal } from "vue-final-modal";
import InfoModal from "@/Components/admin/InfoModal.vue";
// Importation
import { Head, router } from "@inertiajs/vue3";
import { ref, reactive } from "vue";
import { Icon } from "@iconify/vue";

// Props received from Controller
const props = defineProps({
    buildComponentCategories: Object,
    categories: Object,
});

const infoModal = useModal({
    component: InfoModal,
    attrs: {
        title: "Información",
        onClose() {
            infoModal.close();
        },
    },
});

const seeInfo = () => {
    infoModal.open();
};

// Categories variable (options shown in selects)
const categories = ref([]);

// Pushing every category from props to variable
props.categories.forEach((category) => {
    categories.value.push({
        label: category.name,
        value: category.id,
    });
});

// Form sent to controller
const form = reactive({
    cpu: props.buildComponentCategories.cpu,
    cooler: props.buildComponentCategories.cooler,
    ram: props.buildComponentCategories.ram,
    gpu: props.buildComponentCategories.gpu,
    psu: props.buildComponentCategories.psu,
    mobo: props.buildComponentCategories.mobo,
    case: props.buildComponentCategories.case,
    rom: props.buildComponentCategories.rom,
});

// Form submission
function submit() {
    router.post(
        "/admin/configurations/build-component-categories-update",
        form
    );
}

const useGoBack = useBack;
</script>

<template>
    <Head title="Crear categoría" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-start mb-7">
            <h1
                class="flex flex-wrap items-center gap-2 dark:text-white text-2xl font-bold w-full cursor-pointer"
                @click="seeInfo"
            >
                Establecer categorías aplicadas a los PC Combos
                <Icon
                    icon="bi:info-circle-fill"
                    class="text-[#1370AB] hover:text-[#248ACB] w-5 h-5"
                />
            </h1>
            <ButtonNavigator
                href=""
                @click="useGoBack"
                text="Volver"
                type="button"
            />
        </div>

        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
            <FormKit
                type="form"
                submit-label="Guardar"
                @submit="submit"
            >
                <FormKit
                    type="select"
                    label="Procesadores"
                    :options="categories"
                    name="cpu"
                    id="cpu"
                    validation="required"
                    placeholder="Seleccionar..."
                    v-model="form.cpu"
                />
                <FormKit
                    type="select"
                    label="Disipadores / Enfriamiento"
                    :options="categories"
                    name="cooler"
                    id="cooler"
                    validation="required"
                    placeholder="Seleccionar..."
                    v-model="form.cooler"
                />
                <FormKit
                    type="select"
                    label="Memoria RAM"
                    :options="categories"
                    name="ram"
                    id="ram"
                    validation="required"
                    placeholder="Seleccionar..."
                    v-model="form.ram"
                />
                <FormKit
                    type="select"
                    label="Tarjetas de Video / Gráficas"
                    :options="categories"
                    name="gpu"
                    id="gpu"
                    validation="required"
                    placeholder="Seleccionar..."
                    v-model="form.gpu"
                />
                <FormKit
                    type="select"
                    label="Fuentes de poder"
                    :options="categories"
                    name="psu"
                    id="psu"
                    validation="required"
                    placeholder="Seleccionar..."
                    v-model="form.psu"
                />
                <FormKit
                    type="select"
                    label="Motherboards / Tarjetas Madre"
                    :options="categories"
                    name="mobo"
                    id="mobo"
                    validation="required"
                    placeholder="Seleccionar..."
                    v-model="form.mobo"
                />
                <FormKit
                    type="select"
                    label="Case / Gabinetes"
                    :options="categories"
                    name="case"
                    id="case"
                    validation="required"
                    placeholder="Seleccionar..."
                    v-model="form.case"
                />
                <FormKit
                    type="select"
                    label="Almacenamiento / Discos"
                    :options="categories"
                    name="rom"
                    id="rom"
                    validation="required"
                    placeholder="Seleccionar..."
                    v-model="form.rom"
                />
            </FormKit>
        </div>
        <ModalsContainer />
    </AuthenticatedLayout>
</template>
