<script setup>
import { Link } from '@inertiajs/vue3';

// Store declaration
const productsStore = useProductsStore();

</script>

<template>
  <div class=" md:container md:mx-auto md:w-full px-5 sm:px-12 md:px-5 lg:px-10 xl:px-14">
    <p
      class="cursor-default bg-clip-text text-transparent animate-charcter font-display text-[2rem] py-[2rem] md:text-[4rem] font-display uppercase text-center xl:text-left"
    >
      productos destacados
    </p>

      <div
        class="w-full grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6 md:gap-y-8 xl:gap-y-10 pb-6"
      >
        <div
          v-for="product in productsStore.featuredProducts"
          class="h-full w-full flex justify-center"
          :key="product.id"
        >

          <Link
            :href="route('web.products.view', product.id)"
            class="h-full w-full flex justify-center"
          >
            <Product
              :quantity="product.quantity"
              :name="product.name"
              :price="product.price"
              :images="product.images"
              :warranty="product.warranty"
              :code="product.id"
              :sale="product.sale"
              :percentage="product.percentage"
              :sale-price="product.sale_price"
            />
          </Link>
        </div>
      </div>


    <div class="flex justify-center items-center md:justify-end">
      <Link href="/productos">
        <Button
          title="ver todos"
          icon-name="pajamas:long-arrow"
          text-color="text-black"
          background-color="bg-white"
          hover="hover:text-[#248ACB] hover:border-[#248ACB] hover:shadow-lg hover:shadow-blue-500/100 duration-300"
          :left-icon="false"
          :big-text="true"
          font-size="text-[1.5rem] 2xl:text-[2rem]"
          extra="border border-2 border-black text-[1.5rem] 2xl:text-[2rem]"
        />
      </Link>
    </div>
  </div>

  <HomeFeaturedProductsSeparator
    class="mt-[2rem] px-7"
    text="descubre nuestros equipos "
  />
</template>

<style scoped>
.animate-charcter
{
  text-transform: uppercase;
  background-image: linear-gradient(
    -225deg,
    #248ACB 0%,
    #9142F8 25%,
    #ED63F9 50%,
    #9142F8 75%,
    #248ACB 100%
  );
  background-size: 200% auto;
  color: #fff;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: textclip 1.5s linear infinite;
  display: inline-block;
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}
</style>
