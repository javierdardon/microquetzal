<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    category: Object
});

const form = useForm({
    id: props.category.id,
    name: props.category.name,
});

const useGoBack = useBack;
</script>

<template>
    <Head title="Editar Categoría" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h1 class="dark:text-white text-2xl font-bold">Editar categoría</h1>
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
                @submit="form.patch(route('admin.categories.update'))"
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
