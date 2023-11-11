<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, watch } from 'vue';
import { Icon } from "@iconify/vue";
import { useToast } from "vue-toastification";
import duesModal from '@/Components/Web/Cart/duesModal.vue';
import { ModalsContainer, useModal } from "vue-final-modal";

const cartStore = useCartStore();
const shipping = cartStore.getShipping();
cartStore.reloadCart();

// Vue Const
const toast = useToast();

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

const quantity = computed(() => {
    return cartStore.cart.reduce((total, current) => {
        return total + current.quantity;
    }, 0);
});

if ( cartStore.paymentMethod === 'cash' ) {
    cartStore.dues = null;
    localStorage.setItem('dues', null);
    cartStore.cardBrand = null;
    localStorage.setItem('cardBrand', null);
    cartStore.paymentType = 'FULL';
}

if ( cartStore.paymentMethod === 'card' ) {
    if ( cartStore.cardBrand === null ) {
        cartStore.paymentMethod = 'cash';
        cartStore.paymentType = 'FULL';
    }

    if ( cartStore.paymentType === 'DUES' && cartStore.dues === null ) {
        cartStore.paymentMethod = 'card';
        cartStore.paymentType = 'FULL';
    }
}

// Functions
const addProductToCard = ( id, type, quantity ) => {
    const { status, message } = cartStore.addToCart(id, type, quantity);

    if ( status === 'error' ) {
        toast.error(message)
    }
}

watch(
  () => cartStore.paymentMethod,
  (newPaymentMethod) => {
    localStorage.setItem('paymentMethod', newPaymentMethod);

    if ( newPaymentMethod === 'cash' ) {
        cartStore.dues = null;
        localStorage.setItem('dues', null);
        cartStore.cardBrand = null;
        localStorage.setItem('cardBrand', null);
        cartStore.paymentType = 'FULL';
    }
  }
)

const cardDuesModal = useModal({
    component: duesModal,
    attrs: {
        clickToClose: false,
        escToClose: false,
        onClose() {
            cardDuesModal.close();
        },
    },
});

const openModal = () => {
    cardDuesModal.open()
}
</script>

<template>
    <Head>
        <title>Carrito</title>
        <meta name="description" content="Carrito de compras | Mira los productos de tu carrito">
    </Head>
    <WebLayout>
        <div class="py-32 pb-16 container mx-auto lg:px-60">
            <h1 class="font-display text-[2rem] text-center sm:text-[3.05rem] xl:text-6xl 2xl:text-7xl uppercase mb-3">
                Carrito
            </h1>
            <template v-if="cartStore.cart.length">
                <div class="grid grid-cols-2 gap-3 mx-4 bg-gray-100 p-3 rounded">
                    <div class="col-span-2 xl:text-lg 2xl:text-xl">
                        Método de pago
                    </div>
                    <div>
                        <input class="hidden" id="radio_1" type="radio" name="paymentMethod" value="cash" v-model="cartStore.paymentMethod">
                        <label class="flex gap-1 items-center justify-center p-3 border-2 border-gray-400 rounded cursor-pointer bg-white text-gray-500" for="radio_1">
                            <Icon icon="clarity:dollar-solid" class="xl:text-xl 2xl:text-2xl"/>
                            <span class="text-xs font-bold text-center xl:text-md 2xl:text-lg">Efectivo/Bancario</span>
                        </label>
                    </div>
                    <div>
                        <input class="hidden" id="radio_2" type="radio" name="paymentMethod" value="card" v-model="cartStore.paymentMethod">
                        <label @click="openModal()" class="flex gap-1 items-center justify-center p-3 border-2 border-gray-400 rounded cursor-pointer bg-white text-gray-500" for="radio_2">
                            <Icon icon="fluent:card-ui-20-filled" class="xl:text-xl 2xl:text-2xl"/>
                            <span class="text-xs font-bold text-center xl:text-md 2xl:text-lg">Tarjeta</span>
                        </label>
                    </div>
                </div>
                <div class="flex flex-col gap-3 mx-4 bg-gray-100 p-3 rounded my-3 xl:text-lg 2xl:text-xl">
                    <div>
                        Artículos
                    </div>
                    <div v-for="item in cartStore.cart" class="p-2 flex xl:gap-8 bg-white rounded justify-between lg:items-center">
                        <img :src="`/${item.image}`" class="w-16 h-16 object-cover rounded" />
                        <div class="flex flex-col w-full">
                            <span class="text-xs font-bold xl:text-md 2xl:text-lg">{{ item.name }}</span>
                            <div class="flex justify-between">
                                <span class="text-sm mt-3 2xl:text-lg">Q {{ cartStore.paymentMethod === 'cash' ? item.price : item.normal_price }}</span>
                                <div class="mt-3 flex items-center">
                                    <button
                                      @click="cartStore.subtractFromCart(item.id, item.type)"
                                      type="button"
                                      class="text-white bg-gray-400 hover:bg-gray-800 focus:ring-0 focus:outline-none rounded text-sm 2xl:text-xl p-1 text-center inline-flex items-center">
                                        <Icon icon="tdesign:plus" />
                                    </button>
                                    <span class="mr-2 mx-2">
                                        {{ item.quantity }}
                                    </span>
                                    <button
                                      @click="addProductToCard(item, item.type, item.max_quantity)"
                                      type="button"
                                      class="text-white bg-[#248ACB] hover:bg-sky-900 focus:ring-0 focus:outline-none rounded text-sm 2xl:text-xl p-1 text-center inline-flex items-center">
                                        <Icon icon="tdesign:plus" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <Icon class="cursor-pointer" icon="teenyicons:x-solid" @click="cartStore.deleteFromCart(item.id, item.type)"/>
                    </div>
                </div>
                <div class="flex flex-col mx-4 bg-gray-100 p-3 rounded my-3">
                    <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg border-b border-gray-200">
                        <span>Cantidad</span>
                        <span>{{ quantity }}</span>
                    </span>
                    <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg border-b border-gray-200">
                        <span>Envío</span>
                        <span>{{ shipping ? 'No incluído' : 'Incluído' }}</span>
                    </span>
                    <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg">
                        <span>Subtotal</span>
                        <span>Q {{ cartStore.paymentMethod === 'cash' ? subtotalCash : subtotalCard }}</span>
                    </span>
                </div>

                <div class="mx-4 my-2 lg:float-right">
                    <Link href="/carrito/envio" as="a" type="button" class="text-white hover:shadow-lg hover:shadow-blue-400/100 duration-300 bg-[#248ACB] focus:ring-none focus:outline-none rounded py-2.5 w-full lg:w-60 flex items-center justify-center">
                        <span class="text-2xl lg:text-lg">Continuar</span>
                        <Icon class="text-xl lg:text-md ml-4" icon="ooui:arrow-next-ltr" />
                    </Link>
                </div>
            </template>
            <div v-else class="flex flex-col items-center lg:py-14 xl:py-24">
                <p class="font-display text-[1.5rem] sm:text-[2rem] md:text-[2.5rem] xl:text-2xl 2xl:text-4xl uppercase mb-10">
                    Tu carrito esta vacio
                </p>
                <img src="/among-cart.svg" class="w-20 lg:w-36 xl:w-48" />
            </div>
        </div>
        <ModalsContainer />
    </WebLayout>
</template>
<style scoped>
input:checked + label {
    border-color: #248ACB;
    color: #248ACB;
	box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
