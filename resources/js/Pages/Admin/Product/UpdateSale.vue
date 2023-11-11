<script setup>
// Importations
import { Head, router } from "@inertiajs/vue3";
import { ref, computed, watch, reactive } from "vue";

// Props received from controller
const props = defineProps({
    product: Object,
});

// Offer reactive values
const applyOffer = ref(props.product.sale);
const price = ref(props.product.price);
const percentage = ref(props.product.percentage);
const calculatedPrice = ref(props.product.sale_price);

// Form sent to controller to save info
const form = reactive({
    id: props.product.id,
    sale: applyOffer,
    percentage: percentage,
    sale_price: calculatedPrice,
});

// Watchers for offer values
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

// Setting image background preview
const image = computed(() => {
    return `background-image: url(/${props.product.images})`;
});

// Form submittion
function submit() {
    router.post("/admin/products-update-sale", form);
}

const useGoBack = useBack;
</script>

<template>
    <Head title="Editar oferta" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5 overflow-x-auto">
            <h1 class="dark:text-white text-2xl font-bold">Editar Oferta</h1>
            <ButtonNavigator
                href=""
                @click="useGoBack"
                text="Volver"
                type="button"
                method="get"
            />
        </div>

        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
            <p class="dark:text-white text-xl my-7">{{ props.product.name }}</p>
            <div
                :style="image"
                class="rounded-lg h-48 lg:h-96 w-48 lg:w-96 bg-no-repeat bg-center bg-cover mb-4"
            ></div>

            <FormKit type="form" submit-label="Guardar" @submit="submit">
                <FormKit
                    type="checkbox"
                    label="Aplicar oferta"
                    name="sale"
                    v-model="applyOffer"
                    label-class="$reset dark:text-white ml-1"
                />

                <div v-if="applyOffer" class="my-8">
                    <p class="dark:text-white text-2xl mb-4">Oferta</p>
                    <div class="flex gap-3 items-center w-[13rem]">
                        <FormKit
                            type="number"
                            name="percentage"
                            id="percentage"
                            label="Porcentaje de descuento"
                            placeholder="10"
                            validation="number|required|min:1|max:99"
                            v-model="percentage"
                        />
                        <p class="text-lg dark:text-white">%</p>
                    </div>
                    <div class="mb-6">
                        <p class="dark:text-white text-sm lg:text-lg mb-2">
                            Precio original:
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
