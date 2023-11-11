<script setup>
import ApplicationLogo from '@/Components/admin/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 px-6 sm:px-0">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500 rotate" />
            </Link>
        </div>

        <div
            class="w-full max-w-sm sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>

<style scoped>
.rotate{
  animation: rotate 18s linear infinite;
}
@keyframes rotate{
  to{ transform: rotate(360deg); }
}
</style>