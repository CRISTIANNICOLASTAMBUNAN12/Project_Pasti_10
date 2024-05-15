@include('user.layouts.navbar')
<body>  
    <!-- Bagian Carousel Kecil -->
    <div class="container"> <!-- Carousel -->
        <center><div class="card" style="max-width: 700px; max-height: 300px;"> <!-- Menambahkan garis tepi berwarna hitam -->
            <div id="demo" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicators/dots -->
                <div class="carousel-indicators">
                    @foreach($sliders as $key => $slider)
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>
                
                <!-- The slideshow/carousel -->
                <div class="carousel-inner">
                    @foreach($sliders as $key => $slider)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{$slider['image'] }}" alt="{{ $slider['name'] }}" class="d-block w-100 h-auto" style="max-height: 300px; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
                
                <!-- Left and right controls/icons -->
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
        </center>

        <div style="height: 100px;"></div>
        <!-- Bagian Kategori -->
        <div class="container shadow p-3 mb-5">
            <h2>Kategori Produk</h2><br>
            <div class="row row-cols-5 g-2">
                @foreach($categories as $category)
                    <div class="col cardd ">
                        <div class="card text-center">
                            <div class="card-body">
                                <img src="{{ asset($category['image']) }}" alt="" class="category-image">
                                <div class="p-2">{{ $category['name'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Produk Terbaru -->
        <div class="container mt-5 shadow p-3 mb-5">
            <div class="row row-cols-1 row-cols-md-5 g-3 w-90">
                @foreach($produk as $product)
                <div class="col">
                    <a href="{{ route('detail', ['id' => $product['ID']]) }}">
                        <div class="card shop">
                            <img src="{{ asset($product['image']) }}" class="card-img-top product-image" alt="...">
                        </div>
                    </a>  
                    <div class="card-body">
                        <p class="card-text"><b>{{ $product['name'] }}</b></p>
                        <p class="card-text"><small>Rp. {{ $product['price']}}</small></p>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
    <style>
        /* CSS untuk mengatur ukuran gambar kategori */
        .category-image {
            width: 50px; /* Sesuaikan dengan lebar yang Anda inginkan */
            height: 50px; /* Sesuaikan dengan tinggi yang Anda inginkan */
            object-fit: cover;
        }
        .product-image {
        width: 100%;
        height: 200px; /* Atur tinggi gambar sesuai kebutuhan */
        object-fit: cover; /* Untuk memastikan gambar tetap proporsional */
    }
    </style>
</body>
@include('user.layouts.footer')
