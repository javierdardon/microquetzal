<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    finalFrame: Object,
});

const form = useForm({
    id: props.finalFrame.id,
    message1: props.finalFrame.message1,
    message2: props.finalFrame.message2,
    image: props.finalFrame.image,
});

const useGoBack = useBack;
</script>

<template>
    <Head title="Editar Mensaje de Final" />
    <AuthenticatedLayout>
        <div class="flex flex-col">
                <div class="flex justify-between w-full mb-7">
                    <p
                        class="dark:text-white text-2xl uppercase font-bold text-start me-auto pb-3"
                    >
                        Configuracion de el mensaje final
                    </p>
                    <div>
                        <ButtonNavigator
                            href=""
                            @click="useGoBack"
                            text="Volver"
                            type="button"
                        />
                    </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
                <FormKit
                    type="form"
                    @submit="
                        form.post(
                            route('admin.configurations.finalFrameUpdate')
                        )
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
                        validation="length:0,42"
                        maxlength="42"
                    />
                    <FormKit
                        type="text"
                        id="message2"
                        name="message2"
                        v-model="form.message2"
                        label="Linea 2"
                        label-class="capitalize"
                        placeholder="Agregue el texto numero 2"
                        validation="length:0,27"
                        maxlength="27"
                    />
                    <p class="block m-2 font-bold text-base dark:text-white">
                        Imagen actual
                    </p>
                    <div
                        :style="`background-image: url(/${props.finalFrame.image})`"
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
                        form.patch(
                            route('admin.configurations.finalFrameDefault')
                        )
                    "
                    submit-label="Reestablecer"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
