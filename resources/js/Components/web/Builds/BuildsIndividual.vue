<script setup>
import { ref } from "vue";
import { Icon } from "@iconify/vue";
import { useToast } from "vue-toastification";

// Vue Props
const props = defineProps({
    build: Object,
});
// Vue Refs
const loading = ref(false);

//Stores
const modalStore = useModalStore();
const cartStore = useCartStore();

// Vue Const
const toast = useToast();

// Vue Computed
const priceWithDecimals = computed(() => {
    return Number(props.build.price).toFixed(2);
});

// Composables autoimported
const formattedPrice = useFormatPrice;

// Functions
const addProductToCard = ( id, type, quantity ) => {
    const { status, message } = cartStore.addToCart(id, type, quantity);

    if ( status === 'success' ) {
        toast.success(message)
    } else {
        toast.error(message)
    }
}
</script>

<template>
    <div class="mt-5 mb-14 md:mb-20 cursor-default" v-if="loading">
        <LoadingScreen />
    </div>

    <div class="container mx-auto h-full">
        <div
            class="h-full cursor-default flex flex-col md:flex-row gap-8 items-center md:justify-evenly md:gap-x-8 lg:gap-8 xl:gap-14"
            v-if="!loading"
        >
            <div class="relative h-full md:w-[50%] flex justify-end">
                <img
                    :src="`/${props.build.images}`"
                    alt=""
                    class="max-w-xs lg:max-w-sm max-h-xs lg:max-h-sm object-cover"
                />
            </div>

            <div
                class="flex flex-col items-center md:items-start gap-3 md:gap-6 md:w-[50%]"
            >
                <p
                    class="font-mono uppercase text-xs text-gray-400 tracking-[.60em] lg:text-sm text-center md:text-start"
                >
                    pc combos
                </p>
                <p
                    class="text-center px-5 md:text-start md:px-0 md:w-[23ch] lg:text-xl uppercase"
                >
                    {{ props.build.name }}
                </p>

                <div
                  class="flex flex-col py-1 lg:py-0"
                  v-if="props.build.quantity"
                >
                    <p
                      v-if="props.build.sale"
                      class="text-[0.65rem] lg:text-xs text-gray-400 text-center md:text-start mb-1"
                    > 
                        Antes: Q {{ formattedPrice(props.build.price) }} <span class="text-[#248ACB]">&nbsp;{{ props.build.percentage }}% de descuento</span>
                    </p>

                    <div
                      class="grid grid-cols-2 rounded-lg md:rounded-s-none overflow-hidden"
                      v-if="props.build.sale"
                    >
                        <div class="flex flex-col px-5 bg-[#282929] text-white text-center py-2 ">
                            <span class="text-[0.65rem] lg:text-xs ">Precio normal</span>
                            <span class="text-xl lg:text-3xl font-bold font-sans">Q {{ formattedPrice(props.build.sale_normal_price) }}</span>
                        </div>
                        <div class="flex flex-col px-5 animated-bg text-white text-center justify-center">
                            <span class="text-[0.60rem] lg:text-xs">Efectivo o depósito</span>
                            <span class="text-xl lg:text-3xl font-bold font-sans">Q {{ formattedPrice(props.build.sale_price) }}</span>
                        </div>
                    </div>    
                    <div
                      class="grid grid-cols-2 rounded-lg md:rounded-s-none overflow-hidden"
                      v-else
                    >
                        <div class="flex flex-col px-5 bg-[#282929] text-white text-center py-2">
                            <span class="text-[0.65rem] lg:text-xs">Precio normal</span>
                            <span class="text-xl lg:text-3xl font-bold font-sans">Q {{ formattedPrice(props.build.normal_price) }}</span>
                        </div>

                        <div class="flex flex-col px-5 animated-bg text-white text-center justify-center">
                            <span class="text-[0.60rem] lg:text-xs">Efectivo o depósito</span>
                            <span class="text-xl lg:text-3xl font-bold font-sans">Q {{ formattedPrice(props.build.price) }}</span>
                        </div>
                    </div>                   
                </div>

                <div class="flex flex-col" v-else>
                    <p class="text-2xl lg:text-3xl text-gray-500 text-center font-bold font-sans">Sin existencias</p>
                    <span class="text-xs lg:text-sm text-gray-400 text-center md:text-start">Precio normal: Q {{ formattedPrice(props.build.price) }}</span>
                </div>
                <div class="flex items-center gap-4 xl:gap-6">
                    <div
                        class="flex flex-col items-center md:items-start text-xs text-gray-500 lg:text-sm"
                    >
                        <div>
                            <button
                                v-if="
                                    props.build.visacuotas &&
                                    props.build.quantity
                                "
                                class="font-mono underline cursor-pointer text-sm mb-2 flex gap-1   items-center"
                                @click="modalStore.togglePaymentsModal"
                            >   
                                Pago en cuotas
                                <Icon
                                  icon="grommet-icons:mastercard"
                                  class="w-5 h-5"
                                />
                                <Icon
                                  icon="fa-brands:cc-visa"
                                  class="w-5 h-5"
                                />
                            </button>
                            <p class="font-mono text-sm mb-2" v-else>
                                No disponible en cuotas
                            </p>
                        </div>
    
                        <p class="font-mono">
                            Código de Combo: {{ props.build.id }}
                        </p>
                        <p class="font-mono">
                            Garantía: {{ props.build.warranty }}
                        </p>
                        <p class="font-mono">
                            En existencia: {{ props.build.quantity }}
                        </p>
                        <div class="flex items-center gap-1">
                            <Icon
                                v-if="props.build.shipping"
                                icon="material-symbols:local-shipping-sharp"
                            />
                            <p v-if="props.build.shipping" class="font-mono">
                                Envío incluído
                            </p>
                            <p class="font-mono" v-else>No incluye envío</p>
                        </div>
                        <div
                            class="flex items-center gap-1"
                            v-if="props.build.featured"
                        >
                            <Icon icon="twemoji:star" />
                            <p class="font-mono">Destacado</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-center text-sm mb-1">Gama</p>
                        <BuildsElipsisGamma :gamma="props.build.gama" />
                    </div>
                </div>
                <div class="flex gap-3">
                    <Button
                        v-if="props.build.quantity"
                        title="Añadir al carrito"
                        iconName="ion:cart-sharp"
                        textColor="text-white"
                        backgroundColor="bg-[#282929]"
                        hover="hover:bg-[#474949] hover:shadow-lg hover:shadow-gray-500/100 duration-300"
                        :leftIcon="true"
                        :bigText="false"
                        extra="rounded-lg py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
                        @click="addProductToCard(props.build, 'pc', props.build.quantity)"
                    />
                    <a href="#specs" class="flex items-center justify-center gap-2 sm:text-sm lg:text-base cursor-pointer text-white bg-[#248ACB] hover:bg-[#474949] hover:shadow-lg hover:shadow-gray-500/100 duration-300 rounded-lg py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4 undefined">
                        Ver detalles
                    </a>
                </div>
            </div>
        </div>

        <div
            v-if="!loading"
            :class="
                modalStore.showPaymentsModal
                    ? 'translate-x-0 fixed h-full w-screen top-0 left-0 z-30 flex items-center justify-center'
                    : '-translate-x-full fixed h-full w-screen top-0 left-0 z-30 flex items-center justify-center'
            "
        >
            <Backdrop />
            <ProductsPayments
                :name="props.build.name"
                :price="
                    props.build.sale
                        ? Number(props.build.sale_normal_price)
                        : Number(props.build.normal_price)
                "
                :class="
                    modalStore.showPaymentsModal
                        ? `opacity-100 duration-300`
                        : `opacity-0 duration-200`
                "
            />
        </div>
    </div>
</template>

<style scoped>
.animated-bg
{
  background: linear-gradient(
    -225deg,
    #248ACB 0%,
    #9142F8 25%,
    #248ACB 50%,
    #9142F8 75%,
    #248ACB 100%
  );
  background-size: 1000% auto;
  animation: textclip 18s linear infinite;
}

@keyframes textclip {
  to {
    background-position: 500% center;
  }
}
</style>
