<script setup>
// Stores
const buildsFilterStore = useBuildsFilterStore();
</script>

<template>
  <div class="flex flex-col gap-3">
    <p class="text-lg font-sans">Orden de precio</p>

    <div class="font-mono flex flex-col text-sm">
      <div class="flex">
        <input
          type="radio"
          id="ascendente"
          name="order"
          value="sortBy"
          class="cursor-pointer"
          v-model="buildsFilterStore.orderBy"
          checked
        />
        

        <label
          for="ascendente"
          class="ml-2 cursor-pointer"
        >
          De menor a mayor
        </label>
      </div>
      <div class="flex">
        <input
          class="cursor-pointer"
          type="radio"
          id="descendente"
          name="order"
          value="sortByDesc"
          v-model="buildsFilterStore.orderBy"
        />

        <label
          for="descendente"
          class="ml-2 cursor-pointer"
        >
          De mayor a menor
        </label>
      </div>
    </div>
  </div>
</template>
