<script setup>
// Imports
import { Head } from "@inertiajs/vue3";
import { router, usePage } from "@inertiajs/vue3";
import { reactive, ref, watch } from "vue";
import { useToast } from "vue-toastification";
// languaje
import "froala-editor/js/languages/es.js";

const page = usePage();
const toast = useToast();

// Props received from controller
const props = defineProps({
    buildComponentCategories: Object,
    cpuOptions: Array,
    coolerOptions: Array,
    ramOptions: Array,
    gpuOptions: Array,
    psuOptions: Array,
    caseOptions: Array,
    moboOptions: Array,
    romOptions: Array,
    featuredBuildsCount: Number,
    gamas: Array,
});

// Options empty arrays
const cpuOptions = ref([]);
const coolerOptions = ref([]);
const ramOptions = ref([]);
const gpuOptions = ref([]);
const psuOptions = ref([]);
const caseOptions = ref([]);
const moboOptions = ref([]);
const romOptions = ref([]);
const romOptionsId = ref([]);
const gamas = ref([]);

props.gamas.forEach((gama) => {
    gamas.value.push({
        label: gama.name,
        value: gama.id,
    });
});

// Adding products to its respective option Array
props.cpuOptions.forEach((option) => {
    cpuOptions.value.push({
        label: `${option.id} - ${option.name}`,
        value: option.id,
    });
});

props.coolerOptions.forEach((option) => {
    coolerOptions.value.push({
        label: `${option.id} - ${option.name}`,
        value: option.id,
    });
});

props.ramOptions.forEach((option) => {
    ramOptions.value.push({
        label: `${option.id} - ${option.name}`,
        value: option.id,
    });
});

props.gpuOptions.forEach((option) => {
    gpuOptions.value.push({
        label: `${option.id} - ${option.name}`,
        value: option.id,
    });
});

props.psuOptions.forEach((option) => {
    psuOptions.value.push({
        label: `${option.id} - ${option.name}`,
        value: option.id,
    });
});

props.caseOptions.forEach((option) => {
    caseOptions.value.push({
        label: `${option.id} - ${option.name}`,
        value: option.id,
    });
});

props.moboOptions.forEach((option) => {
    moboOptions.value.push({
        label: `${option.id} - ${option.name}`,
        value: option.id,
    });
});

props.romOptions.forEach((option) => {
    romOptions.value.push({
        label: `${option.id} - ${option.name}`,
        value: option.id,
    });
});

props.romOptions.forEach((option) => {
    romOptionsId.value.push({
        label: `${option.id} - ${option.name}`,
        value: option,
    });
});

// Offer variables
const applyOffer = ref(false);
const price = ref(null);
const percentage = ref(null);
const calculatedPrice = ref(0);
const newProperty = reactive({
    propertyName: null,
    propertyValue: null,
});
const newRoms = reactive({
    romName: null,
    romLink: null,
    romAmount: null
});
const newRomsId = ref(null);
const romIdAmount = ref(null);
const romQuantity = ref(null);

// Build components checkbox toggle
const externalCpu = ref(false);
const externalCooler = ref(false);
const coolerStock = ref(false);
const externalRam = ref(false);
const externalGpu = ref(false);
const externalPsu = ref(false);
const externalMobo = ref(false);
const externalCase = ref(false);
const externalRom = ref(false);
const multipleRom = ref(false);

// Form sent to Controller
const form = reactive({
    name: null,
    images: null,
    cpu_id: null,
    cpu_name: null,
    cpu_link: null,
    cooler_id: null,
    cooler_name: null,
    cooler_link: null,
    cooler_stock: coolerStock,
    ram_id: null,
    ram_name: null,
    ram_link: null,
    ram_units: 1,
    gpu_id: null,
    gpu_name: null,
    gpu_link: null,
    psu_id: null,
    psu_name: null,
    psu_link: null,
    mobo_id: null,
    mobo_name: null,
    mobo_link: null,
    case_id: null,
    case_name: null,
    case_link: null,
    rom_id: null,
    rom_name: null,
    rom_link: null,
    rom_multiple: {},
    rom_multiple_id: {},
    price: price,
    gama_id: null,
    warranty: null,
    details: {},
    quantity: null,
    featured: false,
    visacuotas: false,
    shipping: false,
    description: null,
    sale: applyOffer,
    percentage: percentage,
    sale_price: calculatedPrice,
    normal_price: null,
    sale_normal_price: null,
    show_price: null,
});

//Vue Ref Ram Counter

const updateRamUnits = () => {
    if ( form.ram_units === 4 ) {
        form.ram_units = 1;
    } else {
        form.ram_units++;
    }
}

// Watchers
watch(percentage, (newPercentage) => {
    if (applyOffer.value) {
        calculatedPrice.value = (
            price.value -
            price.value * (newPercentage / 100)
        ).toFixed(2);
    } else {
        calculatedPrice.value = 0;
    }
});

watch(price, (newPrice) => {
    if (applyOffer.value) {
        calculatedPrice.value = (
            newPrice -
            newPrice * (percentage.value / 100)
        ).toFixed(2);
    } else {
        calculatedPrice.value = 0;
        percentage.value = 0;
    }
});

watch(applyOffer, (newApplyOffer) => {
    if (newApplyOffer == false) {
        percentage.value = 0;
        calculatedPrice.value = 0;
    } else {
        percentage.value = null;
    }
});

// External products watcher
watch(externalCpu, (cpuToggled) => {
    if (cpuToggled === true) {
        form.cpu_id = null;
    } else {
        form.cpu_name = null;
        form.cpu_link = null;
    }
});

watch(externalCooler, (coolerToggled) => {
    if (coolerToggled === true) {
        form.cooler_id = null;
        coolerStock.value = false;
    } else {
        form.cooler_name = null;
        form.cooler_link = null;
    }
});

watch(coolerStock, (coolerStockToggled) => {
    if(coolerStockToggled === true){
        form.cooler_id = null;
        form.cooler_name = null;
        form.cooler_link = null;
    }
});

watch(externalRam, (RamToggled) => {
    if (RamToggled === true) {
        form.ram_id = null;
    } else {
        form.ram_name = null;
        form.ram_link = null;
    }
});

watch(externalGpu, (GpuToggled) => {
    if (GpuToggled === true) {
        form.gpu_id = null;
    } else {
        form.gpu_name = null;
        form.gpu_link = null;
    }
});

watch(externalPsu, (PsuToggled) => {
    if (PsuToggled === true) {
        form.psu_id = null;
    } else {
        form.psu_name = null;
        form.psu_link = null;
    }
});

watch(externalMobo, (moboToggled) => {
    if (moboToggled === true) {
        form.mobo_id = null;
    } else {
        form.mobo_name = null;
        form.mobo_link = null;
    }
});

watch(externalCase, (CaseToggled) => {
    if (CaseToggled === true) {
        form.case_id = null;
    } else {
        form.case_name = null;
        form.case_link = null;
    }
});

watch(externalRom, (RomToggled) => {
    if (RomToggled === true) {
        form.rom_id = null;
    } else {
        form.rom_name = null;
        form.rom_link = null;
    }
});

watch(multipleRom, (externalRomToggled) => {
    if (externalRomToggled === true) {
        form.rom_id = null;
        form.rom_name = null;
        form.rom_link = null;
    }else{
        romIdAmount.value = null
        newRomsId.value = null;
        romIdAmount.vualue = null;

        newRoms.romName = null;
        newRoms.romLink = null;
        newRoms.romAmount = null;

        form.rom_multiple = {};
        form.rom_multiple_id = {}
    }
});

watch(newRomsId, (romObject) => {
    // romQuantity.value = romObject.quantity
    if (romObject){
        romQuantity.value = `Disponibles: ( ${romObject.quantity} )`
    }else{
        romQuantity.value = 'Seleccione un disco para ver su disponibilidad'
    }
});

// Functions
function addNewProperty() {
    const name = String(newProperty.propertyName).trim().toLowerCase();
    const value = String(newProperty.propertyValue).trim();

    if (name == "null" || name == "undefined" || name == "") {
        toast.error("Especifique un nombre para la propiedad nueva.");
        newProperty.propertyName = null;
    } else if (value == "null" || value == "undefined" || value == "") {
        toast.error("Especifique un valor para la propiedad nueva.");
        newProperty.propertyValue = null;
    } else {
        form.details[name] = value;

        newProperty.propertyName = null;
        newProperty.propertyValue = null;
        toast.success('Propiedad Agregada');
    }
}

function deleteProperty(key) {
    delete form.details[key];
    toast.success('Propiedad eliminada');
}

//Rom sin id
function addNewRom() {
    const name = String(newRoms.romName).trim().toLowerCase();
    const link = String(!newRoms.romLink ? '' : newRoms.romLink).trim();
    const amount = Number(newRoms.romAmount);

    if (name == "null" || name == "undefined" || name == "") {
        toast.error("Especifique un nombre para la propiedad nueva.");
        newRoms.romName = null;
    }else if (amount == null || amount == undefined || amount == 0) {
        toast.error("Especifique un valor para la propiedad nueva.");
        newRoms.romLink = null;
    } else {
        form.rom_multiple[name] = {link, amount};

        newRoms.romName = null;
        newRoms.romLink = null;
        newRoms.romAmount = null;
        toast.success('Almacenamiento agregado');
    }
}

function deleteRom(key) {
    delete form.rom_multiple[key];
    toast.success('Almacenamiento eliminado');
}
//Rom sin id

//Rom con id
function addNewRomId(romsId) {
    const id = romsId.id;
    const name = romsId.name;
    const maxAmount = romsId.quantity;
    const amount = romIdAmount.value;
    
    if(id == null || id == undefined || id == 0){
        toast.error('Escoja un producto de las opciones.');
        newRomsId.value = null;
    }else if(name == "null" || name == "undefined" || name == ""){
        toast.error('Escoja un producto de las opciones.');
        newRomsId.value = null;
    }else if(amount > maxAmount){
        toast.error('La cantidad de discos utilizados no puede ser superior a las de la tienda.');
        romIdAmount.value = null;
    }else if (amount == null || amount == undefined || amount == 0) {
        toast.error('Especifique la cantidad de los discos.');
        romIdAmount.value = null;
    } else {

        form.rom_multiple_id[name] = {id, amount, maxAmount};

        romsId.value = null;
        romIdAmount.value = null;
        newRomsId.value = null;
        toast.success('Almacenamiento agregado');
    }
}

function deleteRomId(key) {
    delete form.rom_multiple_id[key];
    toast.success('Almacenamiento eliminado');
}

function submit() {
    if(JSON.stringify(form.rom_multiple_id) === '{}' && JSON.stringify(form.rom_multiple) === '{}' && multipleRom ){
        toast.warning('Los campos no fueron completados correctamente.');

        //roms id
        romIdAmount.value = null;
        newRomsId.value = null;
        romIdAmount.vualue = null;

        //roms
        newRoms.romName = null;
        newRoms.romLink = null;
        newRoms.romAmount = null;

    }else{
        form.normal_price = (form.price * 1.05).toFixed(2);
        form.sale_normal_price = (form.sale_price * 1.05).toFixed(2);
        form.show_price = form.sale ? form.sale_price : form.price;
        router.post("builds", form);
    }
}

//froala
const config = ref({
    // Image upload request
    imageUploadURL: '/admin/froala-upload',
    imageUploadParam: 'image',
    imageUploadParams: {
      froala: 'true',
      _token: page.props.csrf_token,
      path: 'builds/',
    },
    imageUploadMethod: 'post',

    // Image delete request
    events: {
      "image.removed": function ( image ) {
        let data = {
          image: image[0].attributes[0].nodeValue,
          _token: page.props.csrf_token,
        }

        fetch('/admin/froala-remove', {
          method: "POST",
          body: JSON.stringify(data),
          headers: {"Content-type": "application/json; charset=UTF-8"}
        })
      }
    },

    // Other config
    language: "es",
    formStyles: { class1: "mb-10" },

    toolbarButtons: [
        "bold",
        "italic",
        "underline",
        "strikeThrough",
        "subscript",
        "superscript",

        "|",

        "fontFamily",
        "fontSize",
        "textColor",
        "backgroundColor",
        "color",
        "inlineStyle",
        "paragraphStyle",

        "|",

        "paragraphFormat",
        "align",
        "formatOL",
        "formatUL",
        "outdent",
        "indent",
        "quote",
        "-",
        "insertLink",
        "insertImage",
        "insertTable",
        "insertVideo",
        "|",

        "emoticons",
        "specialCharacters",
        "insertHR",
        "selectAll",
        "clearFormatting",

        "|",

        "undo",
        "redo",
        "trackChanges",
        "markdown",
    ],
    videoResponsive: true,
    pluginsEnabled: [
        "video",
        "align",
        "colors",
        "emoticons",
        "fontAwesome",
        "fontFamily",
        "fontSize",
        "image",
        "imageManager",
        "imageTUI",
        "inlineClass",
        "inlineStyle",
        "lineBreaker",
        "lineHeight",
        "link",
        "lists",
        "markdown",
        "paragraphFormat",
        "paragraphStyle",
        "quote",
        "specialCharacters",
        "track_changes",
        "table",
        "wordPaste",
    ],
});

const useGoBack = useBack;
</script>

<template>
    <Head title="Crear combo" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <p class="dark:text-white text-2xl font-bold">Crear nuevo Combo</p>
            <ButtonNavigator
                href=""
                @click="useGoBack"
                text="Volver"
                type="button"
            />
        </div>
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
            <FormKit type="form" @submit="submit" submit-label="Guardar">
                <FormKit
                    v-model="form.name"
                    type="text"
                    name="name"
                    label="Nombre de la PC"
                    placeholder="Combo Build #5"
                    validation="required|length:1,35"
                    maxlength="35"
                    autocomplete="off"
                />

                <FormKit
                    v-model="form.images"
                    type="file"
                    name="images"
                    label="Imagen"
                    accept=".jpg,.png,.jpeg,.svg,.gif"
                    validation="required"
                />

                <FormKit
                    v-model="price"
                    type="number"
                    name="price"
                    label="Precio"
                    placeholder="9500"
                    step="0.01"
                    validation="number|required|min:0.01|max:999999"
                    autocomplete="off"
                />

                <div class="my-12">
                    <p class="text-xl dark:text-white font-bold text-base mb-3">Procesador</p>
                    <FormKit
                        v-if="!externalCpu"
                        v-model="form.cpu_id"
                        :options="cpuOptions"
                        type="select"
                        name="cpu"
                        label="En existencia"
                        placeholder="Seleccionar..."
                        validation="required"
                      />

                    <div v-else>
                        <FormKit
                            v-model="form.cpu_name"
                            type="text"
                            name="cpu_name"
                            label="Nombre del CPU"
                            placeholder="Intel Procesador Core i5-12400F"
                            validation="required|length:1,65"
                            maxlength="65"
                        />
                        <FormKit
                            v-model="form.cpu_link"
                            type="text"
                            name="cpu_link"
                            label="Link a la página del producto (opcional)"
                            placeholder="https://www.intel.la/..."
                        />
                    </div>

                    <FormKit
                        type="checkbox"
                        label="Agregar CPU fuera de existencias"
                        name="external_cpu"
                        v-model="externalCpu"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />
                </div>

                <div class="my-12">
                    <p class="text-xl dark:text-white font-bold text-base mb-3">Enfriamiento</p>
                    <FormKit
                        v-if="!externalCooler && !coolerStock"
                        v-model="form.cooler_id"
                        :options="coolerOptions"
                        type="select"
                        name="cooler"
                        label="En existencia"
                        placeholder="Seleccionar..."
                        validation="required"
                      />

                    <div v-else-if="!coolerStock">
                        <FormKit
                            v-model="form.cooler_name"
                            type="text"
                            name="cooler_name"
                            label="Nombre del Disipador"
                            placeholder="Disipador Gaming Cooler Master ATX RR-2V2L-18PD-R1"
                            validation="required|length:1,65"
                            maxlength="65"
                        />
                        <FormKit
                            v-model="form.cooler_link"
                            type="text"
                            name="cooler_link"
                            label="Link a la página del producto (opcional)"
                            placeholder="https://www.coolermaster.com/..."
                        />
                    </div>

                    <FormKit
                        v-if="!coolerStock"
                        type="checkbox"
                        label="Agregar Disipador fuera de existencias"
                        name="external_cooler"
                        v-model="externalCooler"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />

                    <FormKit
                        type="checkbox"
                        label="Cooler stock"
                        name=""
                        v-model="coolerStock"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />

                    </div>

                <div class="my-12">
                    <p class="text-xl dark:text-white font-bold text-base mb-3">Memoria RAM</p>
                    <div class="flex">
                        <div>
                            <FormKit
                                v-if="!externalRam"
                                v-model="form.ram_id"
                                :options="ramOptions"
                                type="select"
                                name="ram"
                                label="En existencia"
                                placeholder="Seleccionar..."
                                validation="required"
                              />

                            <div v-else>
                                <FormKit
                                    v-model="form.ram_name"
                                    type="text"
                                    name="ram_name"
                                    label="Nombre de la Memoria RAM"
                                    placeholder="Corsair Memoria RAM DDR5 32GB (2X16GB) NEGRO"
                                    validation="required|length:1,65"
                                    maxlength="65"
                                />
                                <FormKit
                                    v-model="form.ram_link"
                                    type="text"
                                    name="ram_link"
                                    label="Link a la página del producto (opcional)"
                                    placeholder="https://www.corsair.com/es/..."
                                />
                            </div>
                        </div>
                        <div class="mt-[32px] mx-3">
                            <TextButton :text="`X${form.ram_units}`" @click="updateRamUnits" />
                        </div>
                    </div>

                    <FormKit
                        type="checkbox"
                        label="Agregar RAM fuera de existencias"
                        name="external_ram"
                        v-model="externalRam"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />
                </div>

                <div class="my-12">
                    <p class="text-xl font-bold text-base dark:text-white mb-3">Tarjeta Gráfica</p>
                    <FormKit
                        v-if="!externalGpu"
                        v-model="form.gpu_id"
                        :options="gpuOptions"
                        type="select"
                        name="gpu"
                        label="En existencia"
                        placeholder="Seleccionar..."
                        validation="required"
                      />

                    <div v-else>
                        <FormKit
                            v-model="form.gpu_name"
                            type="text"
                            name="gpu_name"
                            label="Nombre de la Tarjeta Gráfica"
                            placeholder="Gráfica GeForce RTX 3060"
                            validation="required|length:1,65"
                            maxlength="65"
                        />
                        <FormKit
                            v-model="form.gpu_link"
                            type="text"
                            name="gpu_link"
                            label="Link a la página del producto (opcional)"
                            placeholder="https://www.nvidia.com/..."
                        />
                    </div>

                    <FormKit
                        type="checkbox"
                        label="Agregar Gráfica fuera de existencias"
                        name="external_gpu"
                        v-model="externalGpu"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />
                </div>

                <div class="my-12">
                    <p class="text-xl font-bold text-base dark:text-white mb-3">Fuente de Poder</p>
                    <FormKit
                        v-if="!externalPsu"
                        v-model="form.psu_id"
                        :options="psuOptions"
                        type="select"
                        name="psu"
                        label="En existencia"
                        placeholder="Seleccionar..."
                        validation="required"
                      />

                    <div v-else>
                        <FormKit
                            v-model="form.psu_name"
                            type="text"
                            name="psu_name"
                            label="Nombre de la Fuente de Poder"
                            placeholder="Fuente de poder AZZA 650w 80 plus bronce RGB"
                            validation="required|length:1,65"
                            maxlength="65"
                        />
                        <FormKit
                            v-model="form.psu_link"
                            type="text"
                            name="psu_link"
                            label="Link a la página del producto (opcional)"
                            placeholder="https://www.azza.com/..."
                        />
                    </div>

                    <FormKit
                        type="checkbox"
                        label="Agregar Fuente de Poder fuera de existencias"
                        name="external_psu"
                        v-model="externalPsu"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />
                </div>

                <div class="my-12">
                    <p class="text-xl font-bold text-base dark:text-white mb-3">Case</p>
                    <FormKit
                        v-if="!externalCase"
                        v-model="form.case_id"
                        :options="caseOptions"
                        type="select"
                        name="case"
                        label="En existencia"
                        placeholder="Seleccionar..."
                        validation="required"
                      />

                    <div v-else>
                        <FormKit
                            v-model="form.case_name"
                            type="text"
                            name="case_name"
                            label="Nombre del Case"
                            placeholder="Case Gaming TUF GT502 ATX Media Torre Vidrio Templado"
                            validation="required|length:1,65"
                            maxlength="65"
                        />
                        <FormKit
                            v-model="form.case_link"
                            type="text"
                            name="case_link"
                            label="Link a la página del producto (opcional)"
                            placeholder="https://www.tuf.com/..."
                        />
                    </div>

                    <FormKit
                        type="checkbox"
                        label="Agregar Case fuera de existencias"
                        name="external_case"
                        v-model="externalCase"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />
                </div>

                <div class="my-12">
                    <p class="text-xl font-bold text-base dark:text-white mb-3">Motherboard</p>
                    <FormKit
                        v-if="!externalMobo"
                        v-model="form.mobo_id"
                        :options="moboOptions"
                        type="select"
                        name="mobo"
                        label="En existencia"
                        placeholder="Seleccionar..."
                        validation="required"
                      />

                    <div v-else>
                        <FormKit
                            v-model="form.mobo_name"
                            type="text"
                            name="mobo_name"
                            label="Nombre de la Motherboard"
                            placeholder="Motherboard Asus A520M-A II AM4 x4DDR4 Micro ATX"
                            validation="required|length:1,65"
                            maxlength="65"
                        />
                        <FormKit
                            v-model="form.mobo_link"
                            type="text"
                            name="mobo_link"
                            label="Link a la página del producto (opcional)"
                            placeholder="https://www.asus.com/..."
                        />
                    </div>

                    <FormKit
                        type="checkbox"
                        label="Agregar Motherboard fuera de existencias"
                        name="external_mobo"
                        v-model="externalMobo"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />
                </div>

                <div class="my-12">
                    <p class="text-xl font-bold text-base dark:text-white mb-3">Almacenamiento</p>
                    <FormKit
                        v-if="!externalRom && !multipleRom"
                        v-model="form.rom_id"
                        :options="romOptions"
                        type="select"
                        name="rom"
                        label="En existencia"
                        placeholder="Seleccionar..."
                        validation="required"
                      />

                    <div v-else-if="!multipleRom">
                        <FormKit
                            v-model="form.rom_name"
                            type="text"
                            name="rom_name"
                            label="Nombre del Disco de Almacenamiento"
                            placeholder="Unidad Estado Sólido SSD KINGSTON M.2 NV2 2TB"
                            validation="required|length:1,65"
                            maxlength="65"
                        />
                        <FormKit
                            v-model="form.rom_link"
                            type="text"
                            name="rom_link"
                            label="Link a la página del producto fuera de existencias (opcional)"
                            placeholder="https://www.kingston.com/..."
                        />
                    </div>

                    <div class=" gap-8 max-w-[30rem] flex flex-col" v-if="multipleRom">
                        
                        <div
                            class=" bg-white dark:bg-gray-900 p-5 shadow sm:rounded-lg"
                            v-for="(value, key) in form.rom_multiple_id"  
                        >
                        <div 
                            class="flex w-full justify-between gap-5"    
                        >
                            <p class="text-lg	dark:text-white font-bold text-base mb-3">{{ key }}</p>
                            <IconButton
                                class="opacity-70 h-[2rem] w-[2rem] hover:opacity-100 flex justify-center"
                                icon="mdi:trash"
                                color="red-600 hover:red"
                                @click="deleteRomId(key)"
                            />
                        </div>
                        <div
                            class="flex items-center sm:w-[27.5rem] gap-3"
                        >
                            <FormKit
                                v-model="value.amount"
                                type="number"
                                :validation="`number|required|min:1|max:${value.maxAmount}`"
                                label="Cantidad de los discos"
                                label-class="uppercase text-sm"
                                :placeholder="value.amount"
                            />
                        </div>
                        </div> 
                    </div>

                <div class="my-12" v-if="multipleRom">
                        <FormKit
                            v-model="newRomsId"
                            :options="romOptionsId"
                            :validation="`${ JSON.stringify(form.rom_multiple_id) !== '{}' || JSON.stringify(form.rom_multiple) !== '{}' && multipleRom ? 'nullable' : 'required'}|length:1,65`"
                            type="select"
                            label="Seleccionar multiples discos por id"
                            placeholder="Seleccionar..."
                        />

                        <div
                            class="text-amber-400 py-2"
                        >
                            {{ romQuantity }}
                        </div>
                        
                        <FormKit
                            v-model="romIdAmount"
                            type="number"
                            :validation="`number|${JSON.stringify(form.rom_multiple_id) !== '{}' || JSON.stringify(form.rom_multiple) !== '{}' && multipleRom ? 'nullable' : 'required'}|min:1|max:999999`"
                            label="Cantidad de los discos"
                            placeholder="2"
                            autocomplete="off"

                        />

                        <IconButton
                            @click="addNewRomId(newRomsId)"
                            icon="ic:round-add-box"
                            color="blue-600"
                        />
                </div>

                <div class="gap-8 max-w-[30rem] flex flex-col" v-if="multipleRom">
                    <div
                        class="flex flex-col gap-3 bg-white dark:bg-gray-900 p-5 shadow sm:rounded-lg"
                        v-for="(value, key) in form.rom_multiple"
                        
                    >
                    <div
                        class="flex w-full justify-between gap-5"
                    >
                    <p class="text-lg dark:text-white font-bold text-base mb-3">{{  key }}</p>
                    <IconButton
                            class="opacity-70 h-[2rem] w-[2rem] hover:opacity-100 flex justify-center"
                            icon="mdi:trash"
                            color="red-600 hover:red"
                            @click="deleteRom(key)"
                    />
                    </div>
                    <div
                        class="flex flex-col sm:flex-row items-left sm:w-[27.5rem] gap-3"
                    >
                        <FormKit
                            type="text"
                            v-model="value.link"
                            label="Editar link"
                            label-class="uppercase text-sm"
                            :placeholder="value.link"
                        />

                        <FormKit
                            type="number"
                            v-model="value.amount"
                            validation="number|required|min:1|max:999999"
                            label="Cantidad de los discos"
                            label-class="uppercase text-sm"
                            :placeholder="value.amount"

                        />

                    </div>
                    </div>
                </div>

                <div class="my-12" v-if="multipleRom">
                    <FormKit
                        type="text"
                        v-model="newRoms.romName"
                        :validation="`${JSON.stringify(form.rom_multiple_id) !== '{}' || JSON.stringify(form.rom_multiple) !== '{}' && multipleRom ? 'nullable' : 'required'}|length:1,65`"
                        label="Nombre del disco"
                        placeholder="Seagate Barracuda"

                    />

                    <FormKit
                        type="text"
                        v-model="newRoms.romLink"
                        label="Escriba la dirección externa del disco (opcional)"
                        placeholder="https://www.pagina.com/producto/1"
                       
                    />

                    <FormKit
                        type="number"
                        v-model="newRoms.romAmount"
                        :validation="`number|${JSON.stringify(form.rom_multiple_id) !== '{}' || JSON.stringify(form.rom_multiple) !== '{}' && multipleRom ? 'nullable' : 'required'}|min:1|max:999999`"
                        label="Cantidad de los discos"
                        placeholder="2"
                    />
                    <IconButton
                        @click="addNewRom"
                        icon="ic:round-add-box"
                        color="blue-600"
                    />

                </div>

                    <FormKit
                        v-if="!multipleRom"
                        type="checkbox"
                        label="Agregar otro almacenamiento"
                        name="external_rom"
                        v-model="externalRom"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />

                    <FormKit
                        type="checkbox"
                        label="Agregar multiples almacenamientos"
                        name="multiple_rom"
                        v-model="multipleRom"
                        label-class="$reset text-sm text-gray-800 dark:text-gray-300 ml-1"
                    />

                </div>
                <p class="text-xl dark:text-white font-bold text-base mb-3">Descripción</p>
                <froala
                    id="edit"
                    :tag="'textarea'"
                    :config="config"
                    v-model:value="form.description"
                ></froala>

                <FormKit
                    type="select"
                    label="Gama"
                    placeholder="Seleccionar..."
                    :options="gamas"
                    name="gama"
                    id="gama"
                    validation="required"
                    v-model="form.gama_id"
                />

                <FormKit
                    v-model="form.warranty"
                    type="text"
                    name="warranty"
                    label="Garantía"
                    placeholder="1 año / No incluye"
                    validation="required|length:1,40"
                    maxlength="40"
                />

                <FormKit
                    v-model="form.quantity"
                    type="number"
                    name="quantity"
                    label="En existencia"
                    placeholder="1"
                    validation="number|required|min:0|max:999999"
                    autocomplete="off"
                />

                <div class="mt-9">
                    <p class="dark:text-white font-bold text-base text-xl mb-4">Nuevas Propiedades</p>
                    <div
                        v-for="(value, key) in form.details"
                        class="flex items-center sm:w-[27.5rem] gap-3"
                    >
                        <FormKit
                        :key="key"
                        type="text"
                        autocomplete="off"
                        :name="key"
                        :id="key"
                        :label="key"
                        placeholder="Nuevo valor"
                        validation="required|length:1,65"
                        label-class="uppercase"
                        :value="value"
                        maxlength="65"
                        v-model="form.details[key]"
                        />
                        <IconButton
                        class="opacity-70"
                        icon="mdi:trash"
                        color="red-600"
                        @click="deleteProperty(key)"
                        />
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row lg:gap-3 items-start lg:items-center mb-10 lg:mb-1 sm:w-[27.5rem]">
                    <FormKit
                        type="text"
                        name="newProperty"
                        id="newProperty"
                        label="Nueva propiedad"
                        placeholder="Color"
                        validation="length:0,30"
                        maxlength="30"
                        v-model="newProperty.propertyName"
                    />
                    <div class="flex items-center gap-4">
                        <FormKit
                        type="text"
                        name="newValue"
                        id="newValue"
                        label="Valor"
                        placeholder="Gris"
                        validation="length:0,65"
                        maxlength="65"
                        v-model="newProperty.propertyValue"
                        />
                        <IconButton
                        icon="ic:round-add-box"
                        color="blue-600"
                        @click="addNewProperty"
                        />
                    </div>
                </div>

                <FormKit
                    type="checkbox"
                    label="Acepta Visacuotas"
                    name="visacuotas"
                    v-model="form.visacuotas"
                    label-class="$reset dark:text-white ml-1"
                />

                <FormKit
                    type="checkbox"
                    label="Envío incluído"
                    name="shipping"
                    v-model="form.shipping"
                    label-class="$reset dark:text-white ml-1"
                />

                <p
                    v-if="props.featuredBuildsCount >= 7"
                    class="text-[#d1c500] mb-1 text-sm">
                        Solo pueden haber 8 combos destacados
                </p>
                <FormKit
                    :disabled="props.featuredBuildsCount >= 7 ? true : false "
                    v-model="form.featured"
                    type="checkbox"
                    name="featured"
                    label="Producto destacado"
                    label-class="$reset dark:text-white ml-1"
                />

                <FormKit
                    type="checkbox"
                    label="Aplicar oferta"
                    name="sale"
                    v-model="applyOffer"
                    label-class="$reset dark:text-white ml-1"
                />

                <div v-if="form.sale" class="my-8">
                    <p class="dark:text-white text-2xl mb-4">Oferta</p>
                    <div class="flex gap-3 items-center w-[14rem]">
                        <FormKit
                        type="number"
                        name="percentage"
                        id="percentage"
                        label="Porcentaje de descuento"
                        placeholder="10"
                        v-model="percentage"
                        validation="number|required|min:1|max:99"
                        />
                        <p class="text-lg dark:text-white">%</p>
                    </div>
                    <div class="mb-6">
                        <p class="dark:text-white text-sm lg:text-lg mb-2">
                            Precio efectivo:
                            <span class="ml-2 text-sm lg:text-lg">
                                Q {{ price || 0 }}
                            </span>
                        </p>
                        <p class="dark:text-white text-base lg:text-xl mb-2">
                            Precio ofertado:
                            <span class="ml-2 text-base lg:text-xl font-bold">
                                Q {{ calculatedPrice || 0 }}
                            </span>
                        </p>
                    </div>
                </div>
            </FormKit>
        </div>
    </AuthenticatedLayout>
</template>
