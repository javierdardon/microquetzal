<script setup>
import { Link } from "@inertiajs/vue3";

// Composables
const links = useNavLinks();
</script>

<template>
  <div
    class="py-8 text-white flex-col cursor-default flex w-full bg-[#282929] items-center text-center px-3"
  >
    <div class="items-center text-center flex-col flex" v-for="link in links" :key="link.name">
      <img class="h-[5rem] w-[5rem] pb-[1rem]" v-if="link.type === 'Image'" :src="link.link" />
      <span class="font-display text-[1rem] md:text-xl label-font uppercase lg:my-2" v-if="link.type === 'Image'">
        MICRO QUETZAL NACIONAL
      </span>
    </div>

    <div class="flex flex-col my-2 lg:my-0 md:flex-row pt-[1rem]">
      <div
        v-for="link in links"
        :key="link.link"
        class="block lg:hidden"
      >
        <Link
          class=""
          v-if="link.type === 'Link'"
          :key="link.name"
          :href="link.link"
        >
          <ul class="pb-[0.90rem] text-[0.875rem] lg:text-lg label-font hover:text-[#248ACB] duration-300">
            <li class="md:mx-[0.90rem] font-display xl:mx-[1.5rem] uppercase" v-show="link.type === 'Link'">
              {{ link.name }}
            </li>
          </ul>

        </Link>
      </div>
    </div>
    <span class="text-sm font-mono">
      Copyright © 2023 Micro Quetzal Nacional. All Rights Reserved.
    </span>
  </div>
</template>
