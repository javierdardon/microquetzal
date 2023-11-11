<script setup>
// Stores
const productsFilterStore = useProductsFilterStore();

// Composables
const { slugify } = useTextTransform();
</script>

<template>
  <div class="flex flex-col gap-3">
    <p class="text-xl font-sans">Por marca</p>
    <ul
      class="flex flex-col gap-2 py-3 pl-3 max-h-[9rem] 2xl:max-h-[14rem] overflow-y-auto"
    >
      <li
        v-for="brand in productsFilterStore.brands"
        class="flex items-center"
        :key="brand.id"
      >
        <input
          type="checkbox"
          :id="slugify( brand.name )"
          name="marca"
          class="mr-2 cursor-pointer"
          v-model="brand.value"
        />
        <label
          :for="slugify( brand.name )"
          class="font-mono text-sm md:text-md 2xl:text-base cursor-pointer truncate"
        >
          {{ brand.name }}
        </label>
      </li>
    </ul>
  </div>
</template>
