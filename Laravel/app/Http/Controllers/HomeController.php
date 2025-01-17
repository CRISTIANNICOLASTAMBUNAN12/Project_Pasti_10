<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function adminHome(){
        return view('admin.dashboard');
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
