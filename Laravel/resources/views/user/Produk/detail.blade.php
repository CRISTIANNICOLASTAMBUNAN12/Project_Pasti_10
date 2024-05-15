@include('user.layouts.navbar')

<body>
    <div class="container py-5 shadow border an1">
        <div class="row">
            <div class="col-lg-6 border-end">
                <!-- Product Image -->
                <img src="{{ asset($product['image']) }}" class="img-fluid" alt="{{ $product['name'] }}">
            </div>
            <div class="col-lg-6 border-start">
                <!-- Product Details -->
                <h2 class="mb-4">{{ $product['name'] }}</h2>
                <p>Harga: Rp. {{ $product['price'] }}</p>
                <p>Stok: {{ $product['stock'] }} {{ $product['weight_unit'] }}</p>

                <form id="cartForm" method="POST">
                    @csrf <!-- Tambahkan csrf token untuk keamanan -->
                    <input type="hidden" name="product_id" value="{{ $product['ID'] }}">
                    <input type="hidden" name="product_name" value="{{ $product['name'] }}">
                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                    <input type="hidden" name="weight_unit" value="{{ $product['weight_unit'] }}">
                    <input type="hidden" name="product_image" value="{{ asset($product['image']) }}">
                    <div class="input-group mb-3">
                        <label for="quantityInput" class="form-label me-2">Jumlah:</label>
                        <input type="number" class="text-center uk" id="quantityInput" name="quantity" value="1" min="1">
                        <button class="btn btn-outline-success" type="button" id="subtractBtn">-</button>
                        <button class="btn btn-outline-success" type="button" id="addBtn">+</button> &nbsp;
                    </div>
                    @if(Auth::check())
                        <!-- Jika sudah login -->
                        <button class="btn btn-success" id="buyNowBtn">
                            <i class="fas fa-shopping-cart"></i> Beli Sekarang
                        </button>
                    @else
                        <!-- Jika belum login -->
                        <button class="btn btn-success">
                            <a href="{{ route('login') }}" style="text-decoration: none; color: white;">
                                <i class="fas fa-shopping-cart"></i> Beli Sekarang
                            </a>
                        </button>
                    @endif
                
                    @if(Auth::check())
                        <!-- Jika sudah login -->
                        <button class="btn btn-danger" id="addToCartBtn">
                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    @else
                        <!-- Jika belum login -->
                        <button class="btn btn-danger">
                            <a href="{{ route('login') }}" style="text-decoration: none; color: white;">
                                <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                            </a>
                        </button>
                    @endif
                </form>
            </div>
        </div>
        <p>{{ $product['description'] }}</p>
    </div>

    <!-- Produk Terkait -->
    <div class="container mt-5 p-3 mb-5 an1">
        <div class="card">
            <div class="card-header bg1">
                <h5 class="card-title text-center">Produk Terkait</h5>
            </div>
        </div>
        <div class="row row-cols-md-6 g-2 w-90">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col">
                    <a href="{{ route('detail', ['id' => $relatedProduct['ID']]) }}">
                        <div class="card shop">
                            <img src="{{ asset($relatedProduct['image']) }}" class="card-img-top related-product-image" alt="{{ $relatedProduct['name'] }}">
                        </a>
                        <div class="card-body">
                            <p class="card-text stext">{{ $relatedProduct['name'] }}</p>
                            <p class="card-text stext"><small>Rp. {{ $relatedProduct['price'] }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        .related-product-image {
            width: 100%;
            height: 200px; /* Atur tinggi gambar sesuai kebutuhan */
            object-fit: cover; /* Untuk memastikan gambar tetap proporsional */
        }
    </style>
</body>

<script>
    const quantityInput = document.getElementById('quantityInput');
    const addBtn = document.getElementById('addBtn');
    const subtractBtn = document.getElementById('subtractBtn');

    // Menambahkan event listener untuk tombol tambah
    addBtn.addEventListener('click', function() {
        quantityInput.stepUp();
    });

    // Menambahkan event listener untuk tombol kurang
    subtractBtn.addEventListener('click', function() {
        if (quantityInput.value > 1) {
            quantityInput.stepDown();
        }
    });
</script>   
<script>
    // Fungsi untuk mengubah tindakan formulir dan rute saat tombol ditekan
    document.getElementById('buyNowBtn').addEventListener('click', function() {
        document.getElementById('cartForm').action = "{{ route('keranjang', ['id' => $product['ID']]) }}";
        document.getElementById('cartForm').submit();
    });

    document.getElementById('addToCartBtn').addEventListener('click', function() {
        document.getElementById('cartForm').action = "{{ route('keranjangdirect', ['id' => $product['ID']]) }}";
        document.getElementById('cartForm').submit();
    });
</script>

@include('user.layouts.footer')
