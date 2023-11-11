<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";

const form = useForm({
    email: '',
    password: '',
    remember: false,
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
    form.post(route('web.auth.login.store'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<template>
    <Head>
        <title>Iniciar sesión</title>
        <meta name="description" content="Iniciar sesión en Micro Quetzal Nacional">
    </Head>
    <WebLayout>
        <div class="pt-32 pb-2 md:pb-4 lg:pb-20 md:pt-44 flex flex-col items-center container mx-auto">
            <h1 class="font-display text-[2rem] sm:text-[3.05rem] xl:text-6xl 2xl:text-7xl">
                INICIAR SESION
            </h1>
            <div class="my-8">
                <FormKit
                    type="form"
                    @submit="submit"
                    :actions="false"
                >
                    <div class="grid grid-cols-2 gap-4 px-4">
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
                            validation-visibility="blur"
                            :classes="{
                                outer: 'col-span-2'
                            }"
                        />
                        <FormKit
                            type="checkbox"
                            label="Recordarme"
                            name="remember"
                            v-model="form.remember"
                        />
                        <Button
                          type="submit"
                          title="Iniciar sesión"
                          text-color="text-white"
                          background-color="bg-[#248ACB]"
                          :left-icon="false"
                          :right-icon="false"
                          extra="px-10 py-2 uppercase"
                          font-size="text-xs sm:text-sm md:text-md lg:text-lg xl:text-xl 2xl:text-2xl w-full mt-2"
                        />
                    </div>
                </FormKit>

                <div class="px-2 my-5">
                    <p>¿Aún no tienes una cuenta?
                        <Link class="ml-2 text-[#248ACB]" href="/registrarse">Registrate aquí</Link>
                    </p>
                </div>
            </div>
        </div>
    </WebLayout>
</template>
