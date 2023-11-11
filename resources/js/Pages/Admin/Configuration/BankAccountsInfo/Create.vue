<script setup>
import { Head, router } from "@inertiajs/vue3";
import { reactive } from "vue";

const form = reactive({
    bankName: null,
    accountName: null,
    accountNumber: null,
});

function submit() {
    router.post("/admin/configurations/bank-accounts-store", form);
}

const useGoBack = useBack;
</script>

<template>
    <Head title="Crear informacion de las cuentas de banco" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h1 class="dark:text-white text-2xl font-bold">
                Crear informacion acerca de las cuentas de banco de la tienda
            </h1>
            <ButtonNavigator
                href=""
                @click="useGoBack"
                text="Volver"
                type="button"
            />
        </div>
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
            <FormKit type="form" @submit="submit" submit-label="Guardar">

                <FormKit
                    type="text"
                    name="bankName"
                    id="bankName"
                    validation="required|length:1,30"
                    maxlength="30"
                    label="Nombre del banco"
                    placeholder="Banrural"
                    v-model="form.bankName"
                    autocomplete="off"
                    autofocus
                />

                <FormKit
                    type="text"
                    name="accountName"
                    id="accountName"
                    validation="required|length:1,30"
                    maxlength="30"
                    label="Nombre de la cuenta"
                    placeholder="Nemesio Oseguera"
                    v-model="form.accountName"
                    autocomplete="off"
                    autofocus
                />

                <FormKit
                    type="text"
                    name="accountNumber"
                    id="accountNumber"
                    validation="required|length:1,30"
                    maxlength="30"
                    label="Numero de la cuenta"
                    placeholder="123456789"
                    v-model="form.accountNumber"
                    autocomplete="off"
                    autofocus
                />
            </FormKit>
        </div>
    </AuthenticatedLayout>
</template>
