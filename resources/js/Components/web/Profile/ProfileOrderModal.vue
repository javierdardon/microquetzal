<script setup>
import { VueFinalModal } from "vue-final-modal";
import { Icon } from "@iconify/vue";

const props = defineProps({
    order: Object
});

const emit = defineEmits(["close"]);

const setBadgeColor = () => {
    if ( props.order.status === 'En proceso' ) {
        return 'bg-gray-600';
    }
    if ( props.order.status === 'En revisión' ) {
        return 'bg-yellow-500';
    }
    if ( props.order.status === 'Pagado' ) {
        return 'bg-blue-800';
    }
    if ( props.order.status === 'Enviado' ) {
        return 'bg-green-500';
    }
    if ( props.order.status === 'Entregado' ) {
        return 'bg-green-500';
    }
    if ( props.order.status === 'Entregado' ) {
        return 'bg-red-600';
    }
}

const badgeColor = setBadgeColor();
</script>
<template>
    <VueFinalModal
        content-transition="vfm-fade"
        class="flex text-xl text-white justify-center items-center"
        content-class="flex flex-col mx-4 bg-white rounded text-black p-5 w-[30rem]"
    >
        <div class="flex justify-between items-center">
            <p class="font-mono"><strong>{{ `Pedido # ${order.id}` }}</strong></p>
            <div class="flex items-center">
                <p class="font-mono mr-4"><strong>{{ order.created_at }}</strong></p>
                <a v-if="order.invoice" :href="`/${order.invoice}`" download="Factura">
                    <Icon icon="bxs:file-doc" class="text-4xl" color="gray" />
                </a>
                <button @click="emit(`close`)">
                    <Icon icon="ph:x-circle-fill" class="text-4xl" color="gray" />
                </button>
            </div>
        </div>
        <div class="mt-2 flex justify-between">
            <span :class="`text-white text-xs font-medium px-2.5 py-0.5 rounded-full ${badgeColor}`">
            {{ order.status }}
            </span>
            <p class="text-sm">{{ `x${props.order.quantity} - Q ${props.order.total}` }}</p>
        </div>
        <span class="my-5 border-b"></span>
        <div class="max-h-[200px] lg:max-h-[400px] xl:max-h-[500px] overflow-auto">
            <div v-for="product in props.order.products" class="flex items-center">
                <img :src="`/${product.image}`" class="w-20 h-20 object-cover rounded mr-5" />
                <p class="text-sm">{{ `${product.name} (${product.quantity})` }}</p>
            </div>
        </div>
        <span class="my-5 border-b"></span>
        <div class="text-sm flex justify-between">
            <div class="flex flex-col">
                <div>
                    <p>{{ `${props.order.department} - ${props.order.municipality}` }}</p>
                    <p>{{ props.order.address }}</p>
                </div>
                <div>
                    <p v-if="props.order.guide">{{ props.order.guide}}</p>
                    <p v-if="props.order.service">{{ props.order.service }}</p>
                </div>
                <div>
                    <p>Envío {{ props.order.total_shipping < 1 ? 'Incluído' : 'Q'+props.order.total_shipping }}</p>
                </div>
            </div>
            <div>
                <div>
                    <p>{{ props.order.paymentMethod === 'cash' ? 'Efectivo/Banco' : 'Tarjeta'}}</p>
                    <p>{{ props.order.paymentType === 'FULL' ? 'Al contado' : props.order.dues+' Cuotas' }}</p>
                    <p>{{ props.order.paymentType === 'FULL' ? '' : 'de Q '+props.order.duesQuantity }}</p>
                </div>
            </div>
        </div>
    </VueFinalModal>
</template>
