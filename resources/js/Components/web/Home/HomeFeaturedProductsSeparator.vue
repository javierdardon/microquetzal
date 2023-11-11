<script setup>
// Props
const props = defineProps({
  text: String,
});
</script>

<template>
  <div
    class="bg-[#248ACB] py-[2rem] md:py-[1rem] 2xl:py-[5.125rem]"
  >
    <p
      class="text-center cursor-default text-[2rem] md:text-[2rem] xl:text-[4rem] 2xl:text-[6rem] text-white font-display uppercase"
    >
      {{ props.text }}
    </p>

  </div>

</template>
