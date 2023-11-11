<script setup>
import { useToast } from "vue-toastification";

const props = defineProps({
    item: Object
});

//Stores
const cartStore = useCartStore();

// Vue Const
const toast = useToast();

// Functions
const addProductToCard = ( id, type, quantity ) => {
    const { status, message } = cartStore.addToCart(id, type, quantity);

    if ( status === 'error' ) {
        toast.error(message)
    }
}
</script>

<template>
    <div class="flex justify-between bg-gray-100 rounded-md lg:my-3 xl:my-5 p-1 lg:p-3 m-5">
        <div class="flex items-center">
            <img :src="`/${item.image}`" class="w-16 h-16 xl:w-20 xl:h-20 object-cover rounded lg:mr-3 xl:mr-5" />
            <p class="text-xs xl:text-sm overflow hidden lg:inline">{{ item.name }}</p>
        </div>
        <div class="flex items-center">
            <div class="flex flex-col items-center uppercase lg:w-16 xl:w-24 px-5 lg:px-0">
                <p class="lg:hidden xl:block hidden lg:inline">Cantidad</p>
                <p>{{ item.quantity }}</p>
            </div>
            <IconButton icon="ph:minus-bold" color="[#248ACB]" textColor="text-white" class="lg:ml-5 xl:ml-14" @click="cartStore.subtractFromCart(item.id, item.type)" />
            <div class="w-24 lg:w-36 flex flex-col items-center bg-[#444444] text-white rounded py-1 mx-5">
                <p class="text-sm">Q. {{ item.price * item.quantity }}</p>
            </div>
            <IconButton icon="tabler:plus" color="[#A0CB24]" textColor="text-white" class="mr-2 lg:mr-5 xl:mr-14" @click="addProductToCard(item, item.type, item.max_quantity)" />
            <div class="border-l border-gray-400 w-12 lg:w-16 flex flex-col items-center">
                <IconButton icon="mdi:trash" color="red-600" textColor="text-white" @click="cartStore.deleteFromCart(item.id, item.type)"/>
            </div>
        </div>
    </div>
</template>
