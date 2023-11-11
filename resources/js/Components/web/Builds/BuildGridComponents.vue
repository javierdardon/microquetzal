<script setup>
import { Icon } from "@iconify/vue";

const props = defineProps({
    specs: Object,
});

</script>
<template>
    <div
        class="container mx-auto gap-5 flex items-center justify-center flex-wrap"
    >
        <BuildComponentSpecCard
            :link="props.specs.cpu_id"
            :externalLink="props.specs.cpu_link"
            :componentName="props.specs.cpu_name || props.specs.cpu.name"
            title="cpu"
            icon="ph:cpu-fill"
        />
        <BuildComponentSpecCard
            :link="props.specs.cooler_id"
            :externalLink="props.specs.cooler_link"
            :componentName="props.specs.cooler_stock ? 'stock' : props.specs.cooler_name || props.specs.cooler.name"
            :cooler_stock="props.specs.cooler_stock"
            title="cooler"
            icon="grommet-icons:fan-option"
        />
        <BuildComponentSpecCard
            :link="props.specs.ram_id"
            :externalLink="props.specs.ram_link"
            :componentName="props.specs.ram_name || props.specs.ram.name"
            :quantity="props.specs.ram_units"
            title="ram"
            icon="fluent:ram-16-filled"
        />
        <BuildComponentSpecCard
            :link="props.specs.gpu_id"
            :externalLink="props.specs.gpu_link"
            :componentName="props.specs.gpu_name || props.specs.gpu.name"
            title="gpu"
            icon="bi:gpu-card"
        />
        <BuildComponentSpecCard
            :link="props.specs.mobo_id"
            :externalLink="props.specs.mobo_link"
            :componentName="props.specs.mobo_name || props.specs.mobo.name"
            title="mobo"
            icon="bi:motherboard-fill"
        />
        <BuildComponentSpecCard
            :link="props.specs.case_id"
            :externalLink="props.specs.case_link"
            :componentName="props.specs.case_name || props.specs.case.name"
            title="case"
            icon="bi:pc"
        />
        <BuildComponentSpecCard
            :link="props.specs.psu_id"
            :externalLink="props.specs.psu_link"
            :componentName="props.specs.psu_name || props.specs.psu.name"
            title="psu"
            icon="subway:power"
        />
        <BuildComponentSpecCard
            :link="props.specs.rom_id"
            :externalLink="props.specs.externalLink"
            :componentName="!props.specs.rom_multiple && !props.specs.rom_multiple_id ? props.specs.rom_name || props.specs.rom.name : ''"
            :multipleRom="props.specs.rom_multiple"
            :multipleRomId="props.specs.rom_multiple_id"
            title="Rom"
            icon="mdi:hdd"
        />
    </div>
</template>
