<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
    url: String,
    queryParams: String
});


const basePath = window.location.origin;

const paginateUrl = ( page ) => {
    const pageParam = ref(page);
    if ( props.queryParams.length ) {
        pageParam.value = page.replace('?', '&');
    }

    return `${basePath}/${props.url}${props.queryParams}${pageParam.value}`;
}

</script>
<template>
    <div class="flex flex-wrap justify-center mt-10">
        <template v-for="(link, key) in props.links">
            <div v-if="link.url === null" :key="key" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
            <Link
                v-else
                class="mr-1 mb-1 px-4 py-3 text-[10px] md:text-sm leading-4 border rounded focus:border-[#248ACB] cursor-pointer"
                :class="{ 'bg-[#248ACB] text-white select-none pointer-events-none': link.active, 'hover:bg-[#282929] hover:text-white': !link.active }"
                v-html="link.label"
                :tabindex="link.active ? '-1' : '0'"
                :href="paginateUrl(link.url)"
            />
        </template>
    </div>
</template>
