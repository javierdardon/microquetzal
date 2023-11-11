<script setup>
import { Icon } from '@iconify/vue';

const adminFilterStore = useAdminFilterStore();

const config = {
    classes: {
        input: '$reset appearance-none dark:bg-gray-900 rounded dark:text-white focus:outline-none focus:ring-0 focus:shadow-none w-full text-sm mb-0 border-none',
        outer: '$reset mb-0 border-none w-full',
        wrapper: '$reset mb-0 border-none w-full',
    }
};

</script>


<template>
  <div class="flex flex-row border border-[0.25rem] border-gray-300 hover:border-gray-400 dark:border-gray-800 dark:hover:border-gray-700 rounded-lg overflow-hidden">
    <FormKit
      type="search"
      name="busqueda"
      id="valorBusqueda"
      :config="config"
      v-model="adminFilterStore.search"
      placeholder="Buscar por nombre o código..."
    />
    
    <button class="px-3 bg-gray-300 hover:bg-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 -ms-1 z-10 dark:text-white text-gray-500 hover:text-white" type="submit">
      <Icon
        icon="bi:search"
        class="w-6 h-6 "
      />
    </button>
  </div>
</template>
