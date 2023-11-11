import { defineStore } from 'pinia';
import { router } from '@inertiajs/vue3'

export const useProductsFilterStore = defineStore( 'productsFilter', () => {
  const links = ref([]);
  const categories = ref([]);
  const brands = ref([]);
  const selectedBrands = ref([]);
  const selectedCategory = ref(null);
  const priceMin = ref(1);
  const priceMax = ref(50000);
  const search = ref("");
  const orderBy = ref("sortBy");
  const sale = ref(false);
  const categoryLinks = ref([]);

  function updateLinks( newLinks ) {
    links.value = newLinks;
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

  function updateSelectedBrands( id ) {
    selectedBrands.value = [ ...selectedBrands.value, id ];
  }

  const emptyFilters = () => {
    brands.value.forEach( brand => {
      brand.value = false;
    });

    selectedBrands.value = [];
    selectedCategory.value = null;
    priceMin.value = 1;
    priceMax.value = 50000;
    search.value = "";
    orderBy.value = "sortBy";
    sale.value = false;
  }

  const filterBySale = () => {

    if ( sale.value ) {
      sale.value = false;
      getProducts();
    } else {
      sale.value = true;
      getProducts();
    }

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

    if (orderBy.value === "sortByDesc") {
      queryParamsArr.value.push(`${orderBy.value}=true`);
    } else {
      queryParamsArr.value.push(`${orderBy.value}=true`);
    }

    if ( sale.value ) {
      queryParamsArr.value.push(`sale=${sale.value}`);
    }

    if ( selectedCategory.value ) {
        queryParamsArr.value.push(`category=${selectedCategory.value}`);
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

  const getProducts = () => {

    const { queryParams } = getParams();

    try {
        router.get(`/productos${queryParams}`);
    } catch (error) {
        console.log(error);
    }
  }

  function paginateUrl ( category ) {

    const basePath = window.location.origin;

    const { queryParams } = getParams();
    const urlParams = new URLSearchParams(queryParams);

    if ( category !== 0 ) {
      urlParams.set('category', category);
    } else {
      urlParams.delete('category')
    }

    return `${basePath}/productos${'?'+urlParams}`;
  }

  function updateCategoryLinks() {
    categories.value.forEach(category => {
      let categorieLink = paginateUrl(category.id);
      categoryLinks.value.push(categorieLink);
    });
  }

  return { categories, brands, updateCategories, updateBrands, updateSelectedBrands, getProducts, emptyFilters, priceMin, priceMax, orderBy, search, filterBySale, sale, links, updateLinks, getParams, selectedCategory, updateSelectedCategory, categoryLinks, updateCategoryLinks }
})
