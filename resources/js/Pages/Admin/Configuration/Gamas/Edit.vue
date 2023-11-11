<script setup>
import { Head, router } from "@inertiajs/vue3";
import { reactive } from 'vue';

const props = defineProps({
  gama: Object,
})

const form = reactive({
  id: props.gama.id,
  name: props.gama.name,
  percentage: props.gama.percentage,
})

function submit() {
  router.patch('/admin/configurations/gamas-update', form)
}

const useGoBack = useBack;
</script>

<template>
  <Head title="Editar gama" />
  <AuthenticatedLayout>
    <div class="flex justify-between items-center mb-5">
      <p class="dark:text-white text-3xl font-bold">
        Editar gama
      </p>
      <ButtonNavigator
        href=""
        @click="useGoBack"
        text="Volver"
        type="button"
      />
    </div>

    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
      <FormKit
        type="form"
        submit-label="Guardar"
        @submit="submit"
      >
        <FormKit
          type="text"
          name="name"
          id="name"
          validation="required|length:1,20"
          maxlength="20"
          label="Nombre de la Gama"
          placeholder="Alta"
          :classes="{
            wrapper: '$reset max-w-[20rem]'
          }"
          v-model="form.name"
          autocomplete="off"
        />
        <div class="flex gap-2 justify-start items-center">
          <FormKit
            type="number"
            name="percentage"
            id="percentage"
            label="Porcentaje de barra"
            v-model="form.percentage"
            placeholder="50"
            :classes="{
              outer: '$reset max-w-[10rem] mb-5'
            }"
            validation="number|required|min:1|max:100"
            autocomplete="off"
          />
          <span class="dark:text-white">%</span>
        </div>
        <div class="flex flex-col gap-1 items-center w-full sm:max-w-xs duration-100 ease-in my-0 sm:my-2 xl:my-0 xl:mt-2 text-white">
          <p class="text-sm mb-3">Vista previa</p>
          <div class="h-4 w-full bg-gray-300 rounded-xl hover:shadow hover:shadow-slate-800/100 duration-100 ease-in overflow-hidden">
            <div
              :style="`width:${form.percentage}%; transition:width 1s`"
              class=" h-4 animated-bg rounded-xl transition-all duration-100 ease-in"
            ></div>
          </div>

          <p class="font-mono text-[0.65rem] sm:text-xs mb-10">
            <span class="font-bold">Gama:</span>
            {{ form.name }}
          </p>
        </div>
      </FormKit>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.animated-bg
{
  background: linear-gradient(
    -225deg,
    #248ACB 0%,
    #9142F8 25%,
    #ED63F9 50%,
    #9142F8 75%,
    #248ACB 100%
  );
  background-size: 200% auto;
  animation: textclip 3s linear infinite;
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}
</style>
