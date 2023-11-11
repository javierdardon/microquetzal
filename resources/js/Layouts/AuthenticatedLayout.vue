<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { routes } from '@/Helpers/Admin/sidebarLinks';
import { Icon } from '@iconify/vue';
import { useToast } from "vue-toastification";
import { ref, watch } from 'vue';

const toast = useToast();
const page = usePage();

const toastSuccess = ref(null);
const toastError = ref(null); // Manipulated Error!
const toastErrors = ref(null); // Errors for validations!!
const toastInfo = ref(null);

watch( toastSuccess, toastSuccessDiv => {
    if( toastSuccessDiv != null ) showToast('success', page.props.success);
});

watch( toastError, toastErrorDiv => {
    if( toastErrorDiv != null ) showToast('error', page.props.error);
});

watch( toastErrors, toastErrorsDiv => {
    Object.values(page.props.errors).forEach(error => {
        showToast('error', error);
    });

    page.props.errors = {};
});

watch( toastInfo, toastInfoDiv => {
    if( toastInfoDiv != null ) showToast('info', page.props.info);
});

const showToast = ( type, message ) => {
    switch (type) {
        case 'success':
            toast.success(message);
            page.props.success = null;
            break;
        case 'error':
            toast.error(message);
            page.props.error = null;
            break;
        case 'info':
            toast.info(message);
            page.props.info = null;
            break
        default:
            break;
    }
}

const showMenu = ref(false);
const showNotifications = ref(false);
const showBackdrop = ref(false);

function openMenu() {
    showMenu.value = true;
    showBackdrop.value = true;
}

function openNotifications() {
    showNotifications.value = true;
    showBackdrop.value = true;
}

function closeAll() {
    showMenu.value = false;
    showNotifications.value = false;
    showBackdrop.value = false;
}
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

            <!-- Small screen Navbar -->
            <header class="fixed top-0 left-0 w-screen bg-gray-700 dark:bg-slate-800 p-4 md:px-6 flex justify-between transition-transform xl:-translate-y-full z-20">
                <button >
                    <Icon
                      icon="line-md:menu"
                      class="text-white w-10 h-10"
                      @click="openMenu"
                    />
                </button>

                <Link href="/admin">
                    <img class="w-10" src="/Logo.svg" alt="MicroQuetzal">
                </Link>
            </header>

            <!-- Backdrop -->
            <div v-if="showBackdrop" class="fixed top-0 left-0 z-30 bg-black opacity-50 w-screen h-full xl:hidden" @click="closeAll"></div>

            <!-- Left Sidebar -->
            <aside
              id="left-sidebar"
              :class="showMenu
                ? `fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-200 ease-in :translate-x-0`
                : `fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-200 ease-in -translate-x-full xl:translate-x-0`
              "
              aria-label="Sidebar"
            >
                <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 relative">
                    <Icon
                        icon="eva:close-outline"
                        class="dark:text-white w-8 h-8 absolute top-4 right-4 lg:hidden"
                        @click="closeAll"
                    />
                    <ul class="space-y-2 font-medium">
                        <li class="mb-4">
                            <Link href="/admin/profile" :class="{ 'bg-gray-300 dark:bg-gray-700': $page.url === `profile` }" class="flex items-center px-2 py-1 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group w-full" as="button">
                                <Icon class="text-3xl text-slate-400 mr-1 -scale-x-100" icon="tabler:brand-among-us" />
                                <span class="ml-2">{{ $page.props.auth.user.name }}</span>
                            </Link>
                        </li>
                        <span class="text-gray-950 dark:text-slate-500 px-2">Menú</span>
                        <li v-for="route in routes" :key="route.name">
                            <Link
                              :href="`/${route.route}`"
                              :method="route.method ? route.method : 'get'"
                              :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url === `/${route.route}` }"
                              class="flex items-center px-2 py-1 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group w-full"
                              as="button"
                            >
                                <Icon class="text-3xl text-slate-400" :icon="route.icon" />
                                <span class="ml-2">{{ route.name }}</span>
                            </Link>
                        </li>
                    </ul>
                    <span class="fixed bottom-0 mb-3 flex gap-2 items-center px-3">
                        <strong class="dark:text-white">MicroQuetzalNacional</strong>
                        <img class="w-8" src="/Logo.svg" alt="MicroQuetzal">
                    </span>
                </div>
            </aside>
            <!-- Page Content -->
            <main class="xl:ml-64 px-6 md:px-8 py-8 pt-24 xl:pt-8">
                <div v-if="$page.props.success" ref="toastSuccess"></div>
                <div v-if="$page.props.error" ref="toastError"></div>
                <div v-if="$page.props.info" ref="toastInfo"></div>
                <div v-if="Object.values($page.props.errors).length" ref="toastErrors"></div>
                <slot />
            </main>
        </div>
    </div>
</template>
