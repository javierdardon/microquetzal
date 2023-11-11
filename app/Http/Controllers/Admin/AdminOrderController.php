<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Models\Build;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Inertia\Inertia;

class AdminOrderController extends Controller
{
    public function index() {
        $paginateItems = 12;

        $orders = new OrderCollection(Order::paginate($paginateItems));
        $orders->withPath('');

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders
        ]);
    }

    public function edit( Order $order ) {
        return Inertia::render('Admin/Orders/Edit', [
            'order' => $order
        ]);
    }

    public function update( Request $request ) {
        $order = Order::find($request->id);

        if ( $order->status === 'Cancelado' || $order->status === 'Enviado' ) {
            return back()->with(['error' => 'No puede modificar un pedido cancelado o enviado']);
        }

        $invoiceName = null;

        if ( $request->invoice ) {
            $invoice = $request->invoice[0]["file"];
            $path = public_path('invoices/');
            !is_dir($path) && mkdir($path, 0777, true);

            $invoiceName = 'invoices/'.$request->id.'_'.time() . '.' . $invoice->extension();
            $invoice->move($path, $invoiceName);
        }

        $paymentName = null;

        if ( $request->payment ) {
            $payment = $request->payment[0]["file"];
            $path = public_path('payments/');
            !is_dir($path) && mkdir($path, 0777, true);

            $paymentName = 'payments/'.$request->id.'_'.time() . '.' . $payment->extension();
            $payment->move($path, $paymentName);

            $request->payment_date = date("d-m-y h:i:s");
            $request->status = 'Pagado';
        }

        if ( $request->guide ) {
            $request->shipping_date = date("d-m-y h:i:s");
        }

        if( $request->status === 'Enviado' ) {
            foreach( $order->products as $orderProduct ) {
                if ( $orderProduct['type'] === "product" ) {
                    $product = Product::find($orderProduct['id']);
                } else {
                    $product = Build::find($orderProduct['id']);
                }

                if ( $product->quantity < $orderProduct['quantity'] ) {
                    return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$product->name})"]);
                }

                $product->quantity = $product->quantity - $orderProduct['quantity'];
                $product->save();

                if ( $orderProduct['type'] === 'pc' ) {
                    if ( $product->cpu_id ) {
                        $cpu = Product::find($product->cpu_id);

                        if ( $cpu->quantity === 0 || $cpu->quantity < 0  ) {
                            return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$cpu->name})"]);
                        }

                        $cpu->quantity = $cpu->quantity - 1;
                        $cpu->save();
                    }

                    if ( $product->cooler_id ) {
                        $cooler = Product::find($product->cooler_id);

                        if ( $cooler->quantity === 0 || $cooler->quantity < 0 ) {
                            return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$cooler->name})"]);
                        }

                        $cooler->quantity = $cooler->quantity - 1;
                        $cooler->save();
                    }

                    if ( $product->ram_id ) {
                        $ram = Product::find($product->ram_id);

                        if ( $ram->quantity === 0 || $ram->quantity < 0 ) {
                            return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$ram->name})"]);
                        }

                        $ram->quantity = $ram->quantity - 1;
                        $ram->save();
                    }

                    if ( $product->gpu_id ) {
                        $gpu = Product::find($product->gpu_id);

                        if ( $gpu->quantity === 0 || $gpu->quantity < 0 ) {
                            return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$gpu->name})"]);
                        }

                        $gpu->quantity = $gpu->quantity - 1;
                        $gpu->save();
                    }

                    if ( $product->psu_id ) {
                        $psu = Product::find($product->psu_id);

                        if ( $psu->quantity === 0 || $psu->quantity < 0 ) {
                            return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$psu->name})"]);
                        }

                        $psu->quantity = $psu->quantity - 1;
                        $psu->save();
                    }

                    if ( $product->mobo_id ) {
                        $mobo = Product::find($product->mobo_id);

                        if ( $mobo->quantity === 0 || $mobo->quantity < 0 ) {
                            return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$mobo->name})"]);
                        }

                        $mobo->quantity = $mobo->quantity - 1;
                        $mobo->save();
                    }

                    if ( $product->case_id ) {
                        $case = Product::find($product->case_id);

                        if ( $case->quantity === 0 || $case->quantity < 0 ) {
                            return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$case->name})"]);
                        }

                        $case->quantity = $case->quantity - 1;
                        $case->save();
                    }

                    if ( $product->rom_id ) {
                        $rom = Product::find($product->rom_id);

                        if ( $rom->quantity === 0 || $rom->quantity < 0 ) {
                            return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$rom->name})"]);
                        }

                        $rom->quantity = $rom->quantity - 1;
                        $rom->save();
                    }

                    if ( $product->rom_multiple_id ) {
                        foreach( $product->rom_multiple_id as $buildRom ) {
                            $rom = Product::find($buildRom['id']);

                            if ( $rom->quantity === 0 || $rom->quantity < 0 ) {
                                return back()->with(['error' => "Lo sentimos, no hay suficiente disponibilidad de productos ({$rom->name})"]);
                            }

                            $rom->quantity = $rom->quantity - $buildRom['amount'];
                            $rom->save();
                        }
                    }
                }
            }
        }

        $order->update([
            'status' => $request->status,
            'guide' => $request->guide,
            'service' => $request->service,
            'invoice' => $invoiceName,
            'payment' => $paymentName,
            'payment_date' => $request->payment_date,
            'shipping_date' => $request->shipping_date,
        ]);

        return to_route('admin.orders.index')->with(['success' => 'Actualizado correctamente']);
    }

    public function view( Order $order ) {
        $order = Order::with('user')->find($order->id);

        return Inertia::render('Admin/Orders/View', [
            'order' => $order
        ]);
    }
}
