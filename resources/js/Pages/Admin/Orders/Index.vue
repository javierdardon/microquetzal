<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    orders: Object
});

const columns = ref([])

if (props.orders.data.length) {
    Object.keys(props.orders.data[0]).forEach((key) => {
        columns.value.push({
            name: key,
            label: key.toUpperCase(),
        });
    });
}
</script>

<template>
    <Head title="Pedidos" />
    <AuthenticatedLayout>
      <Datatable
        title="Pedidos"
        view-route="/admin/orders-view"
        edit-route="/admin/orders-edit"
        :columns="columns"
        :rows="props.orders.data"
        url="admin/orders"
        :linksPaginate="props.orders.meta.links"
      />
    </AuthenticatedLayout>
</template>
