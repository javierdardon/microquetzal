<script setup>
import { Link } from "@inertiajs/vue3";
// Vue Props
const props = defineProps({
  goTo: String,
  text: String,
  type: String,
  showImages: Boolean
});
</script>

<template>
    <Link
      v-if="type === 'Link'"
      class="mx-12 uppercase font-bold text-white"
      :href="props.goTo"
    >
      <span class="hover:text-[#248ACB] ease-in duration-100 font-display sm:text-base lg:text-lg 2xl:text-2xl	">
        {{props.text}}
      </span>
    </Link>
    <Link href="/">
      <img v-if="type === 'Image'" :src="props.goTo" :alt="props.text" class="max-w-none mx-8 w-12 2xl:w-[4.25rem] rotate">
    </Link>
</template>

<style scoped>
.rotate{
  animation: rotate 10s linear infinite;
}
@keyframes rotate{
  to{ transform: rotate(360deg); }
}
</style>
