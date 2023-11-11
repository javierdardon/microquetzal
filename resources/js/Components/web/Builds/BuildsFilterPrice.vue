<script setup>
// Stores
const buildsFilterStore = useBuildsFilterStore();

</script>

<template>
  <div class="flex flex-col gap-3">
    <p class="text-xl font-sans">Por precio</p>

    <div class="font-mono">
      <span
        class="text-sm md:text-sm 2xl:text-base"
      >
      Min Q.
      </span>

      <input
        type="number"
        class="ms-2 ps-2 border border-black rounded-md w-[5.8rem] text-sm md:text-md py-0.5 h-6"
        min="0"
        max="99999"
        step="0.01"
        placeholder="1.00"
        id="min"
        name="min"
        required
        v-model="buildsFilterStore.priceMin"
      />
      
    </div>
    <div class="font-mono">
      <span
        class="text-sm md:text-sm 2xl:text-base"
      >
      Max Q.
      </span>

      <input
        type="number"
        class="ms-2 ps-2 border border-black rounded-md w-[5.8rem] text-sm md:text-md py-0.5 h-6"
        min="0"
        max="99999"
        placeholder="3200.5"
        step="0.01"
        id="max"
        name="max"
        required
        v-model="buildsFilterStore.priceMax"
      />
      
    </div>
  </div>
</template>
