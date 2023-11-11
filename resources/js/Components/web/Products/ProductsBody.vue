<script setup>
const productsFilterStore = useProductsFilterStore();
const { queryParams } = productsFilterStore.getParams();
</script>

<template>
    <div class="flex gap-4 mb-16">
      <ProductsFiltersSection />
      <div class="flex flex-col items-center w-full">
          <ProductsSection />
          <Pagination :links="productsFilterStore.links" url="productos" :queryParams="queryParams" />
      </div>
    </div>
</template>
