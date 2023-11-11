<script setup>
import { Icon } from '@iconify/vue';

const props = defineProps({
  name: String,
  price: Number,
  sale: Boolean,
});

// Composables autoimported
const formattedPrice = useFormatPrice;
const quotes = getInterest( props.price )
</script>

<template>
  <div class="flex flex-col items-center gap-3 bg-white py-7 px-6 lg:p-10 rounded-xl drop-shadow-2xl m-5 sm:mx-0 z-30 max-w-xs lg:max-w-sm sm:h-max overflow-auto">
    <p class="text-md text-center text-lg lg:text-xl mb-2 lg:mb-1 font-mono font-bold uppercase">Pago en cuotas</p>
    <div class="flex items-center">
      <Icon class="w-16 h-16 border-e border-gray-200 pe-4" icon="logos:visa"/>
      <Icon class="w-16 h-16 ps-4" icon="logos:mastercard"/>
    </div>
    <table>
      <tr
        class="gap-2 py-2 border-b-2 text-sm lg:text-base font-mono items-end"
        v-for="quote in quotes"
        :key="quote.quantity"
      >
        <td class="text-center py-2 px-5">{{ quote.quantity }}</td>
        <td class="text-center py-2 px-2"> cuotas de </td>
        <td class="text-center py-2 ps-2 text-xs lg:text-base">Q {{ formattedPrice(quote.monthly) }}</td>
      </tr>
    </table>
  </div>
</template>
