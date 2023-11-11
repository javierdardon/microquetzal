<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  brands: Object,
})

const page = usePage();
const adminFilterStore = useAdminFilterStore();

const columns = ref([])

if (props.brands.data.length) {
    Object.keys(props.brands.data[0]).forEach((key) => {
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
  adminFilterStore.updateLinks( props.brands.meta.links );
  adminFilterStore.updateUrl('admin/brands');
} catch (error) {
  console.log(error);
}
</script>

<template>
  <Head title="Marcas"/>

  <AuthenticatedLayout>
    <Datatable
      title="Marcas"
      create-route="/admin/brands-create"
      delete-route="/admin/brands"
      edit-route="/admin/brands-edit"
      :columns="columns"
      :rows="props.brands.data"
    />
  </AuthenticatedLayout>
</template>
