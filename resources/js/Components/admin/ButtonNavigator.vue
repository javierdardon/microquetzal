<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    navigateTo: String,
    text: String,
    type: String,
    method: String,
});
</script>

<template>
    <Link
        :href="props.navigateTo"
        class="px-4 py-2 font-semibold text-xs lg:text-base bg-gray-700 text-white rounded-full shadow-sm"
        :method="props.method"
        :as="props.type"
        :type="props.type"
    >
        {{ props.text }}
    </Link>
</template>
