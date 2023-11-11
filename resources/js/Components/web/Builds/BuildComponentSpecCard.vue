<script setup>
import { Icon } from "@iconify/vue";
import { router } from '@inertiajs/vue3';
import { ModalsContainer, useModal } from "vue-final-modal";
import NotFoundModal from "@/Components/web/Builds/BuildsModalComponentNotFound.vue";

const props = defineProps({
    title: String,
    icon: String,
    componentName: String,
    cooler_stock: Boolean,
    link: Number,
    externalLink: String,
    quantity: Number,
    multipleRom:Object,
    multipleRomId: Object
});

//modal
const productName = ref("");
const productExternalLink = ref("")
const multipleRom = ref("");
const multipleRomId = ref("");

const openModalInfo = (name, link, objectRom, objectRomId) => {
    productName.value = name
    productExternalLink.value = link
    multipleRom.value = objectRom
    multipleRomId.value = objectRomId
    modalInfo.open();
};

const modalInfo = useModal({
    component: NotFoundModal,
    attrs: {
        name: productName,
        externalLink: productExternalLink,
        multipleRom: multipleRom,
        multipleRomId: multipleRomId,
        onClose() {
            modalInfo.close();
        },
    },
});

</script>
<template>
    <div
        @click="props.cooler_stock ? null : (props.link ? router.get(`/productos/${props.link}`) : openModalInfo(props.componentName, props.externalLink, props.multipleRom, props.multipleRomId))"
        class="mx-5 md:mx-0  w-full h-[200px] sm:h-[150px] md:w-[300px] md:h-[150px] lg:w-[360px] lg:h-[180px] card uppercase p-4 lg:p-8 md:flex-row md:items-left items-center flex-col hover:scale-105 ease-in-out duration-300 cursor-pointer font-display flex bg-[#F1F1F1] rounded-lg gap-8"
    >
        <div
            class="md:w-[100px] flex text-white ease-in-out duration-300 text-center justify-center gap-2 flex md:flex-col items-center"
        >
            <p class="text-xl lg:text-2xl" >{{ props.title }}</p>

            <Icon :icon="props.icon" class="h-[50px] w-full md:h-full md:w-[90px]" />
        </div>

        <div class="flex w-full justify-center items-center">
            <p
                v-if="props.multipleRom || props.multipleRomId"
                class="bg-blue-500 text-white font-bold py-2 px-4 rounded"
            >
                Ver mas
            </p>
            <p
                
                class="text-sm lg:text-md text-white ease-in-out duration-300"
            >
                {{props.cooler_stock ? 'Stock' : props.componentName }}
                <span v-if="props.quantity">
                    <span v-if="props.quantity !== 1" class="font-mono">
                        <br>(
                    </span>
                    <span v-if="props.quantity !== 1">
                        {{ `${props.quantity ? 'X'+props.quantity : ''}` }}
                    </span>
                    <span v-if="props.quantity !== 1" class="font-mono">
                        )
                    </span>
                </span>

            </p>
        </div>
    </div>
    <ModalsContainer />
</template>

<style scoped>
@keyframes rgb_anim {
    from {
        filter: hue-rotate(0deg);
    }
    50% {
        filter: hue-rotate(360deg);
    }
    to {
        filter: hue-rotate(0deg);
    }
}

.card {
    opacity: 0.9;
    background: #5c258d;
    background: -webkit-linear-gradient(to right bottom, #e66465, #9198e5);
    background: linear-gradient(to right bottom, #4389a2, #5c258d);

    animation-iteration-count: infinite;
    animation-duration: 8s;
    animation-name: rgb_anim;
}
.card:hover {
    opacity: 1;
}
</style>
