<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import { submitForm } from '@formkit/vue';

const form = useForm({
    name: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const config = {
    classes: {
        input: '$reset appearance-none bg-white rounded text-black focus:outline-none focus:ring-0 focus:shadow-none w-full',
        label: '$reset block mb-2 font-bold text-base text-black',
        outer: '$reset mb-1 lg:mb-6 grow',
        wrapper: '$reset w-full',
    }
}

const submit = () => {
    form.post(route('web.auth.register.store'));
}

const rules = {
    async checkPassword ({ value }) {
        return new Promise((r) => setTimeout(() => r(value === form.password), 400))
  }
}
</script>
<template>
    <Head>
        <title>Registrarse</title>
        <meta name="description" content="Registrate en Micro Quetzal Nacional">
    </Head>
    <WebLayout>
        <div class="pt-32 pb-2 md:pb-4 lg:pb-20 md:pt-44 flex flex-col items-center container mx-auto">
            <h1 class="font-display text-[2rem] sm:text-[3.05rem] xl:text-6xl 2xl:text-7xl">
                REGISTRARSE
            </h1>
            <div class="my-8">
                <FormKit
                    type="form"
                    @submit="submit"
                    :actions="false"
                    id="registration"
                >
                    <div class="grid grid-cols-2 gap-4 px-4">
                        <FormKit
                            type="text"
                            id="name"
                            name="name"
                            v-model="form.name"
                            label="Nombre"
                            label-class="capitalize"
                            placeholder="Tecún"
                            :config="config"
                            maxlength="15"
                            validation="required"
                            :classes="{
                                outer: 'col-span-1'
                            }"
                        />
                        <FormKit
                            type="text"
                            id="lastname"
                            name="lastname"
                            v-model="form.lastname"
                            label="Apellido"
                            label-class="capitalize"
                            placeholder="Umán"
                            :config="config"
                            maxlength="15"
                            validation="required"
                            :classes="{
                                outer: 'col-span-1'
                            }"
                        />
                        <FormKit
                            type="email"
                            id="email"
                            name="email"
                            v-model="form.email"
                            label="Correo electrónico"
                            label-class="capitalize"
                            placeholder="itsTecunUman@email.com"
                            :config="config"
                            :classes="{
                                outer: 'col-span-2'
                            }"
                            maxlength="50"
                            validation="required"
                        />
                        <FormKit
                            type="password"
                            id="password"
                            name="password"
                            v-model="form.password"
                            label="Contraseña"
                            label-class="capitalize"
                            placeholder="********"
                            :config="config"
                            minlength="8"
                            maxlength="20"
                            validation="required"
                            :classes="{
                                outer: 'col-span-1'
                            }"
                        />
                        <FormKit
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            v-model="form.password_confirmation"
                            label="Confirmar"
                            label-class="capitalize"
                            placeholder="********"
                            :config="config"
                            minlength="8"
                            maxlength="20"
                            validation="required|checkPassword"
                            validation-visibility="blur"
                            :validation-rules="rules"
                            :validation-messages=" {checkPassword: 'Contraseñas no coinciden.'} "
                            :classes="{
                                outer: 'col-span-1'
                            }"
                        />
                        <Button
                          type="submit"
                          title="Registrarse"
                          text-color="text-white"
                          background-color="bg-[#248ACB]"
                          :left-icon="false"
                          :right-icon="false"
                          extra="px-10 py-2 uppercase"
                          font-size="text-lg sm:text-xl md:text-xl lg:text-xl xl:text-2xl col-start-1 col-end-3 lg:col-start-2 lg:col-end-3 mb-10"
                        />
                    </div>
                </FormKit>
                <div class="px-2 my-5">
                    <p>¿Ya tienes una cuenta?
                        <Link class="ml-2 text-[#248ACB]" href="/iniciar-sesion">Inicia sesión aquí</Link>
                    </p>
                </div>
            </div>
        </div>
    </WebLayout>
</template>
