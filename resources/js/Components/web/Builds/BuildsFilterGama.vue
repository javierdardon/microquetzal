<script setup>
// Stores
const buildsFilterStore = useBuildsFilterStore();
</script>

<template>
  <div class="flex flex-col gap-3">
    <p class="text-xl font-sans">Por Gama</p>

    <ul class="font-mono flex flex-col text-sm md:text-md ml-2 gap-y-2">
      <li
        v-for="gama in buildsFilterStore.gamas"
        :key="gama.name"
        class="flex items-center"
      >
        <input
          type="checkbox"
          :id="gama.name"
          name="gama"
          class="cursor-pointer"
          v-model="gama.value"
        />
        <label
          :for="gama.name"
          class="ml-2 cursor-pointer"
        >
          {{ gama.name }}
        </label>
      </li>
    </ul>
  </div>
</template>
