<script setup>
import { ModalsContainer, useModal } from "vue-final-modal";
import ProfileOrderModal from '@/Components/Web/Profile/ProfileOrderModal.vue';

const props = defineProps({
    order: Object
});

const orderModal = useModal({
    component: ProfileOrderModal,
    attrs: {
        order: props.order,
        onClose() {
            orderModal.close();
        },
    },
});
</script>

<template>
    <p class="font-mono">{{ `Pedido # ${order.id} | ${order.created_at}` }}</p>
    <div class="flex justify-between bg-gray-100 rounded-md mt-2 mb-5 py-3 px-7">
        <div class="hidden md:flex items-center overflow-auto mr-5">
            <template v-for="(product, index) in props.order.products">
                <img v-if="index < 6" :src="`/${product.image}`" class="w-20 h-20 object-cover rounded mr-5" />
            </template>
        </div>
        <div class="flex items-center content-center">
            <div class="flex flex-col items-center uppercase w-10 md:w-24">
                <p class="hidden md:block">Cantidad</p>
                <p>{{ props.order.quantity }}</p>
            </div>
            <div class="w-24 md:w-36 flex flex-col items-center bg-[#444444] text-white rounded py-1 mx-5 h-10 justify-center">
                <p>Q. {{ props.order.total - props.order.total_shipping }}</p>
            </div>
            <div>
                <IconButton icon="mdi:eye" color="[#248ACB]" textColor="text-white" class="p-2" @click="orderModal.open" />
            </div>
        </div>
    </div>
    <ModalsContainer />
</template>
