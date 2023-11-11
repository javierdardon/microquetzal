import { defineStore } from 'pinia'
import { ref } from 'vue';

export const useBuildsStore = defineStore( 'pc', () => {

  const builds = ref([]);
  const featuredBuilds = ref([]);

  const updateBuilds = ( apiBuilds ) => {
    builds.value = apiBuilds
  }
  
  const updateFeaturedBuilds = ( apiBuildsList ) => {
    featuredBuilds.value = apiBuildsList
  }

  // const selectedBuild = ref({});
  // const updateBuild = ( build ) => {
  //   selectedBuild.value = build
  // }

  // selectedBuild,
  // updateBuild 

  return { builds, featuredBuilds, updateBuilds, updateFeaturedBuilds }

})