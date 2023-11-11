<script setup>
// Stores
const modalStore = useModalStore();
const productsFilterStore = useProductsFilterStore();

// Clear filters
const clearFilters = () => {
  productsFilterStore.emptyFilters();
  productsFilterStore.getProducts();
}
</script>

<template>
  <div
    :class="modalStore.showProductsFiltersModal
      ? 'translate-x-0 fixed h-full w-screen top-0 left-0 z-30 lg:hidden'
      : '-translate-x-full fixed h-full w-screen top-0 left-0 z-30 lg:hidden'
    "
  >
    <Backdrop :left-x="true" />
  </div>
  <aside
    :class="modalStore.showProductsFiltersModal
      ? 'translate-x-0 ease-in-out transition-all duration-400 flex flex-col gap-5 bg-white h-full p-8 w-3/4 min-[400px]:w-72 sm:w-2/4 md:w-2/5 overflow-y-auto z-40 fixed top-0 right-0 lg:h-max lg:p-6 lg:w-72 lg:sticky lg:top-[5.5rem] left:0 lg:border lg:border-gray-300 lg:rounded-lg lg:z-10 lg:hover:shadow-lg lg:hover:shadow-gray-500/100'
      : 'max-lg:translate-x-[200%] max-lg:ease-in-out max-lg:transition-all duration-300 flex flex-col gap-5 bg-white h-full p-8 w-3/4 min-[400px]:w-72 sm:w-2/4 md:w-2/5 overflow-y-auto z-40 fixed top-0 right-0 lg:h-max lg:p-6 lg:w-72 lg:sticky lg:top-[5.5rem] 2xl:top-[8rem] left:0 lg:border lg:border-gray-300 lg:rounded-lg lg:z-10 lg:hover:shadow-lg lg:hover:shadow-gray-500/100'"
  >
    <form @submit.prevent="productsFilterStore.getProducts()">
      <p class="text-3xl uppercase font-display sm:mr-0 lg:hidden">Filtros</p>

      <div class="flex flex-col gap-7 lg:gap-5 justify-start h-full">
        <ProductsFilterBrands />
        <ProductsFilterPrice />
        <ProductsFilterOrder />

        <div class="flex lg:flex-col lg:items-center gap-2 ">
          <Button
            title="Aplicar"
            iconName="mingcute:filter-fill"
            textColor="text-white"
            backgroundColor="bg-[#248ACB]"
            hover="hover:bg-[#1671AB] hover:shadow-sm hover:shadow-gray-500/100 duration-300"
            :leftIcon="true"
            :bigText="false"
            extra="rounded-lg w-full lg:py-2.5 lg:px-3 py-2.5 sm:py-3 px-2 xl:px-4 lg:w-max lg:text-sm"
            type="submit"
          />
          <Button
            title="Limpiar"
            iconName="mdi:trash-can"
            textColor="text-black"
            backgroundColor="bg-neutral-300"
            hover="hover:bg-[#C9C9C9] hover:shadow-sm hover:shadow-gray-500/100 duration-300"
            :leftIcon="true"
            :bigText="false"
            extra="rounded-lg w-full lg:py-2.5 lg:px-3 py-2.5 sm:py-3 px-2 xl:px-4 lg:w-max lg:text-sm"
            @click="clearFilters"
          />
        </div>
      </div>
    </form>
  </aside>
</template>
