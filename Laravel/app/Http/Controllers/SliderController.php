<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class SliderController extends Controller
{
    protected $apiUrl;
    private $messages;
    private $client;

    public function __construct()
    {
        // Tentukan URL API Go CRUD
        $this->apiUrl = 'http://localhost:8700/api/sliders'; // Ganti dengan URL API Go Anda
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
     
        $sliders = json_decode($response->getBody(), true);

        // Pastikan response adalah array
      


        // Pastikan response adalah array
        if ( !is_array($sliders)) {
            // Handle kesalahan response
            return redirect()->back()->with('error', 'Error fetching data');
        }
    
    
        return view('admin.slider.slider', compact('sliders'));
    }
    public function create()
    {
        return view('admin.slider.addslider');
    }    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ], $this->messages);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
    
        // move image to public folder
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $image_name);
    
        // Prepare the data to be sent to the API
        $requestData = [
            'name' => $request->name,
            'image' => $image_name,
            'status' => $request->status,
        ];
    
        try {
            $this->client->request('POST', $this->apiUrl, [
                'multipart' => [
                    [
                        'name' => 'name',
                        'contents' => $request->name,
                    ],
                    [
                        'name' => 'status',
                        'contents' => $request->status,
                    ],
                    [
                        'name' => 'image',
                        'contents' =>'http://localhost:8000/images/products/' . time() . '.' . $image->getClientOriginalExtension(),
                    ],
                ],
            ]);
    
            // Return redirect response
            return redirect()->route('admin.slider')->with('status', 'Category created successfully');
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
     
            $sliders = json_decode($response->getBody(), true);
    
            // Pastikan response adalah array
            if (!is_array($sliders)) {
                // Handle kesalahan response
                return redirect()->back()->with('error', 'Error fetching category data');
            }
    
            // Tampilkan view formulir pengeditan kategori dengan data yang diperoleh
            return view('admin.slider.editslider', compact('sliders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ], $this->messages);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
    
        // Handle the image file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = 'images/products/' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $image_name);
        } else {
            // Use the existing image if no new image is uploaded
            $image_name = $request->input('existing_image');
        }
    
        // Prepare the data to be sent to the API
        $requestData = [
            'id' => $id,
            'name' => $request->name,
            'image' => $image_name,
            'status' => $request->status,
        ];
    
        try {
            $this->client->request('PUT', $this->apiUrl . '/' . $id, [
                'multipart' => [
                    [
                        'name' => 'id',
                        'contents' => $id,
                    ],
                    [
                        'name' => 'name',
                        'contents' => $request->name,
                    ],
                    [
                        'name' => 'status',
                        'contents' => $request->status,
                    ],
                    [
                        'name' => 'image',
                        'contents' => $image_name,
                    ],
                ]
            ]);
    
            // Return redirect response
            return redirect()->route('admin.slider')->with('status', 'Category updated successfully');
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
