<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from "vue";

const props = defineProps({
    featuredBuilds: {
        type: Object,
    },
    gamas: Array,
});

const adminFilterStore = useAdminFilterStore();
const page = usePage();
const columns = ref([]);

if (props.featuredBuilds.data.length) {
    Object.keys(props.featuredBuilds.data[0]).forEach((key) => {
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
  adminFilterStore.updateLinks( props.featuredBuilds.meta.links );
  adminFilterStore.updateUrl('admin/builds/featured');
} catch (error) {
  console.log(error);
}
</script>

<template>
    <Head title="PC Combos destacados" />
    <AuthenticatedLayout>
        <Datatable
            updateRoute="/admin/builds/featured"
            :columns="columns"
            :rows="props.featuredBuilds.data"
            title="PC Combos destacados"
            :show-filters="true"
        />
    </AuthenticatedLayout>


</template>
