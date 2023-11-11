<script setup>
import { onBeforeUnmount, ref } from "vue";
import { Link, Head } from "@inertiajs/vue3";

// Props
const props = defineProps({
    builds: Object,
    gamas: Array,
});

// Stores declaration
const buildsStore = useBuildsStore();
const buildsFilterStore = useBuildsFilterStore();
const modalStore = useModalStore();

if( !buildsFilterStore.gamas.length ) {
    buildsFilterStore.updateGamas(props.gamas);
}

// Variables declarations
const loading = ref(true);

const toggleLoading = () => {
    setTimeout(() => {
        loading.value = false;
    }, 300);
};
toggleLoading();

//change buttons lang
if (props.builds.links[0]) {
    props.builds.links[0].label = props.builds.links[0].label.replace(
        "Previous",
        "Anterior"
    );
    props.builds.links[props.builds.links.length - 1].label =
        props.builds.links[props.builds.links.length - 1].label.replace(
            "Next",
            "Siguiente"
        );
}

const url = window.location.href;

// Lifecycle Hooks
onBeforeUnmount(() => {
    modalStore.closeAllModals();
    buildsStore.updateBuilds([]);
});
</script>

<template>
    <Head>
        <title>Equipos</title>
        <meta name="description" content="Descubre nuestros equipos a los mejores precios | Micro Quetzal Nacional">

        <!-- Facebook Meta Tags -->
        <meta property="og:url" :content="url">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Equipos - MicroQuetzalNacional">
        <meta property="og:description" content="Descubre nuestros equipos a los mejores precios | Micro Quetzal Nacional">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="microquetzal.com">
        <meta property="twitter:url" :content="url">
        <meta name="twitter:title" content="Equipos - MicroQuetzalNacional">
        <meta name="twitter:description" content="Descubre nuestros equipos a los mejores precios | Micro Quetzal Nacional">
    </Head>
    <WebLayout>
        <div
            class="flex flex-col gap-4 lg:gap-7 xl:gap-8 2xl:w-[1302px] 2xl:mx-auto pt-[6rem] sm:pt-28 lg:pt-28 xl:pt-32 2xl:pt-40 px-4 sm:px-12 md:px-16 lg:px-15 xl:px-28 2xl:px-0"
        >
            <BuildsHeader />

            <div class="mt-5 mb-14 md:mb-20" v-if="loading">
                <LoadingScreen />
            </div>

            <div
                class="flex items-start gap-4 xl:gap-7 justify-start mb-16"
                v-else
            >
                <BuildsFiltersSection />

                <div class="w-full flex flex-col items-center">
                    <div
                        class="w-full grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-2 gap-4 xl:gap-x-5 2xl:gap-x-7 xl:gap-y-8 place-items-stretch"
                        v-if="props.builds.data.length"
                    >
                        <div v-for="build in props.builds.data" :key="build.id">
                            <Link :href="route('web.builds.view', build.id)">
                                <BuildsCard
                                    :id="build.id"
                                    :name="build.name"
                                    :images="build.images"
                                    :cpu="build.cpu_name || build.cpu.name"
                                    :gpu="build.gpu_name || build.gpu.name"
                                    :ram="build.ram_name || build.ram.name"
                                    :gama="build.gama"
                                    :quantity="build.quantity"
                                    :sale="build.sale"
                                    :percentage="build.percentage"
                                    :sale-price="build.sale_price"
                                    :price="build.price"
                                />
                            </Link>
                        </div>
                    </div>
                    <div
                        class="w-full py-32 lg:py-52 text-center lg:py-0 flex items-center justify-center"
                        v-else
                    >
                        <p class="text-2xl text-gray-400 font-bold">
                            No hay equipos para mostrar...
                        </p>
                    </div>
                    <Pagination
                        queryParams=""
                        :links="props.builds.links"
                        url="equipos"
                    />
                </div>
            </div>
        </div>
    </WebLayout>
</template>
