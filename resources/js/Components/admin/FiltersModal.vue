<script setup>
import { VueFinalModal } from "vue-final-modal";
import { Icon } from '@iconify/vue';

const props = defineProps({
  title: String,
});

const adminFilterStore = useAdminFilterStore();

const emit = defineEmits(["submit", "confirm", "close"]);
</script>

<template>
    <VueFinalModal
        content-transition="vfm-fade"
        class="flex text-xl dark:text-white justify-center items-center"
        content-class="flex flex-col mx-4 bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-lg p-4 max-w-2xl sm:w-[35rem] relative"
    >   
        <Icon
            icon="iconamoon:close-bold"
            class="w-8 h-8 absolute top-5 right-5 cursor-pointer"
            @click="emit(`close`)"
        />

        <div class="flex gap-y-2 sm:gap-y-6 px-5 py-3 sm:p-5 text-center flex-col justify-center items-center">
            <div>
              {{ props.title }}
            </div>
            
            <div class="w-full text-start grid grid-cols-1 sm:grid-cols-2 sm:gap-x-4 my-2">
                <FormKit
                    :options="adminFilterStore.categories"
                    v-model="adminFilterStore.selectedCategory"
                    v-if="adminFilterStore.categories.length"
                    :classes="{
                        outer: '$reset mb-2 sm:mb-6',
                        input: 'text-sm lg:text-base'
                    }"
                    type="select"
                    name="category"
                    label="Categoría"
                    label-class="text-sm lg:text-base"
                    placeholder="Seleccionar..."
                />
                <div class="sm:row-span-3 sm:pl-1" v-if="adminFilterStore.brands.length">
                    <p class="text-sm lg:text-base dark:text-white">Marcas</p>
                    <div
                        class="flex flex-col pl-2 gap-2 py-2 sm:py-3 my-2 max-h-[8rem] sm:max-h-[15rem] overflow-y-auto bg-white dark:bg-gray-800 shadow rounded-lg"
                    >
                        <FormKit
                            v-for="brand in adminFilterStore.brands"
                            :key="brand.id"
                            type="checkbox"
                            v-model="brand.value"
                            :id="brand.id"
                            name="brand"
                            :label="brand.name"
                            :classes="{
                                label: '$reset text-xs sm:text-sm dark:text-white ml-1',
                                outer: '$reset mb-0 w-max'
                            }"
                        />
                    </div>
                </div>
                <FormKit
                    v-model="adminFilterStore.priceMin"
                    type="number"
                    :classes="{
                        outer: '$reset mb-2 sm:mb-6',
                        input: 'text-sm lg:text-base'
                    }"
                    name="priceMin"
                    label="Precio mínimo"
                    label-class="text-sm lg:text-base"
                    placeholder="100"
                    step="0.01"
                    validation="number|required|min:0.01|max:999999"
                    autocomplete="off"
                />
                <FormKit
                    v-model="adminFilterStore.priceMax"
                    type="number"
                    :classes="{
                        outer: '$reset mb-2 sm:mb-6',
                        input: 'text-sm lg:text-base'
                    }"
                    name="priceMax"
                    label="Precio máximo"
                    label-class="text-sm lg:text-base"
                    placeholder="50000"
                    step="0.01"
                    validation="number|required|min:0.01|max:999999"
                    autocomplete="off"
                />
                <FormKit
                    v-model="adminFilterStore.orderBy"
                    :options="[
                        {
                            label: 'Por código',
                            value: 'id'
                        },
                        {
                            label: 'Precio menor a mayor',
                            value: 'sortBy'
                        },
                        {
                            label: 'Precio mayor a menor',
                            value: 'sortByDesc'
                        },
                    ]"
                    :classes="adminFilterStore.gamas.length 
                        ? {outer: '$reset mb-3 sm:mb-6', input: 'text-sm lg:text-base'} 
                        : {outer: '$reset sm:col-span-2 mb-3 sm:mb-6 sm:w-64 sm:mx-auto', input: 'text-sm lg:text-base' }
                    "
                    type="select"
                    name="order"
                    label="Orden"
                    label-class="text-sm lg:text-base"
                    placeholder="Seleccionar..."
                />
                <FormKit
                    :options="adminFilterStore.gamas"
                    v-model="adminFilterStore.selectedGama"
                    v-if="adminFilterStore.gamas.length"
                    :classes="{
                        outer: '$reset mb-3 sm:mb-6',
                    }"
                    type="select"
                    name="gama"
                    label="Gama"
                    placeholder="Seleccionar..."
                />
                <FormKit
                    v-model="adminFilterStore.sale"
                    type="checkbox"
                    label="Mostrar solo ofertas"
                    name="sale"
                    :classes="{
                        outer: '$reset sm:col-span-2 mx-auto mb-0',
                    }"
                    label-class="$reset text-xs sm:text-sm dark:text-white ml-1"
                />           
            </div>

            <div class="flex w-full justify-center gap-2">
                <Button
                    title="Aplicar"
                    icon-name="mi:filter"
                    text-color="text-white"
                    background-color="bg-[#1671AB]"
                    hover="hover:bg-[#248ACB] hover:shadow-sm hover:shadow-blue-400/100 duration-300"
                    :big-text="false"
                    :left-icon="true"
                    font-size="text-xs sm:text-sm lg:text-base"
                    extra="rounded-lg py-2 sm:py-2 px-2 sm:px-4"
                    @click="emit(`submit`)"
                />
                <Button
                    title="Borrar filtros"
                    icon-name="icon-park-solid:clear-format"
                    text-color="text-white"
                    background-color="bg-gray-600"
                    hover="hover:bg-gray-500 hover:shadow-sm hover:shadow-gray-400/100 duration-300"
                    :big-text="false"
                    :left-icon="true"
                    font-size="text-xs sm:text-sm lg:text-base"
                    extra="rounded-lg py-2 sm:py-2 px-2 sm:px-4"
                    @click="emit(`confirm`)"
                />
            </div>
        </div>
    </VueFinalModal>
</template>