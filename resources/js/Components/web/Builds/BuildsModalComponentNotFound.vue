<script setup>
import { VueFinalModal } from "vue-final-modal";
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    name: String,
    externalLink: String,
    multipleRom: Object,
    multipleRomId: Object,
});
const emit = defineEmits(["close"]);
</script>

<template>
    <VueFinalModal
        content-transition="vfm-fade"
        class="flex justify-center items-center"
        content-class="w-full max-h-full  overscroll-contain overflow-auto flex flex-col max-w-xl mx-4 bg-white rounded-lg space-y-2"
    >
        <div
            class="text-base sm:text-xl cursor-default flex gap-y-6 p-6 text-center flex-col justify-center items-center"
        >
            <p v-if="props.externalLink">
                Lo sentimos, este producto no está disponible en nuestra página.
                Pero acá te dejamos un link donde puedes leer más acerca del
                componente. 😁
            </p>

            <div v-else-if="props.multipleRom || props.multipleRomId">
                <p class="my-3">
                    Aqui esta la lista de los discos duros utilizados en el
                    combo. ☝️🤓
                </p>
                <table
                    v-if="props.multipleRom"
                    class="w-full text-sm sm:text-lg divide-y divide-gray-300"
                >
                    <thead class="bg-gray-100">
                        <th class="px-6 py-2">Nombre</th>
                        <th class="px-6 py-2">Cantidad</th>
                    </thead>
                    <tbody v-for="(value, key) in props.multipleRom">
                        <td class="px-6 py-4 text-left">
                            <a
                                :href="value.link ? `${value.link}` : null"
                                :target="value.link ? '_blank' : ''"
                                :class="
                                    value.link
                                        ? 'text-[#0061ff] underline'
                                        : 'text-black'
                                "
                                >{{ key }}</a
                            >
                        </td>
                        <td class="px-6 py-4">{{ value.amount }}</td>
                    </tbody>
                </table>
                <div v-if="props.multipleRomId">
                    <p class="my-3">Disponibles en nuestra pagina. 🗿</p>
                    <table
                        class="w-full text-sm sm:text-lg divide-y divide-gray-300"
                    >
                        <thead class="bg-gray-100">
                            <th class="px-6 py-2">Nombre</th>
                            <th class="px-6 py-2">Cantidad</th>
                        </thead>
                        <tbody v-for="(value, key) in props.multipleRomId">
                            <td class="px-6 py-4 text-left">
                                <a
                                    :href="`/productos/${value.id}`"
                                    target="_blank"
                                    class="text-[#0061ff] underline"
                                    >{{ key }}</a
                                >
                            </td>
                            <td class="px-6 py-4">{{ value.amount }}</td>
                        </tbody>
                    </table>
                </div>
            </div>

            <p v-else>
                Lo sentimos, no tenemos más información sobre este producto. 😢
            </p>

            <a
                :href="props.externalLink ? `${props.externalLink}` : null"
                :target="props.externalLink ? '_blank' : ''"
                :class="
                    props.externalLink
                        ? 'text-[#0061ff] underline'
                        : 'text-black'
                "
                >{{ props.name }}</a
            >
            <div class="flex w-full justify-around gap-5">
                <button
                    class="w-full text-white px-5 py-1 ease-in-out duration-300 rounded-md bg-[#313131] hover:bg-[#505050] rounded-lg"
                    @click="emit(`close`)"
                >
                    Ok
                </button>
            </div>
        </div>
    </VueFinalModal>
</template>
