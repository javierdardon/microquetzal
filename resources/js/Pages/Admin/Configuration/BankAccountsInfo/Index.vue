<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    bankAccounts: Object,
});

//def
const adminFilterStore = useAdminFilterStore();
const page = usePage();
const columns = ref([]);

if (props.bankAccounts.data.length) {
    Object.keys(props.bankAccounts.data[0]).forEach((key) => {
        columns.value.push({
            name: key,
            label: key.toUpperCase(),
        });
    });
}

//pagination update
try {
  if ( !page.url.includes('?') ) {
    adminFilterStore.resetFilters();
  }
  adminFilterStore.updateLinks( props.bankAccounts.meta.links );
  adminFilterStore.updateUrl('admin/configurations/bank-accounts');
} catch (error) {
  console.log(error);
}
</script>

<template>
    <Head title="Cuentas de banco" />

    <AuthenticatedLayout>
        <Datatable
            title="Cuentas de banco"
            create-route="/admin/configurations/bank-accounts-create"
            delete-route="/admin/configurations/bank-accounts"
            edit-route="/admin/configurations/bank-accounts"
            :columns="columns"
            :rows="props.bankAccounts.data"
            :show-filters="false"
        />
    </AuthenticatedLayout>
</template>
