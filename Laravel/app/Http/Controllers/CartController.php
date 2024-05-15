<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function __construct()
    {
        // Tentukan URL API Go CRUD
        $this->apiUrl = 'http://localhost:8082/api/carts'; // Ganti dengan URL API Go Anda
        
       
        $this->client = new Client();
    }
    public function index()
{
    try {
        // Panggil API untuk mengambil data keranjang untuk user yang sedang login
        $response = $this->client->get($this->apiUrl, [
            'query' => [
                'user_id' => auth()->id()
            ]
        ]);

        $cartItems = json_decode($response->getBody()->getContents(), true);

      
        return view('user.keranjang.keranjang', compact('cartItems'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal mengambil data keranjang: ' . $e->getMessage());
    }
}
public function removeFromCart($id)
{
    try {
        $userId = auth()->id();
        // Kirim permintaan DELETE ke API untuk menghapus item keranjang berdasarkan ID dan user_id
        $response = $this->client->delete($this->apiUrl . '/' . $id, [
            'query' => [
                'user_id' => $userId
            ]
        ]);

        // Pastikan penghapusan berhasil
        if ($response->getStatusCode() == 204) {
            return redirect()->route('keranjangs')->with('status', 'Produk berhasil dihapus dari keranjang.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus produk dari keranjang.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus produk dari keranjang: ' . $e->getMessage());
    }
}
public function addtocart(Request $request)
{
    $validator = Validator::make($request->all(), [
        'quantity' => 'required|integer|min:1', 
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Panggil API untuk mendapatkan keranjang pengguna
    $cartResponse = $this->client->get($this->apiUrl, [
        'query' => [
            'user_id' => auth()->id()
        ]
    ]);
    $cart = json_decode($cartResponse->getBody(), true);

    // Cek apakah produk sudah ada di keranjang
    $existingProduct = null;
    foreach ($cart as $item) {
        if ($item['ProductID'] == $request->product_id) {
            $existingProduct = $item;
            break;
        }
    }
    
    // Jika produk sudah ada di keranjang, tambahkan kuantitasnya
    if ($existingProduct) {
        $newQuantity = $existingProduct['Quantity'] + $request->quantity;
        try {
            $this->client->request('PUT', $this->apiUrl . '/' . $existingProduct['ID'], [
                'multipart' => [
                    [
                        'name' => 'product_id',
                        'contents' => $request->product_id,
                    ],
                    [
                        'name' => 'user_id',
                        'contents' => Auth::id(),
                    ],
                    [
                        'name' => 'product_name',
                        'contents' => $request->product_name,
                    ],
                    [
                        'name' => 'price',
                        'contents' => $request->price,
                    ],
                    [
                        'name' => 'weight_unit',
                        'contents' => $request->weight_unit,
                    ],
                    [
                        'name' => 'product_image',
                        'contents' => $request->product_image,
                    ],
                     [
                        'name' => 'product_id',
                        'contents' => $request->product_id,
                    ],
                    [
                        'name' => 'quantity',
                        'contents' =>$newQuantity ,
                    ],
                ]
            ]);
    
            return redirect()->route('keranjangs')->with('success', 'Item berhasil ditambahkan ke keranjang');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui kuantitas item di keranjang: ' . $e->getMessage());
        }
    } else {
        // Jika produk belum ada di keranjang, tambahkan produk baru ke keranjang
        try {
            $this->client->request('POST', $this->apiUrl, [
                'multipart' => [
                    [
                        'name' => 'product_id',
                        'contents' => $request->product_id,
                    ],
                    [
                        'name' => 'user_id',
                        'contents' => Auth::id(),
                    ],
                    [
                        'name' => 'product_name',
                        'contents' => $request->product_name,
                    ],
                    [
                        'name' => 'price',
                        'contents' => $request->price,
                    ],
                    [
                        'name' => 'weight_unit',
                        'contents' => $request->weight_unit,
                    ],
                    [
                        'name' => 'product_image',
                        'contents' => $request->product_image,
                    ],
                     [
                        'name' => 'product_id',
                        'contents' => $request->product_id,
                    ],
                    [
                        'name' => 'quantity',
                        'contents' =>$request->quantity,
                    ],
                ]

            ]);
    
            return redirect()->route('keranjangs')->with('success', 'Item berhasil ditambahkan ke keranjang');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan item ke keranjang: ' . $e->getMessage());
        }
    }
}

   
public function addtocarts(Request $request)
{
    $validator = Validator::make($request->all(), [
        'quantity' => 'required|integer|min:1', 
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Panggil API untuk mendapatkan keranjang pengguna
    $cartResponse = $this->client->get($this->apiUrl, [
        'query' => [
            'user_id' => auth()->id()
        ]
    ]);
    $cart = json_decode($cartResponse->getBody(), true);

    // Cek apakah produk sudah ada di keranjang
    $existingProduct = null;
    foreach ($cart as $item) {
        if ($item['ProductID'] == $request->product_id) {
            $existingProduct = $item;
            break;
        }
    }
    
    // Jika produk sudah ada di keranjang, tambahkan kuantitasnya
    if ($existingProduct) {
        $newQuantity = $existingProduct['Quantity'] + $request->quantity;
        try {
            $this->client->request('PUT', $this->apiUrl . '/' . $existingProduct['ID'], [
                'multipart' => [
                    [
                        'name' => 'product_id',
                        'contents' => $request->product_id,
                    ],
                    [
                        'name' => 'user_id',
                        'contents' => Auth::id(),
                    ],
                    [
                        'name' => 'product_name',
                        'contents' => $request->product_name,
                    ],
                    [
                        'name' => 'price',
                        'contents' => $request->price,
                    ],
                    [
                        'name' => 'weight_unit',
                        'contents' => $request->weight_unit,
                    ],
                    [
                        'name' => 'product_image',
                        'contents' => $request->product_image,
                    ],
                     [
                        'name' => 'product_id',
                        'contents' => $request->product_id,
                    ],
                    [
                        'name' => 'quantity',
                        'contents' =>$newQuantity ,
                    ],
                ]
            ]);
    
            return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui kuantitas item di keranjang: ' . $e->getMessage());
        }
    } else {
        // Jika produk belum ada di keranjang, tambahkan produk baru ke keranjang
        try {
            $this->client->request('POST', $this->apiUrl, [
                'multipart' => [
                    [
                        'name' => 'product_id',
                        'contents' => $request->product_id,
                    ],
                    [
                        'name' => 'user_id',
                        'contents' => Auth::id(),
                    ],
                    [
                        'name' => 'product_name',
                        'contents' => $request->product_name,
                    ],
                    [
                        'name' => 'price',
                        'contents' => $request->price,
                    ],
                    [
                        'name' => 'weight_unit',
                        'contents' => $request->weight_unit,
                    ],
                    [
                        'name' => 'product_image',
                        'contents' => $request->product_image,
                    ],
                     [
                        'name' => 'product_id',
                        'contents' => $request->product_id,
                    ],
                    [
                        'name' => 'quantity',
                        'contents' =>$request->quantity,
                    ],
                ]

            ]);
    
            return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang');


        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan item ke keranjang: ' . $e->getMessage());
        }
    }
}

   



   
}
