<script setup>
import { Head, usePage } from '@inertiajs/vue3';

// Vue Props
const props = defineProps({
    products: Object,
    categories: Array,
    brands: Array,
});

// Stores
const modalStore = useModalStore();
const productsStore = useProductsStore();
const productsFilterStore = useProductsFilterStore();

// Vue Constant
const page = usePage();
const loading = ref(true);

//Get Actual Params
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const category = urlParams.get('category');

productsFilterStore.updateSelectedCategory(Number(category));

if ( props.products.links[0] ) {
    props.products.links[0].label = props.products.links[0].label.replace('Previous', 'Anterior');
    props.products.links[props.products.links.length - 1].label = props.products.links[props.products.links.length - 1].label.replace('Next', 'Siguiente');
}

//* Updating Products
try {
    productsStore.updateProducts( props.products.data );
    productsFilterStore.updateLinks( props.products.links );

    if ( !productsFilterStore.categories.length ) {
        productsFilterStore.updateCategories( props.categories );

        productsFilterStore.categories.unshift({
            id: 0,
            name: 'Todos'
        });
    }

    const filteredBrandsId = ref([])
    props.products.data.forEach(product => {
        if( !filteredBrandsId.value.includes(product.brand_id) ) {
            filteredBrandsId.value.push(product.brand_id)
        }
    })

    const filteredBrands = ref([]);
    props.brands.forEach( brand => {
        if( filteredBrandsId.value.includes(brand.id) ) {
            filteredBrands.value.push(brand)
        }
    })
    productsFilterStore.updateBrands(filteredBrands.value)


    setTimeout(() => {
        loading.value = false;
    }, 100);
} catch (error) {
    console.log(error);
}

if ( !page.url.includes('?') ) {
    productsFilterStore.emptyFilters();
}

const url = window.location.href;

productsFilterStore.updateCategoryLinks();

onBeforeUnmount(() => {
  modalStore.closeAllModals();
  productsStore.updateProducts([]);
});
</script>

<template>
    <Head>
        <title>Productos</title>
        <meta name="description" content="Variedad de productos al alcance de un click | Micro Quetzal Nacional">

        <!-- Facebook Meta Tags -->
        <meta property="og:url" :content="url">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Productos - MicroQuetzalNacional">
        <meta property="og:description" content="Variedad de productos al alcance de un click | Micro Quetzal Nacional">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="microquetzal.com">
        <meta property="twitter:url" :content="url">
        <meta name="twitter:title" content="Productos - MicroQuetzalNacional">
        <meta name="twitter:description" content="Variedad de productos al alcance de un click | Micro Quetzal Nacional">
    </Head>
    <WebLayout>
        <div class="flex flex-col gap-7 xl:gap-10 2xl:w-[1302px] 2xl:mx-auto pt-[6rem] sm:pt-28 lg:pt-28 xl:pt-32 2xl:pt-40 px-4 sm:px-12 md:px-16 xl:px-[6.5rem] 2xl:px-0">
            <ProductsHeader />
            <div
              class="mt-5 mb-14 md:mb-20"
              v-if="loading"
            >
                <LoadingScreen />
            </div>
            <ProductsBody v-else/>
        </div>
    </WebLayout>
</template>
