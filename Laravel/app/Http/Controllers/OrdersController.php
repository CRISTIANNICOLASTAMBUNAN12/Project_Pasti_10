<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class OrdersController extends Controller
{
   public function index(){
    return view('user.orders.orders');
   }

   public function order(Request $request){
    $request->request->add([
        'user_id' => 19,
        'product_id' => 3,
        'total_amount' => 100.00,
        'status' => 'pending',
        
    ]);
    $order= Orders::create($request->all());
    $order = Orders::create($request->all());

    \Midtrans\Config::$serverKey = config('midtrans.server_key');
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => 10000,
    ),
    'customer_details' => array(
        'first_name' => 'budi',
        'last_name' => 'pratama',
        'email' => 'budi.pra@example.com',
        'phone' => '08111222333',
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
return view('user.checkout.checkout', compact('snapToken', 'order'));
   }
}
