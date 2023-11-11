<script setup>
import { onBeforeUnmount } from "vue";
import { Head, usePage } from '@inertiajs/vue3';
// Props
const props = defineProps({
    build: Object,
});

// Stores declaration
// const filterStore = useFilterStore();
const modalStore = useModalStore();

const goBack = () => {
    window.history.back();
};

const extractContent = (s) => {
    var span= document.createElement('span');
    span.innerHTML= s;

    var children= span.querySelectorAll('*');

    for(var i = 0 ; i < children.length ; i++) {
        if(children[i].textContent)
            children[i].textContent+= ' ';
        else
            children[i].innerText+= ' ';
    }

    return [span.textContent || span.innerText].toString().replace(/ +/g,' ');
};

const description = ref(extractContent(props.build.description));

const url = window.location.href;
const basePath = window.location.origin;

// Lifecycle Hooks
onBeforeUnmount(() => {
    modalStore.closeAllModals();
});
</script>

<template>
    <Head>
        <title>{{ props.build.name }}</title>
        <meta name="description" :content="description">

        <!-- Facebook Meta Tags -->
        <meta property="og:url" :content="url">
        <meta property="og:type" content="website">
        <meta property="og:title" :content="`${props.build.name} - MicroQuetzalNacional`">
        <meta property="og:description" :content="description">
        <meta property="og:image" :content="`${basePath}/${props.build.images}`">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="microquetzal.com">
        <meta property="twitter:url" :content="url">
        <meta name="twitter:title" :content="`${props.build.name} - MicroQuetzalNacional`">
        <meta name="twitter:description" :content="description">
        <meta name="twitter:image" :content="`${basePath}/${props.build.images}`">

    </Head>
    <WebLayout>
        <div class="w-full flex flex-col">
            <div class="mx-auto mt-[120px] container">
                <Button
                    title="Volver"
                    iconName="ion:caret-back-outline"
                    textColor="text-black"
                    font-size="text-base lg:text-xl"
                    hover="hover:shadow-md duration-300"
                    :leftIcon="true"
                    :bigText="false"
                    extra="mx-5 mb-6 py-2.5 sm:py-3 px-2 lg:px-2 xl:px-4"
                    @click="goBack"
                />
                <!-- <ProductsIndividual :product="props.product"/> -->
                <!-- <p> {{ props.build.name }} </p> -->
            </div>
            <BuildsIndividual :build="props.build" />

            <div class="mb-10" id="specs"></div>
            <IndividualSeparator title="componentes"/>

            <BuildGridComponents class="mb-20" :specs="props.build" />
            <div class="bg-slate-50 pb-20" v-if="props.build.description || props.build.details">
                <IndividualSeparator title="detalles" />
                <BuildIndividualDescription v-if="props.build.description"  :build="props.build" />
            </div>
        </div>
    </WebLayout>
</template>
