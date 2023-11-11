<script setup>
// Stores
const modalStore = useModalStore();
</script>

<template>
      <aside
        :class="modalStore.showCategoriesModal
          ? 'translate-x-0 ease-in-out transition-all duration-300 flex flex-col gap-5 bg-white h-full p-8 ps-7 lg:ps-8 w-4/5 sm:w-2/4 lg:w-2/5 overflow-auto z-40 fixed top-0 left-0'
          : '-translate-x-full ease-in-out transition-all duration-300 flex flex-col gap-5 bg-white h-full p-8 ps-7 lg:ps-8 w-4/5 sm:w-2/4 lg:w-2/5 overflow-auto z-40 fixed top-0 left-0'
        "
      >
        <p class="text-3xl uppercase font-display">Categorias</p>
        <ProductsCategoriesLinks />
      </aside>

</template>
