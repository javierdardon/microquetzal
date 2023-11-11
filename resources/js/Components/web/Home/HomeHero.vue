<script setup>
// Store declaration
const HeroStore = useHeroStore();

</script>


<template>
  <div class="cursor-default w-full min-h-screen px-2 md:px-[5rem] xl:pt-16 bg-[#282929] flex items-center justify-center">
    <div class="h-full max-w-[1500px] justify-center flex flex-col items-center md:flex-row md:gap-x-4">
      <div class="flex-1 flex flex-col text-center md:text-left md:pr-[1rem] uppercase">
          <h1 class="font-display text-[1.5rem] md:text-[1rem] lg:text-[2rem] xl:text-[2rem] text-[#248ACB]">{{HeroStore.HeroList.message1}}</h1>
          <p class="font-display text-[3rem] md:text-[2.5rem] lg:text-[3rem] xl:text-[4rem] text-[#248ACB]">{{HeroStore.HeroList.message2}}</p>
          <p class="font-display text-[1.5rem] md:text-[1rem] lg:text-[2rem] xl:text-[2rem] text-white">{{HeroStore.HeroList.message3}}</p>
          <p class="font-display text-[3rem] md:text-[2.5rem] lg:text-[3rem] xl:text-[4rem] text-white">{{HeroStore.HeroList.message4}}</p>
      </div>
      <div class="px-5 sm:px-0">
        <img
          class="max-h-72 md:max-h-[40rem]"
          alt="gaming-p"
          :src="HeroStore.HeroList.image"
        >
      </div>
    </div>
  </div>
</template>
