<script setup>
// Importations
import { Head, router, usePage, useForm } from "@inertiajs/vue3";
import { reactive, ref, watch } from "vue";

const page = usePage();

// Props received from controller
const props = defineProps({
    brands: Array,
    categories: Array,
});

// Brand options selectable in input
const brands = ref([]);

props.brands.forEach((brand) => {
    brands.value.push({
        label: brand.name,
        value: brand.id,
    });
});

// Category options selectable in input
const categories = ref([]);

props.categories.forEach((category) => {
    categories.value.push({
        label: category.name,
        value: category.id,
    });
});

// Offer reactive values
const applyOffer = ref(false);
const price = ref(null);
const percentage = ref(null);
const calculatedPrice = ref(0);

// Form sent to controller to save product
const form = reactive({
    name: null,
    images: null,
    price: price,
    brand_id: null,
    category_id: null,
    description: null,
    warranty: null,
    details: {},
    quantity: null,
    condition: null,
    visacuotas: false,
    shipping: false,
    featured: false,
    sale: applyOffer,
    percentage: percentage,
    sale_price: calculatedPrice,
    normal_price: null,
    sale_normal_price: null,
    show_price: null,
});

// New property placeholder
const newProperty = reactive({
    propertyName: null,
    propertyValue: null,
});

// Offer watchers for percentage price and ApplyOffer
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

// Functions for adding or deleting properties in form.details
function addNewProperty() {
    const name = String(newProperty.propertyName).trim().toLowerCase();
    const value = String(newProperty.propertyValue).trim();

    if (name == "null" || name == "undefined" || name == "") {
        alert("Especifique un nombre para la propiedad nueva.");
        newProperty.propertyName = null;
    } else if (value == "null" || value == "undefined" || value == "") {
        alert("Especifique un valor para la propiedad nueva.");
        newProperty.propertyValue = null;
    } else {
        form.details[name] = value;

        newProperty.propertyName = null;
        newProperty.propertyValue = null;
    }
}

function deleteProperty(key) {
    delete form.details[key];
}

// Form submittion
function submit() {
    form.normal_price = (form.price * 1.05).toFixed(2);
    form.sale_normal_price = (form.sale_price * 1.05).toFixed(2);
    form.show_price = form.sale ? form.sale_price : form.price;
    router.post("/admin/products-store", form, {
        forceFormData: true,
    });
}

//froala
const config = ref({
  // Image upload request
    imageUploadURL: '/admin/froala-upload',
    imageUploadParam: 'image',
    imageUploadParams: {
      froala: 'true',
      _token: page.props.csrf_token,
      path: 'products/',
    },
    imageUploadMethod: 'post',

    // Image remove request
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
    <Head title="Crear producto" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <p class="dark:text-white text-3xl font-bold">
                Crear nuevo producto
            </p>
            <ButtonNavigator
                href=""
                @click="useGoBack"
                text="Volver"
                type="button"
                method="get"
            />
        </div>

    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
      <FormKit
        type="form"
        submit-label="Guardar"
        @submit="submit"
      >
        <FormKit
          type="text"
          name="name"
          id="name"
          validation="required|length:1,65"
          maxlength="65"
          label="Nombre"
          placeholder="Tarjeta de video"
          v-model="form.name"
          autocomplete="off"
          autofocus
        />
        <FormKit
            type="file"
            label="Imagen"
            name="Imagen"
            id="image"
            accept=".jpg,.png,.jpeg,.svg,.gif"
            validation="required"
            v-model="form.images"
        />
        <FormKit
          type="number"
          name="price"
          id="price"
          label="Precio efectivo"
          v-model="price"
          placeholder="525"
          step="0.01"
          validation="number|required|min:0.01|max:999999"
          autocomplete="off"
        />
        <FormKit
          type="select"
          label="Marca"
          placeholder="Seleccionar..."
          :options="brands"
          name="brand_id"
          id="brand_id"
          validation="required"
          v-model="form.brand_id"
        />
        <FormKit
          type="select"
          label="Categoría"
          placeholder="Seleccionar..."
          :options="categories"
          name="category_id"
          id="category_id"
          validation="required"
          v-model="form.category_id"
        />
        <p class="text-xl dark:text-white font-bold text-base mb-3">Descripción</p>
        <froala
            id="edit"
            :tag="'textarea'"
            :config="config"
            v-model:value="form.description"
        ></froala>

        <FormKit
          type="text"
          name="warranty"
          id="warranty"
          label="Garantía"
          v-model="form.warranty"
          placeholder="1 año / No incluye"
          validation="required|length:1,40"
          maxlength="40"
        />
        <FormKit
          type="number"
          name="quantity"
          id="quantity"
          label="En existencia"
          v-model="form.quantity"
          placeholder="2"
          validation="number|required|min:0|max:999999"
          autocomplete="off"
        />
        <FormKit
          type="select"
          label="Estado"
          placeholder="Seleccionar..."
          :options="[
            'Nuevo',
            'Usado - como nuevo',
            'Usado',
          ]"
          name="condition"
          id="condition"
          validation="required"
          v-model="form.condition"
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

                <FormKit
                    type="checkbox"
                    label="Producto destacado"
                    name="featured"
                    v-model="form.featured"
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
          <div class="flex gap-3 items-center w-[13rem]">
            <FormKit
              type="number"
              name="percentage"
              id="percentage"
              label="Porcentaje de descuento"
              v-model="percentage"
              placeholder="10"
              validation="number|required|min:1|max:99"
            />
            <p class="text-lg dark:text-white">%</p>
          </div>
          <div class="mb-6">
            <p class="dark:text-white text-sm lg:text-lg mb-2">
              Precio efectivo:
              <span class="ml-2 text-sm lg:text-lg"> Q {{ price || 0 }} </span>
            </p>
            <p class="dark:text-white text-base lg:text-xl mb-2">
              Precio ofertado:
              <span class="ml-2 text-base lg:text-xl font-bold"> Q {{ calculatedPrice || 0 }} </span>
            </p>
          </div>
        </div>
      </FormKit>
    </div>
  </AuthenticatedLayout>
</template>
