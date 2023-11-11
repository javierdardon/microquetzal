<script setup>
import AOS from "aos";
import 'aos/dist/aos.css';
import { onBeforeUnmount } from "vue";
import { Head } from '@inertiajs/vue3';

// Props
const props = defineProps({
    hero: Object,
    products: Array,
    featuredBuilds: Array,
    finalFrame: Object,
    socialLink: Object,
});

// Stores
const HeroStore = useHeroStore();
const productsStore = useProductsStore();
const buildsStore = useBuildsStore();
const finalFrameStore = useFinalFrameStore();
const modalStore = useModalStore();

// Variables
const loading = ref(false);

// Store Updates
productsStore.updateFeaturedProducts(props.products);
HeroStore.HeroList.message1 = props.hero.message1;
HeroStore.HeroList.message2 = props.hero.message2;
HeroStore.HeroList.message3 = props.hero.message3;
HeroStore.HeroList.message4 = props.hero.message4;
HeroStore.HeroList.image = props.hero.image;
buildsStore.updateFeaturedBuilds(props.featuredBuilds);
finalFrameStore.finalFrameList = props.finalFrame;

// AOS animations initialization
AOS.init();

const url = window.location.href;

//Lifecycle hooks
onBeforeUnmount(() => {
    // Clear stores
    modalStore.closeAllModals();
    productsStore.updateFeaturedProducts([]);
    buildsStore.updateFeaturedBuilds([]);
});
</script>

<template>
    <Head>
        <title>Inicio</title>
        <meta name="description" content="Micro Quetzal Nacional | Las mejores PC Gaming de Guatemala">

        <!-- Facebook Meta Tags -->
        <meta property="og:url" :content="url">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Inicio - MicroQuetzalNacional">
        <meta property="og:description" content="Micro Quetzal Nacional | Las mejores PC Gaming de Guatemala">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="microquetzal.com">
        <meta property="twitter:url" :content="url">
        <meta name="twitter:title" content="Inicio - MicroQuetzalNacional">
        <meta name="twitter:description" content="Micro Quetzal Nacional | Las mejores PC Gaming de Guatemala">
    </Head>
    <WebLayout>
        <div
            v-if="loading"
            class="fixed flex min-h-screen bg-[#282929] w-full justify-center text-white"
        >
            <LoadingScreen />
        </div>
        <div v-else>
            <HomeHero />
            <HomeFeaturedProducts />
            <HomeGaleryBuilds />
            <HomeFinalFrame />
        </div>
    </WebLayout>
</template>
