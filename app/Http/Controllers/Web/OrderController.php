<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Build;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    public function store(Request $request)//: RedirectResponse
    {
        // Data validate
        $request->validate([
            'products' => 'required|array',
            'paymentMethod' => 'required',
            'paymentType' => 'required',
            'shipping_data' => 'required',
            'shipping' => 'required'
        ]);

        if ( $request->paymentMethod === 'card' ) {
            if ( $request->cardBrand === null ) {
                return back()->with(['error' => 'Se ha producido un error al crear el pedido']);
            }
        }

        if ( $request->paymentType === 'DUES' ) {
            if ( $request->dues === null ) {
                return back()->with(['error' => 'Se ha producido un error al crear el pedido']);
            }
        }

        if ( $request->shipping_data ) {
            $user = User::find(Auth::id());
            $user->update($request->shipping_data);
        }

        //Save Order Products & Order Total
        $products = collect([]);
        $total = 0;
        $quantity = 0;

        foreach( $request->products as $orderProduct ) {

            if ( $orderProduct['type'] === "product" ) {
                $product = Product::find($orderProduct['id']);
            } else {
                $product = Build::find($orderProduct['id']);
            }

            if ( $product->sale ) {
                $price = $request->paymentMethod == 'cash' ? $product->sale_price : $product->sale_normal_price;
            } else {
                $price = $request->paymentMethod == 'cash' ? $product->price : $product->normal_price;
            }

            $products->push([
                'id' => $product->id,
                'price' => $price,
                'sale_product' => $product->sale,
                'percentage' => $product->percentage,
                'quantity' => $orderProduct['quantity'],
                'image' => $product->images,
                'name' => $product->name,
                'type' => $orderProduct['type']
            ]);

            $quantityTotalPrice = $price;

            if ( $orderProduct['quantity'] > 1 ) {
                $quantityTotalPrice = number_format((float)($price * $orderProduct['quantity']), 2, ".", '');
            }


            $total += $quantityTotalPrice;
            $quantity += $orderProduct['quantity'];
        }

        $duesInterest = [
            '3' => number_format((((float)($total * 0.01) + $total) / 3), 2, ".", ''),
            '6' => number_format((((float)($total * 0.02) + $total) / 6), 2, ".", ''),
            '10' => number_format((((float)($total * 0.03) + $total) / 10), 2, ".", ''),
            '12' => number_format((((float)($total * 0.09) + $total) / 12), 2, ".", ''),
            '15' => number_format((((float)($total * 0.05) + $total) / 15), 2, ".", ''),
            '18' => number_format((((float)($total * 0.07) + $total) / 18), 2, ".", '')
        ];

        $card = $request->paymentMethod === 'card' ? $request->cardBrand : null;
        $dues = $request->paymentMethod === 'card' && $request->paymentType === 'DUES' ? $request->dues : null;
        $duesQuantity = $dues ? $duesInterest["{$dues}"] : null;
        $shipping = 0;


        if ( $request->shipping === 'cashShipping' ) {
            $shipping = number_format(($total * 0.045), 2);
            $total += $shipping;
        }

        try {
            // Init DB Transaction for more security
            DB::transaction(function() use ( $request, $products, $total, $quantity, $card, $dues, $duesQuantity, $shipping ) {
                //Creating Order
                Order::create([
                    'user_id' => Auth::id(),
                    'products' => $products->toArray(),
                    'total' => $total,
                    'quantity' => $quantity,
                    'phone' => $request->shipping_data['phone'],
                    'second_phone' => $request->shipping_data['second_phone'],
                    'email' => Auth::user()->email,
                    'nit' => $request->shipping_data['nit'],
                    'department' => $request->shipping_data['department'],
                    'municipality' => $request->shipping_data['municipality'],
                    'address' => $request->shipping_data['address'],
                    'reference' => $request->shipping_data['reference'],
                    'paymentMethod' => $request->paymentMethod,
                    'card' => $card,
                    'dues' => $dues,
                    'duesQuantity' => $duesQuantity,
                    'paymentType' => $request->paymentType,
                    'shipping' => $request->shipping,
                    'total_shipping' => $shipping
                ]);
            });
        } catch (Throwable $e) {
            return $e;
            return back()->with(['error' => 'Se ha producido un error al crear el pedido']);
        }

        return to_route('web.auth.user.orders')->with(['success' => 'Se ha creado el pedido exitosamente']);
    }
}
