<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  categories: Object,
})

const adminFilterStore = useAdminFilterStore();
const page = usePage();
const columns = ref([]);

if (props.categories.data.length) {
    Object.keys(props.categories.data[0]).forEach((key) => {
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
  adminFilterStore.updateLinks( props.categories.meta.links );
  adminFilterStore.updateUrl('admin/categories');
} catch (error) {
  console.log(error);
}
</script>

<template>
  <Head title="Categorías"/>

  <AuthenticatedLayout>
    <Datatable
      title="Categorías"
      create-route="/admin/categories-create"
      delete-route="/admin/categories"
      edit-route="/admin/categories-edit"
      :columns="columns"
      :rows="props.categories.data"
    />
  </AuthenticatedLayout>
</template>
