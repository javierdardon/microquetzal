<script setup>
import { VueFinalModal } from "vue-final-modal";
import { Icon } from "@iconify/vue";

const props = defineProps({
    title: String,
    rowId: Number,
    nameDelete: String,
});

const emit = defineEmits(["confirm", "close"]);
</script>

<template>
    <VueFinalModal
        content-transition="vfm-fade"
        class="flex text-xl dark:text-white justify-center items-center"
        content-class="flex flex-col max-w-xl mx-4 bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-lg space-y-2"
    >
        <div
            class="flex gap-y-6 p-5 text-center flex-col justify-center items-center"
        >
            <Icon
                class="w-[50px] h-[50px]"
                icon="jam:triangle-danger-f"
                color="red"
            />
            <div>¿Está seguro?</div>
            <p>¿Desea eliminar el artículo:</p>
            <p class="text-[#ff0000]">{{ props.nameDelete }}</p>
            <p>permanentemente?</p>
            <div class="flex w-full justify-around gap-5">
                <button
                    class="w-full text-white px-5 py-1 rounded-md bg-[#313131] hover:bg-[#505050] rounded-lg"
                    @click="emit(`close`)"
                >
                    Cancelar
                </button>
                <button
                    class="w-full text-white px-5 py-1 rounded-md bg-[#7c0000] hover:bg-[#ff0000]"
                    @click="emit(`confirm`)"
                >
                    Eliminar
                </button>
            </div>
        </div>
    </VueFinalModal>
</template>
