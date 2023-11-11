<script setup>
import { VueFinalModal } from "vue-final-modal";
import { Icon } from "@iconify/vue";
import { facebook, whatsapp } from "@formkit/icons";

const props = defineProps({
    accounts: Object,
});

const socialLinkStore = useSocialLinks();

const emit = defineEmits(["close"]);
</script>

<template>
    <VueFinalModal
        content-transition="vfm-fade"
        class="flex justify-center items-center"
        content-class="flex flex-col mx-4 bg-white rounded-lg p-4"
    >
        <div
            class="gap-y-5 p-5 flex flex-col text-center justify-center items-center"
        >
            <div class="flex items-center gap-2">
                <Icon icon="fluent:payment-20-filled" class="text-[#248ACB] text-xl" />
                <p class="uppercase">Pagos</p>
            </div>
            <p>Al realizar tu pedido nosotros nos comunicaremos contigo para poder realizar tu pago</p>

            <p class="uppercase mt-5">Depósito a cuentas</p>

            <div class="flex flex-col justify-center items-center gap-5">
                <div
                    class="bg-white "
                    v-for="account in props.accounts"
                >
                    <p class="font-bold">{{ account.bank_name }} - <span class="text-[#248ACB]">{{account.account_number}}</span></p>
                    <p class="font-mono uppercase text-xs text-gray-400 tracking-[.30em] lg:text-sm text-center">{{ account.account_name }}</p>
                </div>
            </div>

            <div
                class="flex"
            >
                <div
                    v-for="(link, key) in socialLinkStore.SocialLinksList"
                    :key="link.icon"
                >
                    <a v-if="link.link &&  key === 'facebook' || key === 'whatsapp'" :href="link.link" target="_blank">
                        <Icon
                            v-if="link.link"
                            :class="
                                link.link
                                    ? `m-3 w-7 h-7 hover:-rotate-12 duration-150`
                                    : `w-7 h-7 hover:-rotate-12 duration-150`
                            "
                            :icon="link.icon"
                        />
                    </a>
                </div>
            </div>
        </div>
    </VueFinalModal>
</template>

<!--
 -->
