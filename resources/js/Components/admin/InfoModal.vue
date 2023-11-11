<script setup>
import { VueFinalModal } from "vue-final-modal";

const props = defineProps({
    title: String,
});

const emit = defineEmits(["close"]);
</script>

<template>
    <VueFinalModal
        content-transition="vfm-fade"
        class="flex text-xl dark:text-white justify-center items-center"
        content-class="flex flex-col max-w-xl mx-4 bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-lg p-4"
    >
        <div class="flex gap-y-6 p-5 text-center flex-col justify-center items-center">
            <div>
              {{ props.title }}
            </div>
            
        <div>
            <p class=" text-sm mb-2">En esta página puede configurar las categorías de productos que se mostrarán al momento de crear PC COMBOS. Lo primero que debe de hacer es asegurarse que en el menú CATEGORIAS ya existan todas las que se muestran debajo de este mensaje. Luego podrá enlazar cada una de ellas.</p>
            <p class=" text-sm mb-4">Una vez seleccionadas correctamente todas las categorías, al crear PC COMBOS usted podrá seleccionar los PRODUCTOS que tenga en existencia como un componente de sus Combos y quien visite la página podrá por ejemplo ver el "cpu" directamente en Microquetzal.com y ver su precio individual. Esta es una configuración única, entonces una vez configurada no tiene que preocuparse por hacerlo de nuevo, los componentes aparecerán automáticamente cuando esté creando sus Combos.</p>
        </div>

            <div class="flex w-full justify-center">
                <button 
                    class="px-5 py-1 text-white rounded-md bg-[#1370AB] hover:bg-[#248ACB] rounded-lg"
                    @click="emit(`close`)"
                >
                    Aceptar
                </button>
            </div>
        </div>
    </VueFinalModal>
</template>
