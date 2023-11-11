import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useProductsStore = defineStore( 'products', () => {

  const products = ref([]);
  const featuredProducts = ref([])

//   const selectedProduct = ref({
//     id: 0,
//     name: "",
//     images: "",
//     price: '',
//     brand_id: 0,
//     category_id: 0,
//     description: "",
//     warranty: '',
//     visacuotas: false,
//     featured: false,
//     quantity: 0,
//     details: {},
//     brand: {
//       id: 0,
//       name: ''
//     },
//     category: {
//       id: 0,
//       name: ''
//     }
//   });

  const updateProducts = ( allProducts ) => {
    products.value = allProducts
  }

  const updateFeaturedProducts = ( allProducts ) => {
    featuredProducts.value = allProducts
  }

//   const updateProduct = ( Product ) => {
//     selectedProduct.value = Product
//   }

  return { products, updateProducts, featuredProducts, updateFeaturedProducts /* selectedProduct, updateProduct*/ }

})
