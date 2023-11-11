<script setup>
// Stores
const modalStore = useModalStore();
const productsFilterStore = useProductsFilterStore();
</script>

<template>

  <div class="flex flex-col gap-3.5 lg:gap-y-0 pb-4 lg:pb-0 xl:pb-2">
    <div
      class="flex flex-wrap md:flex-nowrap justify-center sm:justify-start items-center gap-2 sm:gap-4 md:gap-8 "
    >
      <h1
        class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-pink-500 font-display select-none text-[2.75rem] sm:text-[3.05rem] xl:text-6xl 2xl:text-7xl cursor-default">PRODUCTOS</h1
      >
      <div
        class="flex w-full items-center lg:w-max lg:flex-grow gap-3"
      >
        <Button
          class="hidden lg:flex"
          title="Categorias"
          icon-name="iconamoon:category-fill"
          text-color="text-white"
          background-color="bg-[#282929]"
          hover="hover:bg-[#474949] hover:shadow-lg hover:shadow-gray-400/100 duration-300"
          :big-text="false"
          :left-icon="true"
          @click="modalStore.toggleCategoriesModal"
          extra="rounded-lg py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
        />
        <Button
          class="hidden lg:flex"
          title="Ofertas"
          icon-name="tabler:star-filled"
          :icon-color="productsFilterStore.sale ? 'text-[#FAB615]' : 'text-white'"
          text-color="text-white"
          background-color="bg-[#248ACB]"
          hover="hover:bg-[#1671AB] hover:shadow-lg hover:shadow-blue-400/100 duration-300"
          :big-text="false"
          :left-icon="true"
          extra="rounded-lg py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
          @click="productsFilterStore.filterBySale"
        />
        <ProductsSearchBar
          width="w-full lg:w-max lg:grow"
        />
      </div>
    </div>

    <div class="flex flex-wrap gap-2 lg:hidden">
        <Button
          class="grow"
          title="Categorias"
          icon-name="iconamoon:category-fill"
          text-color="text-white"
          background-color="bg-[#282929]"
          hover="hover:bg-[#474949]"
          :big-text="false"
          :left-icon="true"
          @click="modalStore.toggleCategoriesModal"
          extra="rounded-lg lg:py-2 py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
        />

        <Button
          class="grow"
          title="Ofertas"
          icon-name="tabler:star-filled"
          :icon-color="productsFilterStore.sale ? 'text-[#FAB615]' : 'text-white'"
          text-color="text-white"
          background-color="bg-[#248ACB]"
          hover="hover:bg-[#1671AB]"
          :big-text="false"
          :left-icon="true"
          extra="rounded-lg py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
          @click="productsFilterStore.filterBySale"
        />

        <Button
          class="grow"
          title="Filtrar"
          icon-name="mingcute:filter-fill"
          text-color="text-black"
          background-color="bg-[#ECECEC]"
          hover="hover:bg-[#C9C9C9]"
          :big-text="false"
          :left-icon="true"
          @click="modalStore.toggleProductsFiltersModal"
          extra="rounded-lg py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
        />
    </div>
  </div>

    <ProductsCategoriesModal />

</template>
