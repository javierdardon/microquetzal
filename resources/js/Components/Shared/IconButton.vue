<script setup>
import { Icon } from '@iconify/vue';


const props = defineProps({
  icon: String,
  color: String,
  textColor: {
    type: String,
    required: false,
  },
});

</script>

<template>
    <button
        type="button"
        :class="`text-white font-medium rounded-md text-sm text-center inline-flex items-center p-1 focus:ring-4 focus:outline-none bg-${props.color}`"
    >
      <Icon
        :class="props.textColor
          ? `text-2xl ${props.textColor}`
          : `text-2xl text-white`
        "
        :icon="props.icon"
      />
      <slot></slot>
    </button>
</template>
