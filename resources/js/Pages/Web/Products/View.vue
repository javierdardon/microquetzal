<script setup>
import { onBeforeUnmount } from "vue";
import { Head } from '@inertiajs/vue3';

// Vue Props
const props = defineProps({
    product: Object,
});

// Stores
const modalStore = useModalStore();

// Composables
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

const description = ref(extractContent(props.product.description));
const url = window.location.href;
const basePath = window.location.origin;

// Vue LifeCycle
onBeforeUnmount(() => {
    modalStore.closeAllModals();
});
</script>

<template>
    <Head>
        <title>{{ props.product.name }}</title>
        <meta name="description" :content="description">

        <!-- Facebook Meta Tags -->
        <meta property="og:url" :content="url">
        <meta property="og:type" content="website">
        <meta property="og:title" :content="`${props.product.name} - MicroQuetzalNacional`">
        <meta property="og:description" :content="description">
        <meta property="og:image" :content="`${basePath}/${props.product.images}`">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="microquetzal.com">
        <meta property="twitter:url" :content="url">
        <meta name="twitter:title" :content="`${props.product.name} - MicroQuetzalNacional`">
        <meta name="twitter:description" :content="description">
        <meta name="twitter:image" :content="`${basePath}/${props.product.images}`">


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
            </div>
            <ProductsIndividual :product="props.product" />
            <div id="details"></div>
            <div class="bg-slate-50 mt-20 pb-20" v-if="props.product.description || props.product.details">
                <IndividualSeparator title="detalles" />
                <ProductIndividualDescription v-if="props.product.description" :product="props.product"/>
            </div>
        </div>
    </WebLayout>
</template>
