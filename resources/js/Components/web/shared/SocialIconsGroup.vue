<script setup>
import { Icon } from '@iconify/vue';

// Composables
const socialLinkStore = useSocialLinks();

const props = defineProps({
  width: String
});

</script>

<template>
    <div
      v-for="link in socialLinkStore.SocialLinksList"
      :key="link.icon"
    >
      <a
        v-if="link.link"
        :href="link.link"
        target="_blank"
      >
        <Icon
          v-if="link.link"
          :class="link.link
            ? `${props.width} m-3 w-7 h-7 lg:m-4 hover:-rotate-12 duration-150`
            : `${props.width} w-7 h-7 hover:-rotate-12 duration-150`"
          :icon="link.icon"
        />
      </a>
    </div>
</template>

