<script setup>

const props = defineProps({
    title: String,
});
</script>

<template>
    <div
        class="w-full py-24 p-3 cursor-default font-display text-center"
    >
        <p
            class=" animate-charcter tracking-[.40em] text-gray-400 cursor-default text-center uppercase font-display text-[1.5rem] sm:text-[3rem] 2xl:text-6xl"
        >
            {{ props.title }}
        </p>
    </div>
</template>

<style scoped>
.animate-charcter
{
  text-transform: uppercase;
  background-image: linear-gradient(
    -225deg,
    #248ACB 0%,
    #9142F8 25%,
    #ED63F9 50%,
    #9142F8 75%,
    #248ACB 100%
  );
  background-size: 200% auto;
  color: #fff;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: textclip 1.5s linear infinite;
  display: inline-block;
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}
</style>
