<script setup>
import { router, Head, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { Icon } from "@iconify/vue";

//Stores
const cartStore = useCartStore();

if ( cartStore.cart.length < 1 ) {
    const basePath = window.location.origin;
    window.location.href = `${basePath}/carrito`;
}

//Store Functions
cartStore.reloadCart();
const shipping = cartStore.getShipping();
const selectedShipping = ref('prevPay')

const quantity = computed(() => {
    return cartStore.cart.reduce((total, current) => {
        return total + current.quantity;
    }, 0);
});

//cash subtotal
const subtotalCash = computed(() => {
    return cartStore.cart.reduce((total, current) => {
        return total + (Number(current.quantity) * Number(current.price));
    }, 0).toFixed(2);
});

//card subtotal
const subtotalCard = computed(() => {
    return cartStore.cart.reduce((total, current) => {
        return total + (Number(current.quantity) * Number(current.normal_price));
    }, 0).toFixed(2);
});

let savedShippingForm = JSON.parse( localStorage.getItem('shippingForm') );

const submit = () => {
    let data = {
        products: cartStore.cart,
        paymentMethod: cartStore.paymentMethod,
        paymentType: cartStore.paymentType,
        cardBrand: cartStore.cardBrand,
        dues: cartStore.dues,
        shipping_data: savedShippingForm,
        shipping: selectedShipping.value
    }

    console.log(data);

    router.post('/carrito/completar', data);
}

const shippingTotal = ref(shipping ? 'No incluído' : 'Incluído');
let subtotalCalc = cartStore.paymentMethod === 'cash' ? subtotalCash : subtotalCard;
const totalOrder = ref(subtotalCalc);

// Department watcher
watch(selectedShipping, ( newShippingMethod ) => {
    if ( newShippingMethod === 'cashShipping' ) {

        shippingTotal.value = `Q ${(Number(subtotalCalc.value) * 0.045).toFixed(2)}`;

        // totalOrder.value = 1;
    } else {
        shippingTotal.value = shipping ? 'No incluído' : 'Incluído';
        // totalOrder.value = cartStore.paymentMethod === 'cash' ? subtotalCash : subtotalCard;
    }
});
</script>
<template>
    <Head title="Metódo de envío" />
    <WebLayout>
        <div class="py-32 pb-16 container mx-auto lg:px-60">
            <h1 class="font-display text-[2rem] text-center sm:text-[3.05rem] xl:text-6xl 2xl:text-7xl uppercase mb-3">
                <span class="hidden md:inline">Metodo de </span>envio
            </h1>
            <div class="mx-4 bg-gray-100 p-3 rounded flex flex-col gap-3">
                <div class="col-span-2 xl:text-lg 2xl:text-xl">
                    Por favor escoge un método de envío
                </div>
                <div class="flex flex-wrap gap-5 items-center bg-white p-3 justify-center">
                    <div>
                        <input class="hidden" id="radio_1" type="radio" name="radio" checked value="prevPay" v-model="selectedShipping">
                        <label class="flex flex-col p-4 border-2 border-gray-400 cursor-pointer w-60 h-60 justify-center items-center" for="radio_1">
                            <Icon class="text-6xl text-center" icon="eva:car-fill" />
                            <span class="text-xl font-semibold uppercase">Pago previo</span>
                            <ul class="text-md mt-3">
                                <li v-if="cartStore.paymentMethod === 'cash'">Depósito/transferencia</li>
                                <li v-else>Pago con tarjeta</li>
                                <li>Envío por Cargo Expreso</li>
                            </ul>
                        </label>
                    </div>
                    <div v-if="cartStore.paymentMethod === 'cash' && savedShippingForm.department !== 'Guatemala'">
                        <input class="hidden" id="radio_2" type="radio" name="radio" checked value="cashShipping" v-model="selectedShipping">
                        <label class="flex flex-col p-4 border-2 border-gray-400 cursor-pointer w-60 h-60 justify-center items-center" for="radio_2">
                            <Icon class="text-6xl text-center" icon="eva:car-fill" />
                            <span class="text-xl font-semibold uppercase">Contra entrega</span>
                            <ul class="text-md mt-2">
                                <li>Efectivo (recargo 4.5%)</li>
                                <li>Envío por Cargo Expreso</li>
                            </ul>
                        </label>
                    </div>
                    <div v-if="savedShippingForm.department === 'Guatemala' && cartStore.paymentMethod === 'cash'">
                        <input class="hidden" id="radio_4" type="radio" name="radio" checked value="cashShippingGT" v-model="selectedShipping">
                        <label class="flex flex-col p-4 border-2 border-gray-400 cursor-pointer w-60 h-60 justify-center items-center" for="radio_4">
                            <Icon class="text-6xl text-center" icon="fa-solid:motorcycle" />
                            <span class="text-xl font-semibold uppercase">Contra entrega</span>
                            <ul class="text-md mt-2">
                                <li>Motorista (Ciudad capital)</li>
                                <li>No zonas rojas</li>
                                <li>No lugares expuestos</li>
                            </ul>
                        </label>
                    </div>
                    <div>
                        <input class="hidden" id="radio_3" type="radio" name="radio" checked value="noShipping" v-model="selectedShipping">
                        <label class="flex flex-col p-4 border-2 border-gray-400 cursor-pointer w-60 h-60 justify-center items-center" for="radio_3">
                            <Icon class="text-6xl text-center" icon="ri:home-office-fill" />
                            <span class="text-xl font-semibold uppercase">Recoger</span>
                            <ul class="text-md mt-2">
                                <li>Pagas y recibes en</li>
                                <li>Oficina Retalhuleu</li>
                            </ul>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex flex-col mx-4 bg-gray-100 p-3 rounded my-3">
                <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg border-b border-gray-200">
                    <span>Cantidad</span>
                    <span>{{ quantity }}</span>
                </span>
                <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg border-b border-gray-200">
                    <span>Envío</span>
                    <span>{{ shippingTotal }}</span>
                </span>
                <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg border-b border-gray-200">
                    <span>Subtotal</span>
                    <span>Q {{ cartStore.paymentMethod === 'cash' ? subtotalCash : subtotalCard }}</span>
                </span>
                <!-- <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg">
                    <span>Total</span>
                    <span>Q {{ totalOrder }}</span>
                </span> -->
            </div>
            <div class="mx-4 my-2 grid grid-cols-2 gap-2 lg:float-right">
                <Link href="/carrito/envio" as="a" type="button" class="text-white bg-[#474949] hover:shadow-lg hover:shadow-blue-400/100 duration-300 hover:bg-[#248ACB] focus:ring-none focus:outline-none rounded py-2.5 w-full lg:w-60 flex items-center justify-center">
                    <Icon class="text-sm lg:text-md mr-4" icon="ooui:arrow-previous-ltr" />
                    <span class="text-lg lg:text-lg">Regresar</span>
                </Link>
                <button @click="submit" type="button" class="text-white hover:shadow-lg hover:shadow-blue-400/100 duration-300 bg-[#248ACB] focus:ring-none focus:outline-none rounded py-2.5 w-full lg:w-60 flex items-center justify-center">
                    <span class="text-lg lg:text-lg">Completar</span>
                    <Icon class="text-sm lg:text-md ml-4" icon="ic:twotone-check" />
                </button>
            </div>
        </div>
    </WebLayout>
</template>
<style scoped>
input:checked + label {
    border-color: #248ACB;
    color: #248ACB;
	box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
