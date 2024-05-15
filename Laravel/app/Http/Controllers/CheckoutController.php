<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{


    protected $apiUrl;
    private $messages;
    private $client;

    public function __construct()
    {
        // Tentukan URL API Go CRUD
        $this->apiUrl = 'http://localhost:8083/api/orders'; // Ganti dengan URL API Go Anda
        $this->messages = [
            'required' => 'The :attribute field is required.',
            'image' => 'The :attribute must be an image.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max' => 'The :attribute may not be greater than :max kilobytes.',
        ];
    
        $this->client = new Client(); // Initialize GuzzleHttp\Client
    }

    public function store(Request $request){
try {
    $this->client->request('POST', 'localhost:8083/api/orders', [
        'json' => [
            'user_id' => auth()->user()->id,
            'total_price' => 1212,
            'status' => 'pending',
            'payment_status' => 1,
        ]
    ]);
} catch(\Exception $e){
    Log::error('Error occurred: ' . $e->getMessage());
    return redirect()->back()->with('error', $e->getMessage());
}
    }
       
}
