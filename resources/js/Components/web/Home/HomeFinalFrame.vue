<script setup>
  const finalFrameStore = useFinalFrameStore();
</script>

<template>

  <div class="w-full cursor-default flex justify-around justify-center items-center my-10 px-5 flex-col sm:flex-row container mx-auto sm:gap-8">

    <div class="flex sm:ml-3 flex-col sm:w-[40%] w-full sm:text-start text-center lg:gap-4">
      <span
        class="text-xl md:text-2xl xl:text-3xl uppercase font-display"
      >
        {{ finalFrameStore.finalFrameList.message1 }}
      </span>
      <span
        class="text-3xl md:text-4xl xl:text-5xl 2xl:text-6xl text-[#248ACB] font-display uppercase"
      >
        {{ finalFrameStore.finalFrameList.message2 }}
      </span>
    </div>

    <div
      class="flex py-5 justify-center items-center"
    >
      <img src="/Logo.svg" class="h-[4.5rem] md:h-[6rem]" alt="">
    </div>

    <div
      class="sm:w-[60%] bounce-animation w-full flex justify-center items-center"
    >
      <img :src="`${finalFrameStore.finalFrameList.image}`" class="max-h-xs" />
    </div>
  </div>
</template>


<style scoped>
.bounce-animation{
  animation: boing 3s infinite ease-in-out;
}

@keyframes boing {
    0% {
        transform: translatey(1%);
    }
    50% {
        transform: translatey(-1%);
    }
    100% {
        transform: translatey(1%);
    }
}
</style>
