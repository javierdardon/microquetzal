<script setup>
import { Link } from '@inertiajs/vue3';

const adminFilterStore = useAdminFilterStore();
const { queryParams } = adminFilterStore.getParams();
const basePath = window.location.origin;

const paginateUrl = ( page ) => {
    const pageParam = ref(page);
    if ( queryParams.length ) {
        pageParam.value = page.replace('?', '&');
    }

    return `${basePath}/${adminFilterStore.url}${queryParams}${pageParam.value}`;
}
</script>
<template>
    <div v-if="adminFilterStore.links.length > 3" class="flex flex-wrap justify-center mt-10 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5">
        <template v-for="(link, key) in adminFilterStore.links">
            <div v-if="link.url === null" :key="key" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded " v-html="link.label" />
            <Link
                v-else
                class="mr-1 mb-1 px-4 py-3 text-[10px] md:text-sm leading-4 border rounded focus:border-[#248ACB] cursor-pointer"
                :class="{'bg-[#2563eb] text-white select-none pointer-events-none': link.active, 'hover:bg-[#f3f4f6] dark:text-white dark:hover:text-black': !link.active }"
                :tabindex="link.active ? '-1' : '0'"
                v-html="link.label"
                :href="paginateUrl(link.url)"
            />
        </template>
    </div>
</template>
