<script setup>
import { ref } from "vue";
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
    builds: {
        type: Object,
    },
    gamas: Array,
});

const page = usePage();
const adminFilterStore = useAdminFilterStore();
const columns = ref([]);

if (props.builds.data.length) {
    Object.keys(props.builds.data[0]).forEach((key) => {
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
  if ( !adminFilterStore.gamas.length ) {
    props.gamas.forEach( gama => {
      adminFilterStore.gamas.push({
        label: gama.name,
        value: gama.id
      })
    })
    adminFilterStore.gamas.unshift({
      label: 'Todas',
      value: ''
    });
  }
  adminFilterStore.updateLinks( props.builds.meta.links );
  adminFilterStore.updateUrl('admin/builds');
} catch (error) {
  console.log(error);
}
</script>

<template>
    <Head title="PC Combos" />
    <AuthenticatedLayout>
        <Datatable
          delete-route="/admin/builds"
          create-route="/admin/builds-create"
          edit-route="/admin/builds-edit"
          update-route="/admin/builds/featured"
          sale-route="/admin/builds-edit-sale"
          :columns="columns"
          :rows="props.builds.data"
          title="PC Combos"
          :show-filters="true"
        />
    </AuthenticatedLayout>
</template>
