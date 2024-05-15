<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{


    public function __construct()
    {
        $this->client = new Client(); // Initialize GuzzleHttp\Client
    }
    
    public function index()
    {   
        try {
            $client = new Client();
            
            // Mengambil data produk
            $produkResponse = $client->get("http://localhost:8999/api/products");
            $produk = json_decode($produkResponse->getBody(), true);
            
            // Pastikan response adalah array
            if (!is_array($produk)) {
                $produk = [];
            }
    
        } catch (\Exception $e) {
            // Penanganan kesalahan jika gagal mengambil data produk
            // Anda dapat menentukan tindakan khusus atau memberikan pesan kesalahan di sini
            if ($e->getCode() === 404) {
                // Contoh: Kode 404 menunjukkan bahwa sumber daya tidak ditemukan
                // Tindakan khusus atau pesan kesalahan dapat ditentukan di sini
            }
    
            // Mengatur data produk yang gagal diambil menjadi array kosong
            $produk = [];
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
            // Penanganan kesalahan jika gagal mengambil data kategori
            // Anda dapat menentukan tindakan khusus atau memberikan pesan kesalahan di sini
            if ($e->getCode() === 404) {
                // Contoh: Kode 404 menunjukkan bahwa sumber daya tidak ditemukan
                // Tindakan khusus atau pesan kesalahan dapat ditentukan di sini
            }
    
            // Mengatur data kategori yang gagal diambil menjadi array kosong
            $categories = [];
        }
    
        // Dapatkan data slider tanpa bergantung pada API
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
    
    
        // Mengembalikan tampilan dengan data yang berhasil diambil
        return view('user.home', ['sliders' => $sliders, 'categories' => $categories, 'produk' => $produk]);
    }
    public function galeri()
    {   
        try {
            $client = new Client();
            
            // Mengambil data produk
            $produkResponse = $client->get("http://localhost:8710/api/galeris");
            $produk = json_decode($produkResponse->getBody(), true);
            
            // Pastikan response adalah array
            if (!is_array($produk)) {
                $produk = [];
            }
    
        } catch (\Exception $e) {
            // Penanganan kesalahan jika gagal mengambil data produk
            // Anda dapat menentukan tindakan khusus atau memberikan pesan kesalahan di sini
            if ($e->getCode() === 404) {
                // Contoh: Kode 404 menunjukkan bahwa sumber daya tidak ditemukan
                // Tindakan khusus atau pesan kesalahan dapat ditentukan di sini
            }
    
            // Mengatur data produk yang gagal diambil menjadi array kosong
            $produk = [];
        }
    
      
        return view('user.galeri', ['produk' => $produk]);
    }
    
    
    public function detail($id)
    {
        // Mendapatkan detail produk dari API
        $client = new Client();
        $response = $client->get("http://localhost:8999/api/products/{$id}");
        $product = json_decode($response->getBody(), true);
    
        // Pastikan produk berhasil diambil dari API
        if (!$product) {
            // Handle kesalahan ketika produk tidak ditemukan
            return redirect()->back()->with('error', 'Product not found');
        }
    
        // Mendapatkan produk terkait dari API berdasarkan kategori produk yang sedang dilihat
        $relatedResponse = $client->get("http://localhost:8999/api/products/{$product['category_id']}/related");
        $relatedProducts = json_decode($relatedResponse->getBody(), true);
    
        // Memastikan produk terkait berhasil diambil dari API
        if (!is_array($relatedProducts)) {
            // Handle kesalahan ketika produk terkait tidak ditemukan
            return redirect()->back()->with('error', 'Related products not found');
        }
    
        // Hapus produk yang sedang dilihat dari daftar produk terkait (jika ada)
        $relatedProducts = array_filter($relatedProducts, function ($relatedProduct) use ($id) {
            return $relatedProduct['ID'] != $id;
        });
    
        return view('user.Produk.detail', compact('product', 'relatedProducts'));
    }
    
public function keranjang(){
    return view('user.keranjang.keranjang');
}

    public function adminHome(){
        $sliders = Slider::where('status','1')->get();
        return view('admin.dashboard', ['sliders' => $sliders]);
    }
    public function produkHome(){
        return view('admin.produk.produk');
    }
    public function adminProduk(){
        return view('admin.Produk.produk');
    }
    public function pekerjaHome(){
        return view('PekerjaHome');
    }
}
