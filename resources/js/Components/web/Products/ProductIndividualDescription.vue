<script setup>
import { computed } from 'vue';
import { onBeforeUnmount } from 'vue';

const props = defineProps({
  product: Object,
})

// Declare stores
const modalStore = useModalStore();

// Lifecycle hooks
onBeforeUnmount(() => {
  modalStore.closeAllModals()
});

const hasDetails = computed((e) => {
    if (props.product.details !== null) {
        if ( Object.values(props.product.details).length ) {
            return true;
        }
        return false;
    } else {
        return false;
    }
})
</script>

<template>
    <div class="container mx-auto font-mono flex flex-wrap gap-5 border-t-2 border-black">
        <div v-if="hasDetails" class="w-full lg:w-1/4 flex-1 px-4 border-b-2 lg:border-b-0 lg:border-r-2 border-black py-3 flex-none">
            <div class="font-display text-xl my-2">ESPECIFICACIONES:</div>
            <div v-for="(detail, name) in props.product.details">
                <strong class="font-display">{{ name }}:</strong>
                {{ detail }}
            </div>
        </div>
        <div class="flex-initial lg:flex-1 py-3">
            <froalaView class="mx-5" v-model:value="props.product.description"></froalaView>
        </div>
    </div>
</template>
