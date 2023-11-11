<script setup>
import { VueFinalModal } from "vue-final-modal";
import { Icon } from "@iconify/vue";
import { submitForm } from '@formkit/vue';
import { watch } from "vue";

const cartStore = useCartStore();
const formattedPrice = useFormatPrice;

const emit = defineEmits(["close"]);
const cardOptions = ['VISA', 'MASTERCARD'];

//card subtotal
const subtotalCard = computed(() => {
    return cartStore.cart.reduce((total, current) => {
        return total + (Number(current.quantity) * Number(current.normal_price));
    }, 0).toFixed(2);
});

const quotes = getInterest( Number(subtotalCard.value) );

const dueOptions = ref([]);

quotes.forEach(quote => {
    dueOptions.value.push({
        label: `${quote.quantity} cuotas de Q ${formattedPrice(quote.monthly)}`,
        value: quote.quantity
    });
});

// FormKit configurations (style)
const config = {
    classes: {
        input: '$reset appearance-none bg-white rounded text-black focus:outline-none focus:ring-0 focus:shadow-none w-full text-sm lg:text-base',
        label: '$reset block mb-2 font-bold text-sm lg:text-base text-black',
        outer: '$reset mb-4 lg:mb-6 grow',
        message: '$reset text-gray-600 text-xs',
        ui: '$reset text-gray-600 text-xs',
        wrapper: '$reset',
        submit: 'mt-2',
    }
};

const saveInfo = () => {
    if ( cartStore.paymentType === 'DUES' ) {
        submitForm('cardConfiguration');

        if ( cartStore.cardBrand === null || cartStore.dues === null ) {
            return;
        }

        emit(`close`)
    } else {
        if ( cartStore.cardBrand === null ) {
            return;
        }
        emit(`close`)
    }

}

watch(
  () => cartStore.paymentType,
  (newPaymentType) => {
    if (newPaymentType === 'FULL') {
        localStorage.setItem('cardBrand', null);
        cartStore.cardBrand = null;
        localStorage.setItem('dues', null);
        cartStore.dues = null;
    }
    localStorage.setItem('paymentType', newPaymentType);
  }
)

watch(
  () => cartStore.cardBrand,
  (newCardBrand) => {
    localStorage.setItem('cardBrand', newCardBrand);
  }
)

watch(
  () => cartStore.dues,
  (newDues) => {
    localStorage.setItem('dues', newDues);
  }
)
</script>

<template>
    <VueFinalModal
        content-transition="vfm-fade"
        class="flex text-xl text-white justify-center items-center"
        content-class="flex flex-col items-center mx-4 bg-white rounded text-black p-5 w-[30rem]"
    >
        <div class="border-b border-gray-200 w-full flex flex-col items-center gap-2 pb-3 lg:text-2xl">
            <p>Pago con tarjeta</p>
            <div class="flex items-center">
                <Icon class="w-16 h-16 border-e border-gray-200 pe-4" icon="logos:visa"/>
                <Icon class="w-16 h-16 ps-4" icon="logos:mastercard"/>
            </div>
        </div>
        <div class="flex justify-start my-7">
            <p class="text-xl lg:text-2xl font-semibold text-start">
                Selecciona el tipo de pago
            </p>
        </div>
        <div class="flex flex-col gap-4 w-full mb-7">
            <div>
                <input class="hidden" id="paymentTypeRadio1" type="radio" name="paymentType" value="FULL" v-model="cartStore.paymentType">
                <label class="flex gap-1 items-center justify-center p-3 border-2 border-gray-400 rounded cursor-pointer bg-white text-gray-500" for="paymentTypeRadio1">
                    <span class="font-bold text-center text-sm 2xl:text-lg">Pago al contado</span>
                    <Icon icon="clarity:dollar-bill-solid" class="xl:text-xl 2xl:text-2xl"/>
                </label>
            </div>
            <div>
                <input class="hidden" id="paymentTypeRadio2" type="radio" name="paymentType" value="DUES" v-model="cartStore.paymentType">
                <label class="flex gap-1 items-center justify-center p-3 border-2 border-gray-400 rounded cursor-pointer bg-white text-gray-500" for="paymentTypeRadio2">
                    <span class="font-bold text-center text-sm 2xl:text-lg">VisaCuotas o MasterCuotas</span>
                    <Icon icon="fluent:card-ui-20-filled" class="xl:text-xl 2xl:text-2xl"/>
                </label>
            </div>
        </div>
        <div class="w-full mb-8">
            <FormKit
                type="form"
                :actions="false"
                id="cardConfiguration"
                @submit="saveInfo"
            >
                <FormKit
                    :options="cardOptions"
                    v-model="cartStore.cardBrand"
                    type="select"
                    :config="config"
                    name="cardOptions"
                    label="Tipo de tarjeta"
                    validation="required"
                    placeholder="Seleccionar..."
                />
                <FormKit
                    v-if="cartStore.paymentType === 'DUES'"
                    :options="dueOptions"
                    v-model="cartStore.dues"
                    type="select"
                    :config="config"
                    name="cardDues"
                    label="Cantidad de cuotas"
                    validation="required"
                    placeholder="Seleccionar..."
                />
            </FormKit>
        </div>
        <button @click="saveInfo" class="text-white hover:shadow-lg hover:shadow-blue-400/100 duration-300 bg-[#248ACB] focus:ring-none focus:outline-none rounded py-2.5 w-full lg:w-60 flex items-center justify-center">
            <span class="text-lg lg:text-lg">Guardar</span>
            <Icon class="text-md ml-4" icon="ic:twotone-check" />
        </button>
    </VueFinalModal>
</template>

<style scoped>
input:checked + label {
    border-color: #248ACB;
    color: #248ACB;
	box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
