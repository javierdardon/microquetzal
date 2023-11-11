<script setup>
import { Icon } from '@iconify/vue';

// Vue Props
const props = defineProps({
  leftX: Boolean,
});

// Stores
const modalStore = useModalStore();
</script>

<template>
  <div
    @click="modalStore.closeAllModals"
    class="bg-black fixed bg-black h-full w-screen z-30 opacity-70"
  ></div>

  <Icon
    icon="iconamoon:close-bold"
    :class="
      props.leftX
        ? 'w-10 h-10 fixed top-3 left-3 text-white cursor-pointer z-30'
        : 'w-10 h-10 fixed top-3 right-3 lg:right-7 text-white cursor-pointer z-30'
    "
    @click="modalStore.closeAllModals"
  />
</template>
