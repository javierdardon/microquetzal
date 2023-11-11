<script setup>
import { Link } from "@inertiajs/vue3";
import { Icon } from '@iconify/vue';

// Composables
const links = useNavLinks();
const modalStore = useModalStore();
</script>

<template>
  <nav class="bg-[#282929] px-4 py-4 fixed w-full z-20">
    <div class="flex items-center justify-between lg:hidden">
      <Logo width="w-11" />
      <div class="flex gap-4">
        <Link href="/iniciar-sesion">
            <Icon
              class="text-white text-4xl"
              icon="carbon:user-filled"
            />
        </Link>
        <Link
            href="/carrito"
            class="mr-2"
            >
                <Icon
                class="text-white text-4xl"
                icon="ion:cart"
                />
        </Link>
        <Icon
            class="text-white text-4xl cursor-pointer"
            icon="fa6-solid:bars"
            @click="modalStore.toggleNavigationModal"
        />
      </div>
    </div>
    <div class="hidden lg:flex items-center justify-center relative">
      <div v-for="link in links" :key="link.name">
          <NavBarLink :goTo="link.link" :text="link.name" :type="link.type" :show-images="true" />
      </div>
      <div class="absolute right-0 flex gap-4">
        <Link
          href="/carrito"
        >
            <Icon
              class="text-white text-4xl"
              icon="ion:cart"
            />
        </Link>
        <Link href="/iniciar-sesion">
            <Icon
              class="text-white text-4xl"
              icon="carbon:user-filled"
            />
        </Link>
      </div>
    </div>

    <div
      :class="modalStore.backdropState
        ? 'translate-x-0 fixed h-full w-screen top-0 left-0 z-30'
        : '-translate-x-full fixed h-full w-screen top-0 left-0 z-30'
      "
    >
      <Backdrop />
    </div>

    <aside class="p-5 transform top-0 left-0 w-60 sm:w-72 bg-white fixed h-full overflow-auto ease-in-out transition-all duration-300 z-40" :class="modalStore.showNavigationModal ? 'translate-x-0' : '-translate-x-full'">
        <span class="flex w-full items-center pb-4 border-b cursor-default">
          <Logo width="w-8" />
          <p class="font-display text-base ml-4 text-[#248ACB]">Micro Quetzal Nacional</p>
        </span>


        <ul class="divide-y font-sans">
          <li v-for="link in links" @click="modalStore.closeAllModals" :key="link.link">
            <Link
              v-if="link.type === 'Link'"
              :href="link.link"
              class="py-3 ps-3 block hover:bg-gray-300"
            >
              {{ link.name }}
            </Link>
          </li>
          <p class="font-sans py-4">Siguenos en:</p>
        </ul>
        <div class="flex flex-wrap justify-center text-xl w-full">
          <SocialIconsGroup />
        </div>
      </aside>
  </nav>
</template>
