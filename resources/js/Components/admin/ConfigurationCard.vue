<script setup>
import { Link } from "@inertiajs/vue3";
import { Icon } from '@iconify/vue';

const props = defineProps({
    link: String,
    icon: String,
    title: String,
});
</script>

<template>
  <Link :href="`${props.link}`" class="flex text-center group justify-center items-center flex-col dark:border-t-gray-700 dark:border-b-gray-300 dark:bg-gray-800 dark:text-white hover:cursor-pointer duration-300 hover:bg-[#f3f4f6] dark:hover:bg-gray-700 rounded-lg">
      <Icon :icon="`${props.icon}`" class="text-[#94a3b8] dark:group-hover:text-white m-8 w-[100px] h-[100px]" />
      <span class="max-w-[100px] mb-5">{{props.title}}</span>
  </link>
</template>