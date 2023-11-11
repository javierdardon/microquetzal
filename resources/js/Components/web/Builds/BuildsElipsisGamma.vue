<script setup>
import { hidden } from "@formkit/icons";

const props = defineProps({
    gamma: Object,
});

const gradient = {
    radial: false,
    colors: [
        {
            color: "#2496EF",
            offset: "0",
            opacity: "1",
        },
        {
            color: "#ED63F9",
            offset: "50",
            opacity: "1",
        },
        {
            color: "#9142F8",
            offset: "100",
            opacity: "1",
        },
    ],
};
</script>

<template>
    <div>
        <ve-progress
            animation="default 1000 400"
            :progress="props.gamma.percentage"
            :size="100"
            thickness="10%"
            emptyThickness="3%"
            :color="gradient"
            legendClass="text-white text-xs"
            colorFill="#282929"
        >   
            <span slot="legend-value">{{ props.gamma.name }} </span>
        </ve-progress>
    </div>
</template>
