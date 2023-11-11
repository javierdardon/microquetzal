<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ModalsContainer, useModal } from "vue-final-modal";
import ModalCancelOrder from '@/Components/Admin/Orders/ModalCancelOrder.vue';

const props = defineProps({
    order: Object
});

const setShipping = ref(props.order.shipping_date ? true : false);
const requiredData = ref(setShipping.value ? 'required' : '');
const setPayment = ref(false);

const form = reactive({
    id: props.order.id,
    invoice: null,
    guide: props.order.guide,
    service: props.order.service,
    status: props.order.status,
    payment: null,
    shipping_date: null
});

const allStatus = [
    'En proceso',
    'En revisión',
    'Pagado',
    'Enviado',
    'Entregado',
    'Cancelado'
];

function update() {
    router.post("/admin/orders-update", form, {
        forceFormData: true,
    });
}

const deleteModal = useModal({
    component: ModalCancelOrder,
    attrs: {
        onConfirm() {
            update();
            deleteModal.close();
        },
        onClose() {
            deleteModal.close();
        },
    },
});

function submit() {
    if ( form.status === 'Cancelado' ) {
        deleteModal.open();
    } else {
        update();
    }
}

const useGoBack = useBack;
</script>

<template>
    <Head title="Actualizar Pedido" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h1 class="dark:text-white text-2xl font-bold">Actualizar pedido</h1>
            <ButtonNavigator
                href=""
                @click="useGoBack"
                text="Volver"
                type="button"
                method="get"
            />
        </div>
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-5 w-full">
            <FormKit
                type="form"
                @submit="submit"
                submit-label="Guardar"
            >
                <FormKit
                    v-model="form.status"
                    :options="allStatus"
                    type="select"
                    name="status"
                    label="Estado del pedido"
                    validation="required"
                    placeholder="Seleccionar..."
                />
                <FormKit
                    type="file"
                    label="Factura"
                    name="invoice"
                    id="invoice"
                    accept=".pdf"
                    v-model="form.invoice"
                />
                <FormKit
                    type="checkbox"
                    label="Agregar comprobante de pago"
                    name="payment"
                    v-model="setPayment"
                    label-class="$reset dark:text-white text-sm"
                />
                <FormKit
                    v-if="setPayment"
                    type="file"
                    label="Comprobante de Pago"
                    name="payment"
                    id="payment"
                    accept=".pdf,.jpg,.png,.jpeg"
                    v-model="form.payment"
                />
                <FormKit
                    type="checkbox"
                    label="Agregar Envío"
                    name="shipping"
                    v-model="setShipping"
                    label-class="$reset dark:text-white text-sm"
                />
                <FormKit
                    v-if="setShipping"
                    type="text"
                    name="guide"
                    id="guide"
                    maxlength="50"
                    label="Guía"
                    placeholder="3W233155182"
                    v-model="form.guide"
                    autocomplete="off"
                    autofocus
                    :validation="requiredData"
                />
                <FormKit
                    v-if="setShipping"
                    type="text"
                    name="service"
                    id="service"
                    maxlength="20"
                    label="Servicio de paquetería"
                    placeholder="Cargo Expreso"
                    v-model="form.service"
                    autocomplete="off"
                    autofocus
                    :validation="requiredData"
                />
            </FormKit>
        </div>
        <ModalsContainer />
    </AuthenticatedLayout>
</template>
