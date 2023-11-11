import { defineStore } from "pinia";
import { router } from "@inertiajs/vue3";

export const useAdminFilterStore = defineStore("AdminFilter", () => {
  const links = ref([]);
  const url = ref('')
  const brands = ref([]);
  const categories = ref([]);
  const gamas = ref([]);
  const selectedCategory = ref(null);
  const selectedBrands = ref([]);
  const selectedGama = ref(0)
  const priceMin = ref(1);
  const priceMax = ref(50000);
  const search = ref("");
  const orderBy = ref("id");
  const sale = ref(false);

  function updateLinks( newLinks ) {
    links.value = newLinks;
  }
  
  function updateUrl( newUrl ) {
    url.value = newUrl;
  }

  function updateCategories( newCategories ) {
    categories.value = newCategories;
  }

  function updateSelectedCategory ( category ) {
    selectedCategory.value = category;
  }

  function updateBrands( newBrands ) {
    newBrands.forEach( brand => {
        brand.value = false;
    });

    newBrands.sort()
    brands.value = newBrands;
  }
  
  function updateGamas( newGamas ) {
    gamas.value = newGamas;
  }

  const emptyFilters = () => {
    brands.value.forEach( brand => {
      brand.value = false;
    });
    selectedBrands.value = null;
    selectedCategory.value = null;
    selectedGama.value = 0;
    priceMin.value = 1;
    priceMax.value = 50000;
    search.value = "";
    orderBy.value = "id";
    sale.value = false;
    applyFilters();
  }

  const resetFilters = () => {
    brands.value.forEach( brand => {
      brand.value = false;
    });
    categories.value = [];
    brands.value = [];
    gamas.value = [];
    selectedBrands.value = null;
    selectedCategory.value = null;
    selectedGama.value = 0;
    priceMin.value = 1;
    priceMax.value = 50000;
    search.value = "";
    orderBy.value = "id";
    sale.value = false;
  }

  const getParams = () => {
    const queryParamsArr = ref([]);

    selectedBrands.value = [];

    brands.value.forEach( brand => {
        if ( brand.value === true ) {
            selectedBrands.value.push( brand.id );
        }
    });

    if ( selectedBrands.value.length > 0 ) {
      queryParamsArr.value.push(`brands=${encodeURIComponent(JSON.stringify(selectedBrands.value))}`);
    }

    if ( priceMin.value !== 1 || priceMax.value !== 50000 ) {
      queryParamsArr.value.push(`priceMin=${priceMin.value}&priceMax=${priceMax.value}`);
    }

    if ( search.value !== '' ) {
        queryParamsArr.value.push(`search=${search.value}`);
    }

    if ( orderBy.value === 'sortBy' ) {
        queryParamsArr.value.push(`${orderBy.value}=true`);
    } else if ( orderBy.value === 'sortByDesc' ) {
      queryParamsArr.value.push(`${orderBy.value}=true`);
    } 

    if ( selectedGama.value ) {
      queryParamsArr.value.push(`gama=${encodeURIComponent(JSON.stringify(selectedGama.value))}`);
    }

    if ( selectedCategory.value ) {
        queryParamsArr.value.push(`category=${selectedCategory.value}`);
    }

    if ( sale.value ) {
      queryParamsArr.value.push(`sale=${sale.value}`);
  }

    const queryParams = ref('');

    queryParamsArr.value.forEach(( param ) => {
        if ( queryParamsArr.value.indexOf( param ) === 0 ) {
            queryParams.value += `?${param}`;
        } else {
            queryParams.value += `&${param}`;
        }
    });

    return { queryParams: queryParams.value };
  }

  const applyFilters = () => {

    const { queryParams } = getParams();

    try {
        router.get(`/${url.value}${queryParams}`);
    } catch (error) {
        console.log(error);
    }
  }


  return { links, url, brands, categories, gamas, priceMin, priceMax, search, orderBy, sale, selectedCategory, selectedBrands, selectedGama, updateLinks, updateCategories, updateBrands,  updateSelectedCategory, emptyFilters, updateUrl, resetFilters, updateGamas, getParams,  applyFilters }
})