<script setup>
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
  products: Object,
  brands: Array,
  categories: Array,
});

const adminFilterStore = useAdminFilterStore();
const columns = ref([]);
const page = usePage();

if (props.products.data.length) {
    Object.keys(props.products.data[0]).forEach((key) => {
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
    adminFilterStore.updateLinks( props.products.meta.links );
    adminFilterStore.updateUrl('admin/products');

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
  <Head title="Productos" />

  <AuthenticatedLayout>
    <Datatable
      delete-route="/admin/products"
      create-route="/admin/products-create"
      edit-route="/admin/products-edit"
      update-route="/admin/products/featured"
      sale-route="/admin/products-edit-sale"
      title="Productos"
      :columns="columns"
      :rows="props.products.data"
      :show-filters="true"
    />
  </AuthenticatedLayout>
</template>
