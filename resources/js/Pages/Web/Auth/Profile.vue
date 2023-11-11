<script setup>
import WebProfileLayout from '@/Layouts/WebProfileLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { useAddress } from '@/Stores/address';
import { ref, watch, reactive } from 'vue';

// Props from controller
const props = defineProps({
    user: Object,
});

// Store declarations
const addressStore = useAddress();

// FormKit configurations (style)
const config = {
    classes: {
        input: '$reset appearance-none bg-white rounded text-black focus:outline-none focus:ring-0 focus:shadow-none w-full text-sm lg:text-base',
        label: '$reset block mb-2 font-bold text-sm lg:text-base text-black',
        outer: '$reset mb-4 lg:mb-6 grow',
        message: '$reset text-gray-600 text-xs',
        ui: '$reset text-gray-600 text-xs',
        wrapper: '$reset max-w-[20rem] lg:max-w-none',
        submit: 'mt-2',
    }
};

// Variables declarations
const selectedDepartment = ref(props.user.department);
const selectedMunicipality = ref(props.user.municipality);
const departments = ref(addressStore.departments);
const municipalities = ref(selectedDepartment.value ? addressStore.municipalities[selectedDepartment.value] : []);

// Main information form
const mainForm = useForm({
    name: props.user.name,
    lastname: props.user.lastname,
    email: props.user.email,
    phone: props.user.phone,
    second_phone: props.user.second_phone,
    nit: props.user.nit,
})

// Address information form
const addressForm = reactive({
    department: selectedDepartment,
    municipality: selectedMunicipality,
    address: props.user.address,
    reference: props.user.reference,
})

// Password reset form
const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

// Department watcher
watch(selectedDepartment, ( newDepartment ) => {
    municipalities.value = addressStore.municipalities[newDepartment];
    selectedMunicipality.value = null;
});

// Main info submittion function
const updateMainInfo = () => {
    router.patch('/perfil/main', mainForm);
}

// Address info submittion function
const updateAddress = () => {
    router.patch('/perfil/address', addressForm);
}

// Password reset submittion function
const setNewPassword = () => {
    router.patch('/perfil/pass', passwordForm);
}

const rules = {
  async checkPassword ({ value }) {
    return new Promise((r) => setTimeout(() => r(passwordForm.password === passwordForm.password_confirmation), 100))
  }
}
</script>

<template>
    <Head title="Mi Perfil" />
    <WebLayout>
        <WebProfileLayout>
            <div class="mt-3 mb-16">
                <p class="text-2xl sm:text-3xl mb-4 uppercase font-display">Perfil</p>
                <p class="text-xl sm:text-2xl mb-2">Datos</p>
                <p class="text-sm sm:text-base mb-5 lg:mb-8">En esta sección puedes modificar la información de tu perfil.</p>
                <FormKit
                    type="form"
                    :actions="false"
                    id="mainSubmittion"
                    @submit="updateMainInfo"
                >
                    <div class="max-w-[32rem] lg:grid lg:grid-cols-2 lg:gap-x-4 lg:mb-3">
                        <FormKit
                            type="text"
                            name="name"
                            id="name"
                            label="Nombre"
                            :config="config"
                            v-model="mainForm.name"
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
                            v-model="mainForm.lastname"
                            placeholder="Herrera"
                            validation="required|length:1,15"
                            maxlength="15"
                            autocomplete="on"
                        />
                        <FormKit
                            type="email"
                            name="email"
                            id="email"
                            label="Correo electrónico"
                            v-model="mainForm.email"
                            :config="config"
                            :classes="{
                                outer: 'lg:col-span-2',
                            }"
                            placeholder="example@gmail.com"
                            validation="required"
                            maxlength="50"
                            autocomplete="on"
                        />

                        <FormKit
                            type="tel"
                            name="phone"
                            :config="config"
                            v-model="mainForm.phone"
                            label="Teléfono"
                            placeholder="22222222"
                            validation="required|number|length:8"
                            maxlength="8"
                            autocomplete="on"
                        />

                        <FormKit
                            type="tel"
                            name="second_phone"
                            :config="config"
                            v-model="mainForm.second_phone"
                            label="Teléfono adicional (opcional)"
                            placeholder="55555555"
                            validation="number|length:8"
                            maxlength="8"
                            autocomplete="on"
                        />

                        <FormKit
                            type="text"
                            name="nit"
                            id="nit"
                            label="NIT"
                            v-model="mainForm.nit"
                            :config="config"
                            :classes="{
                                outer: 'mb-6',
                            }"
                            placeholder="12341234"
                            maxlength="20"
                            autocomplete="on"
                        />
                    </div>

                    <Button
                        type="submit"
                        title="Guardar"
                        icon-name="game-icons:check-mark"
                        text-color="text-white"
                        background-color="bg-[#474949]"
                        font-size="text-sm"
                        hover="hover:bg-[#248ACB] hover:shadow-lg hover:shadow-blue-400/100 duration-300"
                        :big-text="false"
                        :left-icon="false"
                        extra="rounded-lg py-2.5 sm:py-3 px-4"
                    />
                </FormKit>
            </div>

            <div class="mb-16">
                <p class="text-xl sm:text-2xl mb-6">Modificar Dirección</p>
                <FormKit
                    type="form"
                    :actions="false"
                    id="addressSubmittion"
                    @submit="updateAddress"
                >
                    <div class="max-w-[32rem] grid grid-cols-1 lg:grid-cols-2 lg:gap-x-4 lg:gap-y-2 lg:mb-3">
                        <FormKit
                            type="text"
                            name="address"
                            id="address"
                            label="Dirección exacta"
                            v-model="addressForm.address"
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
                            v-model="addressForm.reference"
                            placeholder="Tocar timbre"
                            validation="length:1,100"
                            maxlength="100"
                        />
                    </div>

                    <Button
                        type="submit"
                        title="Guardar dirección"
                        icon-name="fa6-solid:house"
                        text-color="text-white"
                        background-color="bg-[#474949]"
                        font-size="text-sm"
                        hover="hover:bg-[#248ACB] hover:shadow-lg hover:shadow-blue-400/100 duration-300"
                        :big-text="false"
                        :left-icon="true"
                        extra="rounded-lg py-2.5 sm:py-3 px-4"
                    />
                </FormKit>
            </div>


            <div class="mb-5">
                <p class="text-xl sm:text-2xl mb-3">Seguridad</p>
                <p class="text-sm sm:text-base mb-5">Cambia la contraseña de tu cuenta.</p>
                <FormKit
                    type="form"
                    :actions="false"
                    id="passwordSubmittion"
                    @submit="setNewPassword"
                >
                    <div class="max-w-[32rem] grid grid-cols-1 lg:grid-cols-2 lg:gap-x-4 lg:gap-y-2 lg:mb-3">
                        <FormKit
                            type="password"
                            id="current_password"
                            name="current_password"
                            v-model="passwordForm.current_password"
                            label="Contraseña actual"
                            :config="config"
                            :classes="{
                                outer: 'lg:col-span-2',
                            }"
                            minlength="8"
                            maxlength="20"
                            validation="required"
                        />
                        <FormKit
                            type="password"
                            id="password"
                            name="password"
                            v-model="passwordForm.password"
                            label="Nueva contraseña"
                            :config="config"
                            minlength="8"
                            maxlength="20"
                            validation="required"
                        />
                        <FormKit
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            v-model="passwordForm.password_confirmation"
                            label="Confirmar nueva contraseña"
                            :classes="{
                                outer: 'mb-6',
                            }"
                            :config="config"
                            minlength="8"
                            maxlength="20"
                            validation="checkPassword|required"
                            :validation-rules="rules"
                            :validation-messages="{ checkPassword: 'Contraseñas no coinciden.' }"
                        />
                    </div>
                    <Button
                        type="submit"
                        title="Cambiar contraseña"
                        text-color="text-white"
                        background-color="bg-[#474949]"
                        icon-name="tabler:shield-lock-filled"
                        font-size="text-sm"
                        hover="hover:bg-[#248ACB] hover:shadow-lg hover:shadow-blue-400/100 duration-300"
                        :big-text="false"
                        :left-icon="false"
                        extra="rounded-lg py-2.5 sm:py-3 px-4"
                    />
                </FormKit>
            </div>

        </WebProfileLayout>
    </WebLayout>
</template>
