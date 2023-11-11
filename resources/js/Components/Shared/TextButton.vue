<script setup>
const props = defineProps({
    text: String
});
</script>

<template>
    <button type="button" class="text-white bg-gray-700 hover:bg-gray-600 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2">
        {{ text }}
    </button>
</template>
