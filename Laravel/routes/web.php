<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Models\Slider;
use App\Models\Categories;
use App\Models\Products;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $client = new Client(); // Membuat instance baru dari Guzzle client

    // Mengatur nilai default untuk produk, kategori, dan slider
    $produk = [];
    $categories = [];
    $sliders = [];

    try {
        // Mengambil data produk
        $response = $client->get("http://localhost:8999/api/products");
        $produk = json_decode($response->getBody(), true);

        // Pastikan response adalah array
        if (!is_array($produk)) {
            $produk = [];
        }
    } catch (\Exception $e) {
        // Jika terjadi kesalahan, $produk tetap sebagai array kosong
    }

    try {
        // Mengambil data kategori
        $categoryResponse = $client->get("http://localhost:9000/api/category");
        $categories = json_decode($categoryResponse->getBody(), true);

        // Pastikan response adalah array
        if (!is_array($categories)) {
            $categories = [];
        }
    } catch (\Exception $e) {
        // Jika terjadi kesalahan, $categories tetap sebagai array kosong
    }

    // Mengambil data slider dari database
    try {
        $response = $client->get("http://localhost:8700/api/sliders");
        $sliders = json_decode($response->getBody(), true);

        // Pastikan response adalah array
        if (is_array($sliders)) {
            // Filter sliders dengan status '1'
            $sliders = array_filter($sliders, function ($slider) {
                return isset($slider['Status']) && $slider['Status'] == '1';
            });
        } else {
            $sliders = [];
        }
    } catch (\Exception $e) {
        // Jika terjadi kesalahan, $sliders tetap sebagai array kosong
    }

    // Mengembalikan tampilan dengan data yang berhasil diambil atau data kosong
    return view('user.home', [
        'sliders' => $sliders,
        'categories' => $categories,
        'produk' => $produk
    ]);
});


Auth::routes(['verify'=>true]);

Route::get('/home', [PageController::class, 'index'])->name('home')->middleware(['auth:web', 'verified']); 
Route::get('/product/{id}', [PageController::class, 'detail'])->name('detail'); 
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri'); 
Route::get('/keranjang', [CartController::class, 'index'])->name('keranjangs')->middleware(['auth:web', 'verified']); 
Route::delete('/delete/keranjang/{id}', [CartController::class, 'removeFromCart'])->name('deletecart')->middleware(['auth:web', 'verified']); 
Route::post('/add/keranjang', [CartController::class, 'addtocart'])->name('keranjang')->middleware(['auth:web', 'verified']); 
Route::post('/add/keranjang/direct', [CartController::class, 'addtocarts'])->name('keranjangdirect')->middleware(['auth:web', 'verified']); 

Route::get('checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware(['auth:web', 'verified']); 

Route::get('/orders', [OrdersController::class, 'index'])->name('orders')->middleware(['auth:web', 'verified']); 
Route::post('/ordersad', [OrdersController::class, 'order'])->name('orders.check')->middleware(['auth:web', 'verified']); 

Route::get('/add-profile-photo', [ProfileController::class, 'addProfilePhoto'])->name('add-profile-photo');
Route::post('/store-profile-photo', [ProfileController::class, 'storeProfilePhoto'])->name('store-profile-photo');



Route::get('/admin/home', [PageController::class, 'adminHome'])->name('admin.home')->middleware('auth:admin');

Route::get('/admin/produk', [PageController::class, 'adminProduk'])->name('admin.produk')->middleware('auth:admin');

Route::get('/admin/slider', [SliderController::class, 'index'])->name('admin.slider')->middleware('auth:admin');
Route::get('/admin/slider/add', [SliderController::class, 'create'])->name('admin.addslider')->middleware('auth:admin');
Route::post('/admin/slider/store', [SliderController::class, 'store'])->name('admin.storeslider')->middleware('auth:admin');
Route::get('/admin/slider/{id}/edit', [SliderController::class, 'edit'])->name('admin.editslider')->middleware('auth:admin');
Route::put('/admin/slider/{id}', [SliderController::class, 'update'])->name('admin.sliderupdate')->middleware('auth:admin');
Route::delete('/admin/slider/{id}/delete', [SliderController::class, 'destroy'])->name('admin.sliderdestroy')->middleware('auth:admin');

Route::get('/admin/galeri', [GaleriController::class, 'index'])->name('admin.galeri')->middleware('auth:admin');
Route::get('/admin/galeri/add', [GaleriController::class, 'create'])->name('admin.addgaleri')->middleware('auth:admin');
Route::post('/admin/galeri/store', [GaleriController::class, 'store'])->name('admin.storegaleri')->middleware('auth:admin');
Route::get('/admin/galeri/{id}/edit', [GaleriController::class, 'edit'])->name('admin.editgaleri')->middleware('auth:admin');
Route::put('/admin/galeri/{id}', [GaleriController::class, 'update'])->name('admin.galeriupdate')->middleware('auth:admin');
Route::delete('/admin/galeri/{id}/delete', [GaleriController::class, 'destroy'])->name('admin.galeridestroy')->middleware('auth:admin');

Route::get('/admin/category', [CategoriesController::class, 'AllCat'])->name('admin.category')->middleware('auth:admin');
Route::get('/admin/category/add', [CategoriesController::class, 'AddCat'])->name('admin.addcategory')->middleware('auth:admin');
Route::post('/admin/category/store', [CategoriesController::class, 'InsertCat'])->name('admin.storecategory')->middleware('auth:admin');
Route::get('/admin/category/{id}/edit', [CategoriesController::class, 'editCat'])->name('admin.editcategory')->middleware('auth:admin');
Route::put('/admin/category/{id}', [CategoriesController::class, 'updateCat'])->name('admin.categoryupdate')->middleware('auth:admin');
Route::delete('/admin/category/{id}', [CategoriesController::class, 'destroyCat'])->name('admin.categorydestroy')->middleware('auth:admin');

Route::get('/admin/products', [ProdukController::class, 'index'])->name('products.index')->middleware('auth:admin');
Route::get('/admin/products/{id}',  [ProdukController::class, 'show'])->name('products.show')->middleware('auth:admin');
Route::get('/admins/products/create', [ProdukController::class, 'create'])->name('products.create')->middleware('auth:admin');
Route::post('/admin/products/store', [ProdukController::class, 'store'])->name('products.store')->middleware('auth:admin');
Route::get('/admin/products/{id}/edit', [ProdukController::class, 'edit'])->name('products.edit')->middleware('auth:admin');
Route::put('/admin/products/{id}', [ProdukController::class, 'update'])->name('products.update')->middleware('auth:admin');
Route::delete('/admin/products/{id}', [ProdukController::class, 'destroy'])->name('products.destroy')->middleware('auth:admin');
Route::get('/products/search', [ProdukController::class, 'searchProduct'])->middleware('auth:admin');






