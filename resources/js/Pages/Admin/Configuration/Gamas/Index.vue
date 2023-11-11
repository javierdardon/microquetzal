<script setup>
import { Head, router } from "@inertiajs/vue3";
import { reactive } from 'vue';

const props = defineProps({
  gamas: Array,
})

const columns = ref([]);
if (props.gamas.length) {
    Object.keys(props.gamas[0]).forEach((key) => {
        columns.value.push({
            name: key,
            label: key.toUpperCase(),
        });
    });
}

const useGoBack = useBack;
</script>

<template>
  <Head title="Configurar gamas" />
  <AuthenticatedLayout>
    <div class="flex justify-between items-center mb-5">
      <p class="dark:text-white text-3xl font-bold">
        Configuración de gamas PC Combos
      </p>
      <ButtonNavigator
        href=""
        @click="useGoBack"
        text="Volver"
        type="button"
        method="get"
      />
    </div>

    <div class="flex flex-col gap-4 items-center">
      <Datatable
        delete-route="/admin/configurations/gamas-destroy"
        edit-route="/admin/configurations/gamas-edit"
        :show-only-table="true"
        :columns="columns"
        :rows="props.gamas"
      />

      <ButtonNavigator
        navigate-to="/admin/configurations/gamas-create"
        text="Crear"
        type="button"
        method="get"
      />
    </div>
  </AuthenticatedLayout>
</template>
