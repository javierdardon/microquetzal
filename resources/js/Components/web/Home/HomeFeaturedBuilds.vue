<script setup>
import { Link } from '@inertiajs/vue3';

//props
const props = defineProps({
    build: Object,
    index: Number,
});

// store
// const buildsStore = useBuildsStore();
// Show build modal
// const pcDetails = () => {
//     buildsStore.updateBuild(props.build);
//     modalStore.toggleModalOpen();
// };
</script>

<template>
    <div data-aos="fade-up" class="relative group bg-white h-60 sm:h-[22rem] md:h-[26rem] lg:h-[21rem] xl:h-[26rem] 2xl:h-[30rem]">
        <img
            :src="props.build.images"
            class="object-cover h-full w-full border border-black"
        />
        <div
            class="h-full w-full ease-linear duration-300 flex flex-col justify-center items-center absolute text-[white] invisible group-hover:visible group-hover:backdrop-blur group-hover:backdrop-brightness-50"
        >
            <ul
                class="h-full flex flex-col p-4 sm:p-6 2xl:p-10 gap-3 text-[0.65rem] sm:text-base md:text-lg lg:text-base xl:text-lg scale-[0] group-hover:scale-100 duration-150 cursor-default"
            >
                <li>
                    <p>
                      <span class="underline decoration-sky-500">CPU:</span>
                      {{ props.build.cpu_name || props.build.cpu.name }}
                    </p>
                </li>
                <li>
                    <p>
                      <span class="underline decoration-sky-500">RAM:</span>
                      {{ props.build.ram_name || props.build.ram.name }}
                    </p>
                </li>
                <li>
                    <p>
                      <span class="underline decoration-sky-500">GPU:</span>
                      {{ props.build.gpu_name || props.build.gpu.name }}
                    </p>
                </li>
            </ul>

            <div class="flex p-1 pt-1 pb-3 md:py-8 lg:py-5 xl:py-10 2xl:py-12">
                <Link :href="route('web.builds.view', build.id)">
                    <Button
                        title="Ver detalles"
                        icon-name="pajamas:long-arrow"
                        text-color="text-white"
                        background-color="bg-[#248ACB]"
                        hover="group-hover:scale-100 duration-300"
                        :left-icon="false"
                        :big-text="false"
                        font-size="uppercase text-[0.55rem]"
                        extra="drop-shadow-2xl scale-[0] self-center py-1.5 sm:py-3 px-2 lg:px-2 xl:px-3 justify-self-start"
                    />
                    <!-- @click="pcDetails" -->
                </Link>
            </div>
        </div>
    </div>
</template>
