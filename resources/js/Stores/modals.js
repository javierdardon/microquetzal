import { defineStore } from 'pinia'
import { ref } from 'vue';

export const useModalStore = defineStore( 'Modals', () => {

    const showNavigationModal = ref(false);
    const showCategoriesModal = ref(false);
    const showProductsFiltersModal = ref(false);
    const showPaymentsModal = ref(false);
    const showBuildModal = ref( false );
    const showBuildsFiltersModal = ref(false);
    const backdropState = ref(false);
    const active = ref(false);

    //*modal inicio

    function toggleModalOpen() {
      active.value = !active.value;
    }

    function toggleModalClose() {
      active.value = false;
    }

    //*modal inicio

    const toggleNavigationModal = () => {
      showNavigationModal.value = true;
      backdropState.value = true;
    }

    const toggleCategoriesModal = () => {
      showCategoriesModal.value = true;
      backdropState.value = true;
    }

    const toggleProductsFiltersModal = () => {
      showProductsFiltersModal.value = true;
    }

    const togglePaymentsModal = () => {
      showPaymentsModal.value = true;
    }

    const toggleBuildModal = () => {
      showBuildModal.value = true;
    }

    const toggleBuildsFiltersModal = () => {
      showBuildsFiltersModal.value = true;
    }

    const closeAllModals = () => {
      showNavigationModal.value = false;
      showCategoriesModal.value = false;
      showProductsFiltersModal.value = false;
      showPaymentsModal.value = false;
      showBuildModal.value = false;
      showBuildsFiltersModal.value = false;
      backdropState.value = false;
    }

    return { showNavigationModal, showCategoriesModal, showProductsFiltersModal, showBuildModal, showBuildsFiltersModal, showPaymentsModal, backdropState, toggleBuildModal, toggleBuildsFiltersModal, toggleCategoriesModal, toggleProductsFiltersModal, toggleNavigationModal, togglePaymentsModal, closeAllModals, toggleModalOpen, toggleModalClose, active }

  })
