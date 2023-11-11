<script setup>
// Vue Props
const props = defineProps({
  name: String,
  price: String,
  images: String,
  code: Number,
  warranty: String,
  sale: Boolean,
  quantity: Number,
  percentage: Number,
  salePrice: String,
});

const formattedPrice = useFormatPrice;
</script>

<template>
    <div
    data-aos="fade-up"
    :class="props.sale && props.quantity
      ? `w-full max-w-[17rem] 2xl:max-w-[19rem] h-full border border-[#E4E4E4] flex flex-col gap-1 md:gap-2 rounded-[10px] ease-in duration-300 hover:shadow-lg hover:shadow-blue-300 cursor-pointer overflow-hidden`

      : `w-full max-w-[17rem] 2xl:max-w-[19rem] h-full border border-[#E4E4E4] flex flex-col gap-1 md:gap-2 rounded-[10px] ease-in duration-300 hover:shadow-lg hover:shadow-gray-300/100 cursor-pointer overflow-hidden`
    ">

        <div class="pt-2 px-2 flex flex-column items-center overflow-hidden relative">
            <span
              class="absolute top-1.5 -right-7 px-8 md:top-3 md:-right-12 bg-[#248CBA] text-[0.60rem] md:text-base text-white md:px-14 shadow-md shadow-gray-400 rotate-[20deg]"
              v-if="props.percentage && props.quantity"
            >
              Oferta -{{ props.percentage }}%
            </span>
            <img
              :src="props.images"
              alt=""
              class="h-full max-h-[10rem] sm:max-h-[12rem] 2xl:max-h-[14rem] w-full object-contain"
            />
        </div>

        <div class="flex flex-col items-center justify-center gap-3 px-3 md:px-5 rounded-b-[10px] bg-white py-3 my-auto">
            <p class="text-[0.68rem] sm:text-xs md:text-sm 2xl:text-base text-center font-bold font-sans uppercase overflow-hidden text-black break-words">
                {{ props.name }}
            </p>
            <div class="flex flex-col" v-if="props.quantity">
                <p class="text-sm md:text-xl 2xl:text-2xl text-[#248ACB] text-center font-bold font-sans" v-if="!props.sale">
                    Q {{ formattedPrice(props.price) }}
                </p>
                <p v-if="props.sale" class="text-[0.84rem] md:text-[1.23rem] 2xl:text-2xl text-center font-bold font-sans bg-[#248ACB] text-white px-2 rotate-[-2deg]">
                      Q {{ formattedPrice(props.salePrice) }}
                </p>
            </div>
            <p class="text-sm md:text-base text-gray-500 text-center font-bold font-sans" v-else>Sin existencias</p>
        </div>

    </div>
</template>
