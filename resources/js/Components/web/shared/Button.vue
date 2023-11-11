<script setup>
import { Icon } from '@iconify/vue';
// Vue Props
const props = defineProps({
  title: String,
  iconName: String,
  iconColor: String,
  iconStyle: String,
  textColor: String,
  backgroundColor: String,
  hover: String,
  leftIcon: Boolean,
  bigText: Boolean,
  fontSize: String,
  extra: String,
});

</script>

<template>
    <button :class="props.bigText == true
        ? `flex items-center justify-center gap-2 py-1 px-2 cursor-pointer uppercase font-display mx-[1rem] ${props.fontSize} ${props.textColor} ${props.backgroundColor} ${props.hover} ${props.extra}`

        : `flex items-center justify-center gap-2 sm:text-sm lg:text-base cursor-pointer ${props.textColor} ${props.backgroundColor} ${props.hover} ${props.extra} ${props.fontSize}`
    ">

        <Icon v-if="props.leftIcon && props.iconName" :class="props.bigText == true
                ? `h-full w-[3rem] ${iconColor} ${props.iconStyle}`
                : `w-4 sm:w-5 h-4 sm:h-5 text-xs sm:text-sm lg:text-base ${props.iconColor} ${props.iconStyle}`
            " :icon="props.iconName" />

        {{ props.title }}

        <Icon
            v-if="!props.leftIcon && props.iconName"
            :class="props.bigText == true
                ? `h-full w-[3rem] ${props.iconColor} ${props.iconStyle}`
                : `w-4 sm:w-5 h-4 sm:h-5 text-xs sm:text-sm lg:text-base ${props.iconColor} ${props.iconStyle}`
            "
            :icon="props.iconName" />
    </button>
</template>
