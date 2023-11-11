<script setup>
import { Link } from "@inertiajs/vue3";

// Vue Props
const props = defineProps({
  width: String
});
</script>

<template>
  <Link href="/">
    <img
      src="/img/Logo.svg"
      :class="`${props.width} rotate`"
    >
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
