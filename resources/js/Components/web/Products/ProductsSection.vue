<script setup>
import { Link } from '@inertiajs/vue3';

// Stores
const productsStore = useProductsStore();
</script>


<template>
  <div
    v-if="productsStore.products.length"
    class="px-4 pb-4 bg-white grow w-full gap-y-7 2xl:gap-y-9 gap-x-3 sm:gap-x-8 2xl:gap-x-0 justify-evenly items-start grid grid-cols-2 sm:grid-cols-3"
  >
    <div
      v-for="product in productsStore.products"
      :class="productsStore.products.length > 3 ? 'flex self-stretch w-full' : 'flex self-stretch w-full lg:py-14'"
      :key="product.id"
    >

      <Link class="h-full w-full" :href="route('web.products.view', product.id)">
        <Product
          :name="product.name"
          :price="product.price"
          :images="`/${product.images}`"
          :warranty="product.warranty"
          :code="product.id"
          :sale="product.sale"
          :quantity="product.quantity"
          :percentage="product.percentage"
          :sale-price="product.sale_price"
        />
      </Link>
    </div>
  </div>
  <div class="w-full py-32 text-center lg:py-52 flex items-center justify-center" v-else>
    <p class="text-2xl text-gray-400 font-bold">No hay productos para mostrar...</p>
  </div>
</template>
