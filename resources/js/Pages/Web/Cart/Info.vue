<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { useAddress } from '@/Stores/address';
import { ref, watch, reactive } from 'vue';
import { submitForm } from '@formkit/vue';
import { Icon } from "@iconify/vue";

const props = defineProps({
    user: Object
});

//Stores
const cartStore = useCartStore();
const addressStore = useAddress();

if ( cartStore.cart.length < 1 ) {
    const basePath = window.location.origin;
    window.location.href = `${basePath}/carrito`;
}

//Store Functions
cartStore.reloadCart();
const shipping = cartStore.getShipping();

//cash subtotal
const subtotalCash = computed(() => {
    return cartStore.cart.reduce((total, current) => {
        return total + (Number(current.quantity) * Number(current.price));
    }, 0).toFixed(2);
});

//card subtotal
const subtotalCard = computed(() => {
    return cartStore.cart.reduce((total, current) => {
        return total + (Number(current.quantity) * Number(current.normal_price));
    }, 0).toFixed(2);
});

const quantity = computed(() => {
    return cartStore.cart.reduce((total, current) => {
        return total + current.quantity;
    }, 0);
});

// FormKit configurations (style)
const config = {
    classes: {
        input: '$reset appearance-none bg-white rounded text-black focus:outline-none focus:ring-0 focus:shadow-none w-full text-sm lg:text-base',
        label: '$reset block mb-2 font-bold text-sm lg:text-base text-black',
        outer: '$reset mb-4 lg:mb-6 grow',
        message: '$reset text-gray-600 text-xs',
        ui: '$reset text-gray-600 text-xs',
        wrapper: '$reset',
        submit: 'mt-2',
    }
};

// Variables declarations
const selectedDepartment = ref(props.user.department);
const selectedMunicipality = ref(props.user.municipality);
const departments = ref(addressStore.departments);
const municipalities = ref(selectedDepartment.value ? addressStore.municipalities[selectedDepartment.value] : []);

//Form
const shippingForm = reactive({
    name: props.user.name,
    lastname: props.user.lastname,
    address: props.user.address,
    department: selectedDepartment,
    municipality: selectedMunicipality,
    reference: props.user.reference,
    phone: props.user.phone,
    second_phone: props.user.second_phone,
    nit: props.user.nit,
    shipping_data: true,
    products: cartStore.cart
});

// Department watcher
watch(selectedDepartment, ( newDepartment ) => {
    municipalities.value = addressStore.municipalities[newDepartment];
    selectedMunicipality.value = null;
});

// if ( localStorage.hasOwnProperty('shippingForm') ) {
//     let savedShippingForm = JSON.parse( localStorage.getItem('shippingForm') );

//     shippingForm.name = savedShippingForm.name;
//     shippingForm.lastname = savedShippingForm.lastname;
//     shippingForm.address = savedShippingForm.address;
//     shippingForm.department = savedShippingForm.department;
//     shippingForm.reference = savedShippingForm.reference;
//     shippingForm.phone = savedShippingForm.phone;
//     shippingForm.second_phone = savedShippingForm.second_phone;
//     shippingForm.shipping_data = savedShippingForm.shipping_data;
//     shippingForm.municipality = savedShippingForm.municipality;
// }

const total = cartStore.paymentMethod === 'cash' ? subtotalCash : subtotalCard;
const nitType = ref(Number(total.value) > 2500 ? 'number' : 'text');

function submit() {
    localStorage.setItem('shippingForm', JSON.stringify(shippingForm));
    router.get('/carrito/metodo-envio');
}
</script>
<template>
    <Head title="Informacion de envío" />
    <WebLayout>
        <div class="py-32 pb-16 container mx-auto lg:px-60">
            <h1 class="font-display text-[2rem] text-center sm:text-[3.05rem] xl:text-6xl 2xl:text-7xl uppercase mb-3">
                <span class="hidden md:inline">Informacion de </span>envio
            </h1>
            <div class="mx-4 bg-gray-100 p-3 rounded flex flex-col gap-3">
                <div class="col-span-2 xl:text-lg 2xl:text-xl">
                    Por favor llena tu información de envío
                </div>
                <div class="bg-white rounded p-5">
                    <FormKit
                          type="form"
                          :actions="false"
                          id="shippingSubmittion"
                          @submit="submit"
                        >
                        <div class="lg:grid lg:grid-cols-2 lg:gap-x-4 lg:mb-3">
                            <FormKit
                                type="text"
                                name="name"
                                id="name"
                                label="Nombre"
                                :config="config"
                                v-model="shippingForm.name"
                                placeholder="Fernando"
                                validation="required|length:1,15"
                                maxlength="15"
                                autocomplete="on"
                            />
                            <FormKit
                                type="text"
                                name="lastName"
                                id="lastName"
                                label="Apellido"
                                :config="config"
                                v-model="shippingForm.lastname"
                                placeholder="Herrera"
                                validation="required|length:1,15"
                                maxlength="15"
                                autocomplete="on"
                            />
                            <FormKit
                                type="text"
                                name="address"
                                id="address"
                                label="Dirección exacta"
                                v-model="shippingForm.address"
                                :config="config"
                                :classes="{
                                    outer: 'lg:col-span-2',
                                }"
                                placeholder="4ta avenida 10-50"
                                validation="required|length:1,100"
                                maxlength="100"
                                autocomplete="on"
                            />

                            <FormKit
                                v-model="selectedDepartment"
                                :options="departments"
                                type="select"
                                :config="config"
                                name="department"
                                label="Departmento"
                                validation="required"
                                placeholder="Seleccionar..."
                            />

                            <FormKit
                                v-model="selectedMunicipality"
                                :options="municipalities"
                                type="select"
                                :config="config"
                                name="municipality"
                                label="Municipio"
                                validation="required"
                                placeholder="Seleccionar..."
                            />

                            <FormKit
                                type="text"
                                name="reference"
                                id="reference"
                                label="Indicaciones extra de entrega (opcional)"
                                :config="config"
                                :classes="{
                                    outer: 'lg:col-span-2 mb-6',
                                }"
                                v-model="shippingForm.reference"
                                placeholder="Tocar timbre"
                                validation="length:1,100"
                                maxlength="100"
                            />
                            <FormKit
                                type="tel"
                                name="phone"
                                :config="config"
                                v-model="shippingForm.phone"
                                label="Teléfono"
                                placeholder="22222222"
                                validation="number|length:8|required"
                                maxlength="8"
                                autocomplete="on"
                            />
                            <FormKit
                                type="tel"
                                name="second_phone"
                                :config="config"
                                v-model="shippingForm.second_phone"
                                label="Teléfono adicional (opcional)"
                                placeholder="55555555"
                                validation="number|length:8"
                                maxlength="8"
                                autocomplete="on"
                            />
                            <FormKit
                                :type="nitType"
                                name="nit"
                                id="nit"
                                label="NIT"
                                v-model="shippingForm.nit"
                                :config="config"
                                :classes="{
                                    outer: 'lg:col-span-2',
                                }"
                                placeholder="12341234"
                                maxlength="20"
                                autocomplete="on"
                                validation="required"
                            />
                            <FormKit
                                type="checkbox"
                                label="Guardar mis datos de envío"
                                name="shipping_data"
                                v-model="shippingForm.shipping_data"
                                label-class="$reset text-sm text-black ml-1"
                            />
                        </div>
                    </FormKit>
                </div>
            </div>
            <div class="flex flex-col mx-4 bg-gray-100 p-3 rounded my-3">
                <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg border-b border-gray-200">
                    <span>Cantidad</span>
                    <span>{{ quantity }}</span>
                </span>
                <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg border-b border-gray-200">
                    <span>Envío</span>
                    <span>{{ shipping ? 'No incluído' : 'Incluído' }}</span>
                </span>
                <span class="bg-white flex justify-between p-3 text-sm 2xl:text-lg">
                    <span>Subtotal</span>
                    <span>Q {{ cartStore.paymentMethod === 'cash' ? subtotalCash : subtotalCard }}</span>
                </span>
            </div>

            <div class="mx-4 my-2 grid grid-cols-2 gap-2 lg:float-right">
                <Link href="/carrito" as="a" type="button" class="text-white bg-[#474949] hover:shadow-lg hover:shadow-blue-400/100 duration-300 hover:bg-[#248ACB] focus:ring-none focus:outline-none rounded py-2.5 w-full lg:w-60 flex items-center justify-center">
                    <Icon class="text-sm lg:text-md mr-4" icon="ooui:arrow-previous-ltr" />
                    <span class="text-lg lg:text-lg">Regresar</span>
                </Link>
                <button @click="submitForm('shippingSubmittion')" type="button" class="text-white hover:shadow-lg hover:shadow-blue-400/100 duration-300 bg-[#248ACB] focus:ring-none focus:outline-none rounded py-2.5 w-full lg:w-60 flex items-center justify-center">
                    <span class="text-lg lg:text-lg">Continuar</span>
                    <Icon class="text-sm lg:text-md ml-4" icon="ooui:arrow-next-ltr" />
                </button>
            </div>
        </div>
    </WebLayout>
</template>
