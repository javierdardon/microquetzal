<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from "vue";

const props = defineProps({
    featuredProducts: Object,
    brands: Array,
    categories: Array,
});

const page = usePage();
const adminFilterStore = useAdminFilterStore();
const columns = ref([]);

if (props.featuredProducts.data.length) {
    Object.keys(props.featuredProducts.data[0]).forEach((key) => {
        columns.value.push({
            name: key,
            label: key.toUpperCase(),
        });
    });
}

try {
  if ( !page.url.includes('?') ) {
    adminFilterStore.resetFilters();
  }
  adminFilterStore.updateLinks( props.featuredProducts.meta.links );
  adminFilterStore.updateUrl('admin/products/featured');

  if ( !adminFilterStore.categories.length ) {
      props.categories.forEach((category) => {
        adminFilterStore.categories.push({
            label: category.name,
            value: category.id,
        });
      });

      adminFilterStore.categories.unshift({
            label: 'Todos',
            value: 0
        });
    }

    if ( !adminFilterStore.brands.length ) {
      adminFilterStore.updateBrands(props.brands)
    }
} catch (error) {
  console.log(error);
}
</script>

<template>
    <Head title="Productos Destacados" />
    <AuthenticatedLayout>
        <Datatable
            updateRoute="/admin/products/featured"
            :columns="columns"
            :rows="props.featuredProducts.data"
            title="Productos Destacados"
            :show-filters="true"
        />
    </AuthenticatedLayout>
</template>
