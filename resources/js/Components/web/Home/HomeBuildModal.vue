<script setup>
//import
import { Icon } from '@iconify/vue';

//store
const modalStore = useModalStore();

const props = defineProps({
  build: Object,
});
</script>

<template>
  <transition name="modal-inner">
    <div
      v-if="modalStore.active"
      @click="modalStore.toggleModalClose"
      class="pt-[4.6rem] fixed h-full w-screen bg-black bg-opacity-50 top-0 flex items-center justify-center z-[50]"
    >
      <div
        @click.stop
        class="h-full md:h-[90%] flex flex-col md:flex-row overscroll-contain  bg-white container overflow-x-hidden md:overflow-hidden"
      >
        <div class=" h-full w-full flex items-center justify-center align-center ">
          <img
            class="object-cover h-full w-full "
            :src="`${props.build.images}`"
          />
        </div>
        <div class="justify-between flex w-full flex-col h-full md:border-l">
          <div class="text-white text-[2rem] bg-[#248ACB] items-center justify-center flex w-full justify-between px-[1rem]">
              <p
                class="cursor-default"
              >
                {{ props.build.name }}
              </p>
              <Icon
                icon="ep:close-bold"
                @click="modalStore.toggleModalOpen"
                class="cursor-pointer"
              />
            
          </div>
          <ul
            class="cursor-default text-[1.2rem] pt-[1rem] md:text-[1.5rem] lg:text-[2rem] px-[1rem] pb-[1rem] flex-wrap h-full  md:text-left overscroll-contain md:overflow-x-hidden font-sans space-y-4"
          >
            <li class="font-mono text-[1rem]">
              <p>
                <span class="font-display">PROCESADOR: </span> 
                {{ props.build.cpu_name || props.build.cpu.name }}
              </p>
            </li>
            <li class="font-mono text-[1rem]">
              <p>
                <span class="font-display">DISCIPADOR:</span>
                {{ props.build.cooler_name || props.build.cooler.name }}
              </p>
            </li>
            <li class="font-mono text-[1rem]">
              <p>
                <span class="font-display">MEMORIA RAM: </span>
                {{ props.build.ram_name || props.build.ram.name }}
              </p>
            </li>
            <li class="font-mono text-[1rem]">
              <p>
                <span class="font-display">TARJETA DE VIDEO: </span>
                {{ props.build.gpu_name || props.build.gpu.name }}
              </p>
            </li>
            <li class="font-mono text-[1rem]">
              <p>
                <span class="font-display">PLACA BASE: </span>
                {{ props.build.mobo_name || props.build.mobo.name }}
              </p>
            </li>
            <li class="font-mono text-[1rem]">
              <p>
                <span class="font-display">CASE: </span>
                {{ props.build.case_name || props.build.case.name }}
              </p>
            </li>
            <li class="font-mono text-[1rem]">
              <p>
                <span class="font-display">FUENTE DE PODER: </span>
                {{ props.build.psu_name || props.build.psu.name }}
              </p>
            </li>
            <li class="font-mono text-[1rem]">
              <p>
                <span class="font-display">ALMACENAMIENTO: </span>
                {{ props.build.rom_name || props.build.rom.name }}
              </p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.modal-inner-enter-active {
  transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
}

.modal-inner-leave-active {
  transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-inner-enter-from {
  opacity: 0;
}

.modal-inner-leave-to {
  opacity: 0;
}
</style>
