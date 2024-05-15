<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProdukController extends Controller
{
    protected $apiUrl;
    private $messages;
    private $client;

    public function __construct()
    {
        // Tentukan URL API Go CRUD
        $this->apiUrl = 'http://localhost:8999/api/products'; // Ganti dengan URL API Go Anda
        $this->messages = [
            'required' => 'The :attribute field is required.',
            'image' => 'The :attribute must be an image.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max' => 'The :attribute may not be greater than :max kilobytes.',
        ];
    
        $this->client = new Client(); // Initialize GuzzleHttp\Client
    }
    
    public function index()
    {
        $client = new Client();
        $response = $this->client->get($this->apiUrl.'/');
     
        $productsData = json_decode($response->getBody(), true);

        // Pastikan response adalah array
      


        // Pastikan response adalah array
        if ( !is_array($productsData)) {
            // Handle kesalahan response
            return redirect()->back()->with('error', 'Error fetching data');
        }
    
        // Buat objek LengthAwarePaginator dari data produk
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $products = new LengthAwarePaginator(
            array_slice($productsData, ($currentPage - 1) * $perPage, $perPage),
            count($productsData),
            $perPage,
            $currentPage
        );
    
        return view('admin.Produk.produk', compact('products'));
    }
    
    public function show($id)
    {
        $product = Products::findOrFail($id);
        return view('admin.Produk.produk', compact('products'));
    }
    
    public function create(){
        try {
 
            
     
            $categoryResponse = $this->client->get("http://localhost:9000/api/category");

            $categories = json_decode($categoryResponse->getBody(), true);
    
            if (!is_array($categories)) {
         
                return redirect()->back()->with('error', 'Error fetching data');
            }
           
            return view('admin.Produk.addproduk', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'weight_unit' => 'required|in:kilogram,gram,liter,milli,meter', 
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $this->messages);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
    
        // move image to public folder
        $image = $request->file('image');
        $image_name = 'http://localhost:8000/images/products/' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $image_name);
    
        // Prepare the data to be sent to the API
        $requestData = [
            'name' => $request->name,
            'stock' => $request->stock,
            'image' => $image_name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'weight_unit' => $request->weight_unit,
        ];
    
        try {
            $categoryResponse = $this->client->get("http://localhost:9000/api/category");
            $categories = json_decode($categoryResponse->getBody(), true);
    
            // Find category name by category_id
            $category_name = null;
            foreach ($categories as $category) {
                if ($category['ID'] == $request->category_id) {
                    $category_name = $category['name'];
                    break;
                }
            }
    
            if (!$category_name) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Category not found'
                ]);
            }
    
            $multipartData = [
                [
                    'name' => 'name',
                    'contents' => $request->name,
                ],
                [
                    'name' => 'stock',
                    'contents' => $request->stock,
                ],
                [
                    'name' => 'description',
                    'contents' => $request->description,
                ],
                [
                    'name' => 'price',
                    'contents' => $request->price,
                ],
                [
                    'name' => 'category_id',
                    'contents' => $request->category_id, 
                ],
                [
                    'name' => 'category_name',
                    'contents' => $category_name, 
                ],
                [
                    'name' => 'weight_unit',
                    'contents' => $request->weight_unit,
                ],
                [
                    'name' => 'image',
                    'contents' => $image_name,
                ],
            ];
    
            // Log the multipart data
            Log::info('Multipart Data:', $multipartData);
    
            $this->client->request('POST', $this->apiUrl, [
                'multipart' => $multipartData
            ]);
    
            // Return redirect response
            return redirect()->route('products.index')->with('status', 'Product created successfully');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function edit($id)
    {
        try {
            // Kirim permintaan GET ke API untuk mendapatkan data kategori berdasarkan ID
            $response = $this->client->get($this->apiUrl.'/'.$id);
     
            $product = json_decode($response->getBody(), true);
    
            // Pastikan response adalah array
            $categoryResponse = $this->client->get("http://localhost:9000/api/category");

            $categories = json_decode($categoryResponse->getBody(), true);
    
            // Pastikan response adalah array
            if (!is_array($categories) || !is_array($product)) {
                // Handle kesalahan response
                return redirect()->back()->with('error', 'Error fetching data');
            }
            // Tampilkan view formulir pengeditan kategori dengan data yang diperoleh
            return view('admin.Produk.editproduk', compact('product','categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ], $this->messages);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
    
        // Jika ada file gambar yang diunggah, lakukan pemrosesan gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = 'http://localhost:8000/images/products/' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $image_name);
        } else {
            // Jika tidak ada file gambar yang diunggah baru, gunakan gambar yang sudah ada
            $image_name = $request->input('existing_image');
        }
    
        // Prepare the data to be sent to the API
        $requestData = [
            'id' => $id, // Sertakan ID kategori dalam permintaan
            'name' => $request->name,
            'image' => $image_name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'weight_unit' => $request->weight_unit,
            'stock' => $request->stock,
        ];
    
        try {
            $this->client->request('PUT', $this->apiUrl . '/' . $id, [
                'multipart' => [
                    [
                        'name' => 'id', // Nama field untuk ID kategori
                        'contents' => $id, // Isi ID kategori
                    ],
                    [
                        'name' => 'name',
                        'contents' => $request->name,
                    ],
                    [
                        'name' => 'stock',
                        'contents' => $request->stock,
                    ],
                    [
                        'name' => 'description',
                        'contents' => $request->description,
                    ],
                    [
                        'name' => 'price',
                        'contents' => $request->price,
                    ],
                    [
                        'name' => 'category_id',
                        'contents' => $request->category_id,
                    ],
                    [
                        'name' => 'weight_unit',
                        'contents' => $request->weight_unit,
                    ],
                    [
                        'name' => 'image',
                        'contents' => $image_name,
                    ],
                ]
            ]);
        
            // Return redirect response
            return redirect()->route('products.index')->with('status', 'Category updated successfully');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }   
    }
public function destroy($id)
{
    try {
        // Kirim permintaan DELETE ke API untuk menghapus kategori berdasarkan ID
        $response = $this->client->delete($this->apiUrl.'/'.$id);

        // Pastikan penghapusan berhasil
        if ($response->getStatusCode() == 204) {
            // Redirect dengan pesan sukses
            return redirect()->route('products.index')->with('status', 'Product deleted successfully');
        } else {
            // Handle kesalahan penghapusan
            return redirect()->back()->with('error', 'Error deleting product');
        }
    } catch (\Exception $e) {
       
        return redirect()->back()->with('error', $e->getMessage());
    }
}
public function searchProduct(Request $request)
{
if($request->has('search')){
    $products = Products::where('name','Like','%'.$request->search.'%')->paginate(5);
}
else{
    Products::latest()->paginate(5);
}
return view('admin.Produk.produk', compact('products'));
}
}