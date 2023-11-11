<script setup>
//store
const buildsStore = useBuildsStore();
</script>

<template>
    <div
        class="grid min-[1921px]:container bg-white md:mx-auto md:w-full grid grid-cols-2 lg:grid-cols-4"
    >
        <HomeFeaturedBuilds
            v-for="(build, index) of buildsStore.featuredBuilds"
            :key="index"
            class="flex"
            :build="build"
            :index="index"
        />
    </div>

    <HomeBuildModal :build="buildsStore.selectedBuild" />

    <div
        class="flex flex-col justify-center items-center justify-center bg-[#282929] text-white py-[0.5rem] md:py-[1rem] 2xl:py-[2rem] px-8 p-5"
    >
        <HomeFeaturedBuildsSeparator />
        <div class="flex flex-wrap w-full justify-center">
            <SocialIconsGroup width="lg:w-11 lg:h-11" />
        </div>
    </div>
</template>
