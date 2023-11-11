import { defineStore } from "pinia";
import { router } from "@inertiajs/vue3";

export const useBuildsFilterStore = defineStore("BuildsFilter", () => {
    const gamas = ref([]);
    const selectedGamas = ref([]);
    const priceMin = ref(1);
    const priceMax = ref(50000);
    const search = ref("");
    const orderBy = ref("sortBy");
    const sale = ref(false);

    const updateGamas = ( newGamas ) => {
        gamas.value = newGamas
    }

    const emptyFilters = () => {
        gamas.value.forEach((gama) => {
            gama.value = false;
        });

        selectedGamas.value = [];
        priceMin.value = 1;
        priceMax.value = 50000;
        search.value = "";
        orderBy.value = "sortBy";
        sale.value = false;
    };

    const filterBySale = () => {
        if (sale.value) {
            sale.value = false;
            getBuilds();
        } else {
            sale.value = true;
            getBuilds();
        }
    };

    const getParams = () => {
        const queryParamsArr = ref([]);

        selectedGamas.value = [];

        gamas.value.forEach((gama) => {
            if (gama.value === true) {
                selectedGamas.value.push(gama.id);
            }
        });

        if (selectedGamas.value.length > 0) {
            queryParamsArr.value.push(
                `gamas=${encodeURIComponent(
                    JSON.stringify(selectedGamas.value)
                )}`
            );
        }

        if (priceMin.value !== 1) {
            queryParamsArr.value.push(`priceMin=${priceMin.value}&priceMax=${priceMax.value}`);
        }

        if (priceMax.value !== 50000) {
            queryParamsArr.value.push(`priceMax=${priceMax.value}`);
        }

        if (search.value !== "") {
            queryParamsArr.value.push(`search=${search.value}`);
        }

        if ( sale.value ) {
            queryParamsArr.value.push(`sale=${sale.value}`);
          }

        if (orderBy.value === "sortByDesc") {
            queryParamsArr.value.push(`${orderBy.value}=true`);
        } else {
            queryParamsArr.value.push(`${orderBy.value}=true`);
        }

        const queryParams = ref("");

        queryParamsArr.value.forEach((param) => {
            if (queryParamsArr.value.indexOf(param) === 0) {
                queryParams.value += `?${param}`;
            } else {
                queryParams.value += `&${param}`;
            }
        });

        return { queryParams: queryParams.value };
    };

    const getBuilds = () => {
        const { queryParams } = getParams();

        try {
            router.get(`/equipos${queryParams}`);
        } catch (error) {
            console.log(error);
        }
    };

    return {
        getParams,
        gamas,
        updateGamas,
        priceMin,
        priceMax,
        orderBy,
        search,
        sale,
        filterBySale,
        getBuilds,
        emptyFilters,
    };
});
