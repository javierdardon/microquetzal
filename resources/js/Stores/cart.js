import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useCartStore = defineStore('cart',() =>{

    const cart = ref([]);
    const subtotal = ref(0);
    const paymentMethod = ref((localStorage.getItem('paymentMethod') !== 'null' ? localStorage.getItem('paymentMethod') : false) || 'cash');
    const paymentType = ref((localStorage.getItem('paymentType') !== 'null' ? localStorage.getItem('paymentType') : false) || 'FULL');
    const cardBrand = ref((localStorage.getItem('cardBrand') !== 'null' ? localStorage.getItem('cardBrand') : false) || null);
    const dues = ref((localStorage.getItem('dues') !== 'null' ? localStorage.getItem('dues') : false) || null);

    const updateCart = () => {
        cart.value = JSON.parse( localStorage.getItem('cart') );
    }

    const searchItem = ( id, type ) => {
        let itemType = type === 'product' ? "product" : "pc";

        return cart.value.find( (cartItem) => cartItem.id === id && cartItem.type === itemType );
    }

    const getIndex = ( id, type ) => {
        let itemType = type === 'product' ? "product" : "pc";

        return cart.value.indexOf( cart.value.find( (cartItem) => cartItem.id === id && cartItem.type === itemType ) )
    }

    const setSubtotal = () => {
        //Getting cart of localstorage
        cart.value = JSON.parse( localStorage.getItem('cart') );

        cart.value.forEach( item => {
            subtotal.value += Number(item.price);
        });
    }

    const addToCart = ( item, type, quantity ) => {
        //Getting cart of localstorage
        cart.value = JSON.parse( localStorage.getItem('cart') );

        //Validate product if exist in cart.value
        if ( searchItem(item.id, type) ) {
            let itemIndex = getIndex( item.id, type );

            //Validate quantity
            if ( quantity > cart.value[itemIndex].quantity  ) {
                cart.value[itemIndex].quantity += 1;
            } else {
                return { status: 'error', message: 'Lo sentimos, cantidad máxima del producto' }
            }
        } else {
            //Adding product
            cart.value.push({
                id: item.id,
                name: item.name,
                image: item.images,
                price: item.sale ? item.sale_price : item.price,
                normal_price: item.sale ? item.sale_normal_price : item.normal_price,
                type: type,
                quantity: 1,
                max_quantity: quantity,
                shipping: item.shipping
            });
        }

        //Updating cart.value
        localStorage.setItem('cart', JSON.stringify(cart.value));

        return { status: 'success', message: 'El producto se agregó al carrito' }
    }

    const subtractFromCart = ( id, type ) => {
        //Getting cart of localstorage
        cart.value = JSON.parse( localStorage.getItem('cart') );

        //Validate product if exist in cart
        if ( searchItem( id, type ) ) {
            let itemIndex = getIndex( id, type );

            cart.value[itemIndex].quantity -= 1;

            if ( cart.value[itemIndex].quantity === 0 ) {
                cart.value.splice(itemIndex, 1)
            }
        }

        //Updating cart.value
        localStorage.setItem('cart', JSON.stringify(cart.value));

        setSubtotal();
    }

    const deleteFromCart = ( id, type ) => {
        //Getting cart of localstorage
        cart.value = JSON.parse( localStorage.getItem('cart') );

        //Validate product if exist in cart
        if ( searchItem( id, type ) ) {
            let itemIndex = getIndex( id, type );

            cart.value.splice(itemIndex, 1);
        }

        //Updating cart.value
        localStorage.setItem('cart', JSON.stringify(cart.value));

        setSubtotal();
    }

    const getShipping = () => {
        //Getting cart of localstorage
        cart.value = JSON.parse( localStorage.getItem('cart') );

        return cart.value.find( item => item.shipping === false );
    }

    const reloadCart = () => {
        //Getting cart of localstorage
        cart.value = JSON.parse( localStorage.getItem('cart') );
    }

    const clearCart = () => {
        localStorage.setItem('cart', JSON.stringify([]));
        localStorage.setItem('paymentType', null);
        localStorage.setItem('cardBrand', null);
        localStorage.setItem('paymentMethod', null);
        localStorage.setItem('dues', null);
        cart.value = [];
    }

    return { cart, subtotal, updateCart, addToCart, subtractFromCart, deleteFromCart, getShipping, reloadCart, clearCart, paymentMethod, cardBrand, dues, paymentType }

})
