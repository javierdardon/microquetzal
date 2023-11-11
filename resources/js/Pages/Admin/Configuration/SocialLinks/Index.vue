<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    social: Object,
});

const form = useForm({
    id: props.social.id,
    facebook: props.social.facebook,
    whatsapp: props.social.whatsapp,
    gmail: props.social.gmail,
    twitter: props.social.twitter,
    instagram: props.social.instagram,
    tikTok: props.social.tikTok,
});

const useGoBack = useBack;
</script>

<template>
    <Head title="Editar Redes Sociales" />
    <AuthenticatedLayout>
        <div class="flex flex-col">
                <div class="flex justify-between w-full mb-7">
                    <p
                        class="dark:text-white text-2xl uppercase font-bold text-start me-auto pb-3"
                    >
                        Configuracion de las redes sociales
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
            <div
                class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full"
            >
                <FormKit
                    type="form"
                    @submit="
                        form.patch(route('admin.configurations.socialLinksUpdate'))
                    "
                    submit-label="Guardar"
                >
                    <FormKit
                        type="text"
                        id="facebook"
                        name="facebook"
                        v-model="form.facebook"
                        label="Facebook"
                        label-class="capitalize"
                        placeholder="Agregue el link de su Facebook"
                    />

                    <FormKit
                        class=""
                        v-model="form.whatsapp"
                        label="whatsapp"
                        label-class="capitalize"
                        placeholder="Agregue el link de su Whatsapp"
                    />

                    <FormKit
                        v-model="form.gmail"
                        class=""
                        label="Gmail"
                        label-class="capitalize"
                        placeholder="Agregue el link de su Gmail"
                    />

                    <FormKit
                        class=""
                        v-model="form.twitter"
                        label="Twitter"
                        label-class="capitalize"
                        placeholder="Agregue el link de su Twitter"
                    />

                    <FormKit
                        class=""
                        v-model="form.instagram"
                        label="Instagram"
                        label-class="capitalize"
                        placeholder="Agregue el link de su Instagram"
                    />

                    <FormKit
                        class=""
                        v-model="form.tikTok"
                        label="TikTok"
                        label-class="capitalize"
                        placeholder="Agregue el link de su TikTok"
                    />
                </FormKit>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
