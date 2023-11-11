<script setup>
import { Head } from '@inertiajs/vue3';
import { Icon } from "@iconify/vue";

const props = defineProps({
    order: Object
});

const rows = ref([]);

props.order.products.forEach((product) => {
    rows.value.push({
        name: product.name,
        quantity: product.quantity,
        sale: product.sale_product ? 'Sí' : 'No',
        price: product.price
    });
})

const useGoBack = useBack;

const shipping = ref('');

switch (props.order.shipping) {
    case 'prevPay':
        shipping.value = 'Envío con pago anticipado';
        break;
    case 'cashShipping':
        shipping.value = 'Envío contra entrega interior del país';
        break;
    case 'cashShippingGT':
        shipping.value = 'Envío contra entrega ciudad capital';
        break;
    case 'noShipping':
        shipping.value = 'Recoger en oficina Retalhuleu';
        break;
    default:
        break;
}
</script>

<template>
    <Head title="Ver Pedido" />
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h1 class="dark:text-white text-2xl font-bold">Ver Pedido</h1>
            <ButtonNavigator
                href=""
                @click="useGoBack"
                text="Volver"
                type="button"
                method="get"
            />
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 w-full">
            <div class="flex justify-between">
                <div>
                    <div class="dark:text-white text-2xl">
                        {{ `Pedido #${order.id}` }}
                    </div>
                    <div class="flex flex-col text-md">
                        <span class="dark:text-slate-300">Fecha: <span class="font-mono">{{ order.created_at }}</span></span>
                        <span class="dark:text-slate-300">Artículos: <span class="font-mono">{{ order.quantity }}</span></span>
                        <span class="dark:text-slate-300">Estado: <span class="font-mono">{{ order.status }}</span></span>
                        <span class="dark:text-slate-300">Total: <span class="font-mono">Q.{{ order.total - order.total_shipping }}</span></span>
                        <span v-if="order.payment_date" class="dark:text-slate-300">Fecha de pago: <span class="font-mono">{{ order.payment_date }}</span></span>
                    </div>
                </div>
                <div class="flex">
                    <a v-if="order.payment" :href="`/${order.payment}`" download="Boleta de Pago" title="Boleta de Pago">
                        <Icon icon="fluent:document-48-filled" class="text-4xl dark:text-white text-black" />
                    </a>
                    <a v-if="order.invoice" :href="`/${order.invoice}`" download="Factura" title="Factura">
                        <Icon icon="bxs:file-doc" class="text-4xl dark:text-white text-black" />
                    </a>
                </div>
            </div>
            <div class="border-t border-solid border-gray-700 my-5"></div>
            <div class="dark:text-white text-2xl">
                Información del cliente:
            </div>
            <div class="flex flex-col text-md">
                <span class="dark:text-slate-300">Nombre: <span class="font-mono">{{ `${order.user.name} ${order.user.lastname}` }}</span></span>
                <span class="dark:text-slate-300">Dirección: <span class="font-mono">{{ `${order.department} - ${order.municipality} - ${order.address} ${order.reference ? '-'+order.reference : ''}`  }}</span></span>
                <span class="dark:text-slate-300">Teléfono: <span class="font-mono">{{ order.phone  }}</span></span>
                <span class="dark:text-slate-300" v-if="order.second_phone">Teléfono secundario: <span class="font-mono">{{ order.second_phone  }}</span></span>
                <span class="dark:text-slate-300">Correo electrónico: <span class="font-mono">{{ order.user.email  }}</span></span>
                <span class="dark:text-slate-300">NIT: <span class="font-mono">{{ order.nit  }}</span></span>
            </div>
            <div class="border-t border-solid border-gray-700 my-5"></div>
            <div class="dark:text-white text-2xl">
                Información de pago:
            </div>
            <div class="flex flex-col text-md">
                <span class="dark:text-slate-300">Método de pago: <span class="font-mono">{{ order.paymentMethod === 'cash' ? 'Efectivo/Bancario' : 'Tarjeta' }}</span></span>
                <span v-if="order.paymentMethod === 'card'" class="dark:text-slate-300">Tarjeta: <span class="font-mono">{{ order.card }}</span></span>
                <span class="dark:text-slate-300">Tipo de pago: <span class="font-mono">{{ order.paymentType === 'FULL' ? 'Al contado' : 'Cuotas' }}</span></span>
                <span v-if="order.paymentType === 'DUES'" class="dark:text-slate-300">Cuotas: <span class="font-mono">{{ `${order.dues} de Q${order.duesQuantity}` }}</span></span>
            </div>
            <div class="border-t border-solid border-gray-700 my-5"></div>
            <div class="dark:text-white text-2xl">
                Información de envío:
            </div>
            <div class="flex flex-col text-md mb-6">
                <span class="dark:text-slate-300">Método de envío: <span class="font-mono">{{ shipping }}</span></span>
                <span class="dark:text-slate-300">Coste de envío: <span class="font-mono">{{ order.total_shipping < 1 ? 'Incluído' : 'Q'+order.total_shipping }}</span></span>
                <span v-if="order.service" class="dark:text-slate-300">Paquetería: <span class="font-mono">{{ order.service }}</span></span>
                <span v-if="order.guide" class="dark:text-slate-300">Guía: <span class="font-mono">{{ order.guide }}</span></span>
                <span v-if="order.guide" class="dark:text-slate-300">Fecha de envío: <span class="font-mono">{{ order.shipping_date }}</span></span>
            </div>
            <div class="border-t border-solid border-gray-700 my-5"></div>
            <div class="relative overflow-x-auto rounded-lg mb-7">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 dark:text-white">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3 dark:text-white text-center">
                                Cantidad
                            </th>
                            <th scope="col" class="px-6 py-3 dark:text-white text-center">
                                Oferta
                            </th>
                            <th scope="col" class="px-6 py-3 dark:text-white text-right">
                                Precio C/U
                            </th>
                            <th scope="col" class="px-6 py-3 dark:text-white text-right">
                                Precio Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in rows" :key="product.name" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td scope="row"  class="px-6 py-4">
                                {{ product.name }}
                            </td>
                            <td  class="px-6 py-4 text-center">
                                {{ product.quantity }}
                            </td>
                            <td  class="px-6 py-4 text-center">
                                {{ product.sale }}
                            </td>
                            <td  class="px-6 py-4 text-right">
                                {{ `Q.${product.price}` }}
                            </td>
                            <td  class="px-6 py-4 text-right">
                                {{ `Q.${(product.price * product.quantity).toFixed(2)}` }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
