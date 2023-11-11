<script setup>
import { Head } from "@inertiajs/vue3";

</script>

<template>
    <Head title="Builds Destacadas" />
    <AuthenticatedLayout>
        <div class=" grid-cols-1 md:grid-cols-2 xl:grid-cols-4  gap-4 p-5 grid container mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">

          <ConfigurationCard link="/admin/configurations/hero" icon="mdi:human-hello-variant" title="Mensaje de bienvenida"/>

          <ConfigurationCard link="/admin/configurations/final-frame" icon="icon-park-outline:bye" title="Mensaje final"/>

          <ConfigurationCard link="/admin/configurations/social-links" icon="dashicons:facebook" title="Redes Sociales"/>

          <ConfigurationCard link="/admin/configurations/about" icon="mdi:about-circle-outline" title='Informacion de la página "Nosotros"'/>

          <ConfigurationCard link="/admin/configurations/bank-accounts" icon="bxs:bank" title='Cuentas de banco'/>

          <ConfigurationCard link="/admin/configurations/build-component-categories" icon="pepicons-pop:chain-circle-filled" title='Configurar categorías aplicadas a PC Combos'/>
          
          <ConfigurationCard link="/admin/configurations/gamas" icon="uim:graph-bar" title='Configurar Gamas (PC Combos)'/>
        </div>
    </AuthenticatedLayout>
</template>
