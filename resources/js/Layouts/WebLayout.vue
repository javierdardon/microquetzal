<script setup>
import { usePage } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";

//Vue Const
const page = usePage();
const toast = useToast();
const toastSuccess = ref(null);
const toastError = ref(null);
const toastErrors = ref(null); // Errors for validations!!

// Store declarations
const productsFilterStore = useProductsFilterStore();
const buildsFilterStore = useBuildsFilterStore()
const socialLinkStore = useSocialLinks();
const { socialLink } = page.props

const cartStore = useCartStore();

// Updating social icon links store
socialLinkStore.updateSocialLinkList(socialLink);

// Clearing Products filters
if ( !page.url.includes('productos') ) {
    productsFilterStore.emptyFilters();
}

// Clearing Builds filters
if ( !page.url.includes('equipos') ) {
    buildsFilterStore.emptyFilters();
}

//Creating Cart
if ( !localStorage.hasOwnProperty('cart') ) {
    localStorage.setItem('cart', JSON.stringify([]));
}
cartStore.updateCart();

//TOAST
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
</script>

<template>
  <div
    class="flex flex-col justify-between h-screen"
  >
    <NavBar />
    <div v-if="$page.props.success" ref="toastSuccess"></div>
    <div v-if="$page.props.error" ref="toastError"></div>
    <div v-if="Object.values($page.props.errors).length" ref="toastErrors"></div>
    <main>
        <slot />
    </main>
    <Footer />
  </div>
</template>
