<script setup>
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const form = reactive({
  name: null,
});

function submit() {
  router.post('/admin/categories-store', form)
}

const useGoBack = useBack;
</script>

<template>
  <Head title="Crear categoría" />
  <AuthenticatedLayout>
    <div class="flex justify-between items-center mb-5">
      <h1 class="dark:text-white text-2xl font-bold">Crear nueva categoría</h1>
      <ButtonNavigator
        href=""
        @click="useGoBack"
        text="Volver"
        type="button"
      />
    </div>
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
      <FormKit
        type="form"
        @submit="submit"
        submit-label="Guardar"
      >
        <FormKit
          type="text"
          name="name"
          id="name"
          validation="required|length:1,30"
          maxlength="30"
          label="Nombre"
          placeholder="Tarjetas de video"
          v-model="form.name"
          autocomplete="off"
          autofocus
        />
      </FormKit>
    </div>
  </AuthenticatedLayout>
</template>
