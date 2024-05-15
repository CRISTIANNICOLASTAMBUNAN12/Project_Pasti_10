<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Categories;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{     
    protected $apiUrl;
    private $messages;
    private $client;

    public function __construct()
    {
        // Tentukan URL API Go CRUD
        $this->apiUrl = 'http://localhost:9000/api/category'; // Ganti dengan URL API Go Anda
        
        // Initialize $this->messages with an array of validation messages
        $this->messages = [
            'required' => 'The :attribute field is required.',
            'image' => 'The :attribute must be an image.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max' => 'The :attribute may not be greater than :max kilobytes.',
        ];

        // Initialize the Guzzle client
        $this->client = new Client();
    }

    public function AllCat()
    {
        $response = $this->client->get($this->apiUrl.'/');
        $categoriesData = json_decode($response->getBody(), true);

        // Pastikan response adalah array
        if (!is_array($categoriesData)) {
            // Handle kesalahan response
            return redirect()->back()->with('error', 'Error fetching categories');
        }

        // Buat objek LengthAwarePaginator dari data produk
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $categories = new LengthAwarePaginator(
            array_slice($categoriesData, ($currentPage - 1) * $perPage, $perPage),
            count($categoriesData),
            $perPage,
            $currentPage
        );

        return view('admin.categories.category', compact('categories'));
    }

    public function AddCat()
    {
        return view('admin.Categories.addcategory');
    }
    public function InsertCat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required', 
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
            'image' => $image_name,
        ];
        try {
            $this->client->request('POST', $this->apiUrl, [
                'multipart' => [
                    [
                        'name' => 'name',
                        'contents' => $request->name,
                    ],
                    [
                        'name' => 'image',
                        'contents' =>'http://localhost:8000/images/products/' . time() . '.' . $image->getClientOriginalExtension(),
                    ],
                ]
            ]);
        
            // Return redirect response
            return redirect()->route('admin.category')->with('status', 'Category created successfully');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }   
    }
    
    

     public function editCat($id)
    {
        try {
            // Kirim permintaan GET ke API untuk mendapatkan data kategori berdasarkan ID
            $response = $this->client->get($this->apiUrl.'/'.$id);
     
            $category = json_decode($response->getBody(), true);
    
            // Pastikan response adalah array
            if (!is_array($category)) {
                // Handle kesalahan response
                return redirect()->back()->with('error', 'Error fetching category data');
            }
    
            // Tampilkan view formulir pengeditan kategori dengan data yang diperoleh
            return view('admin.Categories.editcategory', compact('category'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function UpdateCat(Request $request, $id)
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
                        'name' => 'image',
                        'contents' => $image_name,
                    ],
                ]
            ]);
        
            // Return redirect response
            return redirect()->route('admin.category')->with('status', 'Category updated successfully');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }   
    }
    public function destroyCat($id)
{
    try {
        // Kirim permintaan DELETE ke API untuk menghapus kategori berdasarkan ID
        $response = $this->client->delete($this->apiUrl.'/'.$id);

        // Pastikan penghapusan berhasil
        if ($response->getStatusCode() == 204) {
            // Redirect dengan pesan sukses
            return redirect()->route('admin.category')->with('status', 'Category deleted successfully');
        } else {
            // Handle kesalahan penghapusan
            return redirect()->back()->with('error', 'Error deleting category');
        }
    } catch (\Exception $e) {
       
        return redirect()->back()->with('error', $e->getMessage());
    }
}


} 
          