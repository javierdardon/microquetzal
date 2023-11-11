<script setup>
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { routes } from '../Helpers/Web/profileLinks';
</script>

<template>
  <div class="mt-24 lg:mt-24 2xl:mt-32 px-2 container sm:mx-auto relative flex">
      <div class="h-full absolute top-0 start-0 border-e">
        <nav class="flex flex-col w-full">
          <Link
            v-for="profileLink in routes"
            :key="profileLink.name"
            :href="profileLink.route"
            :as="profileLink.method ? 'button' : 'a'"
            :method="profileLink.method ? profileLink.method : 'get'"
            class="flex items-center rounded-s gap-2 text-gray-800 hover:bg-gray-200 px-4 py-4 sm:px-6 lg:px-8 w-full"
            :class="{ 'bg-gray-400': profileLink.active }"
          >
            <Icon
              :icon="profileLink.icon"
              class="w-8 h-8"
            />
            <p class="text-sm lg:text-base hidden md:block">{{ profileLink.name }}</p>
          </Link>
        </nav>
      </div>

      <main class="ps-20 sm:ps-28 md:ps-56 lg:ps-60 pe-6 mb-10 w-full">
        <slot />
      </main>
  </div>
</template>

<style scoped>
/* Hide scrollbar for Chrome, Safari and Opera */
.scrollbar-hidden::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.scrollbar-hidden {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>
