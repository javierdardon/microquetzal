<script setup>
import { onBeforeUnmount } from 'vue';
import { Head } from '@inertiajs/vue3';

// Props
const props = defineProps({
  about: Object,
})

// Declare stores
const aboutParagraph = useAbout();
const modalStore = useModalStore();

// Update stores
// aboutParagraph.AboutList.image = 'https://www.zdnet.com/a/img/resize/ba1b1ab92085d777ab5e313b34c66a94b7aa1236/2023/06/05/79a43eb8-ce38-488c-8cc0-e04699aaca7f/bing.jpg?auto=webp&width=1280';
aboutParagraph.AboutList.paragraph = props.about.paragraph;

aboutParagraph.AboutList.image = props.about.image;

const url = window.location.href;

// Lifecycle hooks
onBeforeUnmount(() => {
  modalStore.closeAllModals()
});
</script>

<template>
  <Head>
    <title>Nosotros</title>
    <meta name="description" content="Acerca de nosotros, una empresa ubicada en el departamento de Retalhuleu | Micro Quetzal Nacional">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" :content="url">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Nosotros - MicroQuetzalNacional">
    <meta property="og:description" content="Acerca de nosotros, una empresa ubicada en el departamento de Retalhuleu | Micro Quetzal Nacional">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="microquetzal.com">
    <meta property="twitter:url" :content="url">
    <meta name="twitter:title" content="Nosotros - MicroQuetzalNacional">
    <meta name="twitter:description" content="Acerca de nosotros, una empresa ubicada en el departamento de Retalhuleu | Micro Quetzal Nacional">
  </Head>
  <WebLayout>
    <div
      class="mt-[4.75rem] lg:mt-24 container my-10 mx-auto"
    >
    <froalaView v-model:value="about.body"></froalaView>
    </div>
  </WebLayout>
</template>
