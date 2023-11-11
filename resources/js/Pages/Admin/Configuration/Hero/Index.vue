<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    hero: Object,
});

const form = useForm({
    id: props.hero.id,
    message1: props.hero.message1,
    message2: props.hero.message2,
    message3: props.hero.message3,
    message4: props.hero.message4,
    image: props.hero.image,
});

const useGoBack = useBack;
</script>

<template>
    <Head title="Editar Mensaje de Bienvenida" />
    <AuthenticatedLayout>
        <div class="flex flex-col">
                <div class="flex justify-between mb-7 w-full">
                    <p
                        class="dark:text-white text-2xl uppercase font-bold text-start me-auto pb-3"
                    >
                        Configuracion de el mensaje de bienvenida
                    </p>
                    <div>
                        <ButtonNavigator
                            href=""
                            @click="useGoBack"
                            text="Volver"
                            type="button"
                            method="get"
                            class=""
                        />
                    </div>
                </div>
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
                <FormKit
                    type="form"
                    @submit="
                        form.post(route('admin.configurations.heroUpdate'))
                    "
                    submit-label="Guardar"
                >
                    <FormKit
                        type="text"
                        id="message1"
                        name="message1"
                        v-model="form.message1"
                        label="Linea 1"
                        label-class="capitalize"
                        placeholder="Agregue el texto numero 1"
                        validation="length:0,23"
                        maxlength="23"
                    />
                    <FormKit
                        type="text"
                        id="message2"
                        name="message2"
                        v-model="form.message2"
                        label="Linea 2"
                        label-class="capitalize"
                        placeholder="Agregue el texto numero 2"
                        validation="length:0,12"
                        maxlength="12"
                    />
                    <FormKit
                        type="text"
                        id="message3"
                        name="message3"
                        v-model="form.message3"
                        label="Linea 3"
                        label-class="capitalize"
                        placeholder="Agregue el texto numero 3"
                        validation="length:0,23"
                        maxlength="23"
                    />
                    <FormKit
                        type="text"
                        id="message4"
                        name="message4"
                        v-model="form.message4"
                        label="Linea 4"
                        label-class="capitalize"
                        placeholder="Agregue el texto numero 4"
                        validation="length:0,12"
                        maxlength="12"
                    />
                    <p class="block m-2 font-bold text-base dark:text-white">
                        Imagen actual
                    </p>
                    <div
                        :style="`background-image: url(/${props.hero.image})`"
                        class="rounded-lg h-48 sm:h-96 w-48 sm:w-96 bg-no-repeat bg-center bg-cover mb-4"
                    ></div>
                    <FormKit
                        type="file"
                        id="image"
                        name="image"
                        v-model="form.image"
                        label="imagen"
                        label-class="capitalize"
                        placeholder="Agregue la imagen"
                    />
                </FormKit>
                <FormKit
                    type="form"
                    @submit="
                        form.patch(route('admin.configurations.heroDefault'))
                    "
                    submit-label="Reestablecer"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
