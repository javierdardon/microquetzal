<script setup>
import { VueFinalModal } from "vue-final-modal";
import { Icon } from "@iconify/vue";

const props = defineProps({
    title: String,
    description: String,
});

const emit = defineEmits(["close"]);
</script>

<template>
    <VueFinalModal
        content-class="w-full h-full flex flex-col bg-[#f3f4f6] dark:bg-gray-900 space-y-2"
        :hide-overlay="true"
        content-transition="vfm-fade"
    >
        <div class="flex gap-y-6 flex-col p-8 justify-center items-center h-full">
            <div class="flex p-5 dark:text-white w-full justify-between gap-5">
                <div class="text-left">
                    <p class="text-2xl sm:text-4xl lg:text-6xl break-all">DESCRIPCION</p>
                    <p class="text-sm sm:text-base lg:text-xl text-[#bdbdbd]">{{ props.title }}</p>
                </div>
                <div>
                    <Icon
                    @click="emit('close')"
                    class="w-6  h-6 cursor-pointer"
                    icon="fa:close"
                />
                </div>
            </div>
            <div
                class="overscroll-contain overflow-auto bg-white shadow sm:rounded-lg p-5  w-full h-full"
            >
                <froalaView
                    v-if="props.description"
                    class=""
                    v-model:value="props.description"
                ></froalaView>
                <div v-else>No hay descripcion.</div>
            </div>
        </div>
    </VueFinalModal>
</template>
