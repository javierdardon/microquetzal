<script setup>
const props = defineProps({
  id: Number,
  name: String,
  images: String,
  cpu: String,
  gpu: String,
  ram: String,
  gama: Object,
  quantity: Number,
  sale: Boolean,
  percentage: Number,
  salePrice: String,
  price: String,
});

// Composables autoimported
const formattedPrice = useFormatPrice;
</script>

<template>
  <div
    data-aos="fade-up"
    :class="props.sale && props.quantity
      ? 'flex flex-col xl:flex-row h-full xl:h-[19rem] rounded-lg overflow-hidden border border-[#E4E4E4] hover:shadow-lg hover:shadow-blue-300 cursor-pointer ease-in duration-300 antialiased'
      : 'flex flex-col xl:flex-row h-full xl:h-[18.8rem] rounded-lg overflow-hidden border border-[#E4E4E4] hover:shadow-lg hover:shadow-gray-300/100 cursor-pointer ease-in duration-300 antialiased'
    "
  >

    <div class="h-52 md:h-64 xl:h-full xl:w-2/4 overflow-hidden relative">
      <span
        class="absolute top-2 -left-5 px-9 md:top-3 md:-left-12 bg-[#248CBA] text-[0.70rem] md:text-sm xl:text-base text-white md:px-14 shadow shadow-slate-800 rotate-[-20deg]"
        v-if="props.percentage && props.quantity"
      >
        Oferta -{{ props.percentage }}%
      </span>

      <span v-if="!props.quantity">
        <p class="absolute top-2 -left-7 px-9 md:top-3 md:-left-12 bg-gray-300 text-[0.70rem] md:text-sm xl:text-base md:px-14 shadow shadow-slate-800 rotate-[-20deg] z-10">
          Sin existencias
        </p>
      </span>
      <img
        :src="props.images"
        alt=""
        :class="!props.quantity 
        ? 'h-52 md:h-64 xl:h-full w-full object-cover brightness-50'
        : 'h-52 md:h-64 xl:h-full w-full object-cover'"
      />
    </div>
    
    <div class="flex flex-col my-auto gap-2 xl:gap-1 py-3 px-2 sm:py-4 sm:px-5 2xl:px-8 items-center xl:w-2/4 justify-evenly xl:h-full">
      <p class="text-xs sm:text-sm uppercase font-sans text-center">{{ props.name }}</p>

      <div class="text-[0.65rem] sm:text-xs flex flex-col gap-1 sm:gap-3 whitespace-brake-spaces">
        <p class="font-mono">
          <span class="font-bold">CPU:</span>
          {{ props.cpu }}
        </p>
        <p class="font-mono">
          <span class="font-bold">GPU:</span>
          {{ props.gpu }}
        </p>
        <p class="font-mono">
          <span class="font-bold">RAM:</span>
          {{ props.ram }}
        </p>
      </div>

      <div class="flex flex-col gap-1 items-center w-full sm:w-4/5 duration-100 ease-in hover:sm:w-[84%] my-0 sm:my-2 xl:my-0 xl:mt-2"> 
        <div class="h-3.5 xl:h-3 w-full bg-gray-300 rounded-xl hover:shadow hover:shadow-slate-800/100 duration-100 ease-in">
          <div :style="`width:${props.gama.percentage}%`" class=" h-3.5 xl:h-3 animated-bg rounded-xl"
          ></div>
        </div>

        <p class="font-mono text-[0.65rem] sm:text-xs">
          <span class="font-bold">Gama:</span>
          {{ props.gama.name }}
        </p>
      </div>
      <div class="flex flex-col" v-if="props.quantity">
        <p class="text-xs md:xs text-[#248ACB] text-center font-bold font-sans">Precio</p>
        <p class="text-sm md:text-base 2xl:text-lg text-[#248ACB] text-center font-bold font-sans -mt-1" v-if="!props.sale">
            Q {{ formattedPrice(props.price) }}
        </p>
        <p v-if="props.sale" class="text-sm md:text-base 2xl:text-lg text-center font-bold font-sans bg-[#248ACB] text-white px-2 rotate-[-2deg]">
              Q {{ formattedPrice(props.salePrice) }}
        </p>
      </div>
    </div>    
    
  </div>
</template>

<style scoped>
.animated-bg
{
  background: linear-gradient(
    -225deg,
    #248ACB 0%,
    #9142F8 25%,
    #ED63F9 50%,
    #9142F8 75%,
    #248ACB 100%
  );
  background-size: 200% auto;
  animation: textclip 3s linear infinite;
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}
</style>