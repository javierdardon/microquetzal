<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { ModalsContainer, useModal } from "vue-final-modal";

import paymentModalInfo from "@/Components/web/Auth/paymentModalInfo.vue";

const props = defineProps({
    orders: Array,
    bankAccounts: Object,
});

const cartStore = useCartStore();
const socialLinkStore = useSocialLinks();
const page = usePage();

if (page.props.success) {
    cartStore.clearCart();
}

//modal del boton
const bankAccounts = ref({});

const openModal = (accounts) => {
    bankAccounts.value = accounts;
    PaymentModal.open();
};

const PaymentModal = useModal({
    component: paymentModalInfo,
    attrs: {
        accounts: bankAccounts,
        onClose() {
            PaymentModal.close();
        },
    },
});
</script>

<template>
    <Head title="Mis Pedidos" />
    <WebLayout>
        <WebProfileLayout>
            <p class="mt-3 text-2xl sm:text-3xl mb-4 uppercase font-display">
                Pedidos
            </p>
            <div class="flex  gap-2 justify-between">
                <div class="">
                    <p class=" text-xs sm:text-base">
                        En esta sección puedes ver los pedidos que has
                        realizado.
                    </p>
                </div>
                <div class="flex mb-10 items-start content-center">
                    <div
                        @click="openModal(props.bankAccounts)"
                        class="p-3 flex items-center gap-2 flex-col text-white rounded-md cursor-pointer text-center bg-[#248ACB]"
                    >
                        <Icon
                            class=""
                            icon="bi:info-circle-fill"
                        />
                        <p class="text-xs">Pagos</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <ProfileOrder v-for="order in props.orders" :order="order" />
            </div>
        </WebProfileLayout>
    </WebLayout>
    <ModalsContainer />
</template>
