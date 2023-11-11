<script setup>
import { Icon } from '@iconify/vue';
import { Link } from '@inertiajs/vue3';

// Stores
const modalStore = useModalStore();
const productsFilterStore = useProductsFilterStore();

</script>


<template>
  <ul class="flex flex-col overflow-y-scroll relative w-full">
    <Link
      v-for="(category, index) in productsFilterStore.categories"
      @click="modalStore.closeAllModals"
      :key="category.id"
      :href="productsFilterStore.categoryLinks[index]"
    >
      <div
        class="py-3 ps-2 pe-3 border-b border-slate-300 flex justify-between items-center hover:bg-gray-300 text-sm lg:text-lg lg:hover:text-lg cursor-pointer w-full flex"
      >
        <p class="truncate">
          {{ category.name }}
        </p>
        <Icon
          icon="eva:arrow-right-fill"
          class="text-slate-600 w-4 h-4 ms-2"
        />
        </div>
    </Link>
  </ul>
</template>
