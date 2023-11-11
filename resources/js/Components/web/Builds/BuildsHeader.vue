<script setup>
// Stores declarations
const modalStore = useModalStore();
const buildsFilterStore = useBuildsFilterStore();

</script>

<template>

  <div class="flex flex-col gap-3.5 lg:gap-y-4 pb-4 lg:pb-0">
    <div
      class="flex flex-wrap md:flex-nowrap justify-center md:justify-start lg:justify-end items-center gap-2 sm:gap-4 md:gap-8"
    >
      <h1
        class="font-display text-[2.75rem] sm:text-[3.05rem] xl:text-6xl 2xl:text-7xl cursor-default bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-blue-500">EQUIPOS</h1
      >
      <div
        class="flex w-full items-center justify-end lg:w-max lg:flex-grow gap-3 lg:gap-5"
      >
        <Button
          title="Ofertas"
          icon-name="tabler:star-filled"
          :icon-color="buildsFilterStore.sale ? 'text-[#FAB615]' : 'text-white'"
          text-color="text-white"
          background-color="bg-[#248ACB]"
          hover="hover:bg-[#1671AB] hover:shadow-lg hover:shadow-blue-400/100 duration-300"
          :big-text="false"
          :left-icon="true"
          extra="rounded-lg hidden lg:flex lg:px-3 py-2.5 sm:py-3 px-2 xl:px-4"
          @click="buildsFilterStore.filterBySale"
        />
        <BuildsSearchBar
          width="w-full xl:w-[32rem]"
        />
      </div>
    </div>

    <div class="sticky top-20 left-0 right-0 flex flex-wrap gap-2 lg:hidden">
        <Button
          class="grow"
          title="Ofertas"
          icon-name="tabler:star-filled"
          :icon-color="buildsFilterStore.sale ? 'text-[#FAB615]' : 'text-white'"
          text-color="text-white"
          background-color="bg-[#248ACB]"
          hover="hover:bg-[#1671AB]"
          :big-text="false"
          :left-icon="true"
          extra="rounded-lg py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
          @click="buildsFilterStore.filterBySale"
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
          @click="modalStore.toggleBuildsFiltersModal"
          extra="rounded-lg py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
        />
    </div>
  </div>
</template>
