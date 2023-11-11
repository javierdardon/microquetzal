<script setup>
import { Icon } from '@iconify/vue';

//Store declarations
const buildsFilterStore = useBuildsFilterStore()

// Vue Props
const props = defineProps({
    width: String,
});

</script>


<template>
  <form @submit.prevent="buildsFilterStore.getBuilds()" :class="`flex flex-row border border-[0.25rem] hover:border-[#D1D1D1] rounded-lg overflow-hidden ${ props.width }`">
    <input
      type="text"
      name="busqueda"
      id="valorBusqueda"
      placeholder="Buscar..."
      class="px-3 focus:outline-none rounded-l-lg w-full h-9 sm:h-11 font-mono border-none focus:ring-0 focus:ring-offset-0"
      v-model="buildsFilterStore.search"
    >
    
    <button class="px-4 bg-[#E4E4E4] hover:bg-[#D1D1D1]" type="submit">
      <Icon
        icon="bi:search"
        class="w-6 h-6"
      />
    </button>
  </form>
</template>
