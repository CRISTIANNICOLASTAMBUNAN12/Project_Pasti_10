@include('user.layouts.navbar')
<body>  
    <div class="container mt-4">
        <h1 class="text-center mb-4">Gallery</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($produk as $product)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product['name'] }}</h5>
           
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
@include('user.layouts.footer')
