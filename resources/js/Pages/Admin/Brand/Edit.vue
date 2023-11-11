<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    brand: Object
});

const form = useForm({
    id: props.brand.id,
    name: props.brand.name,
});

const useGoBack = useBack;
</script>

<template>
    <Head title="Editar Marca" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h1 class="dark:text-white text-2xl font-bold">Editar marca</h1>
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
                @submit="form.patch(route('admin.brands.update'))"
                submit-label="Guardar"
            >
                <FormKit
                  type="text"
                  name="name"
                  id="name"
                  validation="required|length:1,25"
                  maxlength="25"
                  label="Nombre"
                  placeholder="Corsair"
                  v-model="form.name"
                  autocomplete="off"
                  autofocus
                />
            </FormKit>
        </div>
    </AuthenticatedLayout>
</template>
