<!-- resources/views/keranjang/index.blade.php -->

@include('user.layouts.navbar')

<body>
    <!-- Bagian Konten Keranjang Belanja -->
    <div class="container-fluid py-5 an1">
        <h2 class="text-center mb-5">Keranjang Belanja</h2>
        <div class="row">
            <div class="col-md-8 mx-auto">
                @foreach ($cartItems as $cartItem)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-1">
                                            <input type="checkbox" class="form-check-input product-checkbox">
                                        </div>
                                        <div class="col-md-2">
                                            <img src="{{ asset($cartItem['ProductImage']) }}" class="card-img-top">
                                        </div>
                                        <div class="col-md-3 border-end">
                                            <h5 class="card-title">{{ $cartItem['ProductName'] }}</h5>
                                        </div>
                                        <div class="col-md-2">
                                            @php
                                                // Dapatkan jumlah stok produk yang tersedia
                                                $maxQuantity = 1; // Misalnya, anggap stock produk tersedia di $category['stock']
                                            @endphp
                                            <input type="number" class="form-control uk" value="{{ $cartItem['Quantity'] }}" min="0" max="{{ $maxQuantity }}" onchange="checkQuantity(this, {{ $maxQuantity }})">
                                            <div class="text-danger" id="quantity-error-message"></div> <!-- Tambahkan elemen untuk menampilkan pesan kesalahan -->
                                        </div>                                                                         
                                        <div class="col-md-2">
                                            <p>Rp. {{ $cartItem['Price'] }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            
                                            <a href="{{ route('deletecart', $cartItem['ID']) }}" class="btn btn-warning btn-delete" data-id="{{ $cartItem['ID'] }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            
                                            <!-- The form for deleting the cart item -->
                                            <form id="delete-form-{{ $cartItem['ID'] }}" action="{{ route('deletecart', $cartItem['ID']) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                @endforeach
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <!-- Hitung total harga produk yang dipilih -->
                            @php
                            $totalPrice = 0;
                            foreach ($cartItems as $cartItem) {
                                // Check if $cartItem is an array and has 'product' key
                                if (is_array($cartItem) && array_key_exists('product', $cartItem)) {
                                    $totalPrice += $cartItem['product']->price * $cartItem['quantity'];
                                }
                            }
                        @endphp
                        
                            <h4 id="selected-total">Total Rp. {{ $totalPrice }}</h4>
                        </div>
                        <div class="col-md-2 mx-auto">
                            <!-- Ubah tautan 'Checkout' agar mengarah ke fungsi 'store' dengan menyertakan total harga -->
                            <a href="{{ route('checkout.store', ['total' => $totalPrice]) }}" class="btn btn-primary">Checkout</a>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productCheckboxes = document.querySelectorAll(".product-checkbox");
        const selectedTotalElement = document.querySelector("#selected-total");

        productCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                updateSelectedTotal();
            });
        });

        const quantityInputs = document.querySelectorAll(".uk");
        quantityInputs.forEach(function (input) {
            input.addEventListener("change", function () {
                updateSelectedTotal();
            });
        });

        function updateSelectedTotal() {
            let total = 0;
            productCheckboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    const parentRow = checkbox.closest('.row');
                    const quantityInput = parentRow.querySelector('.uk');
                    const priceElement = parentRow.querySelector('.col-md-2 p');
                    const price = parseFloat(priceElement.textContent.split(' ')[1].replace(",", ""));
                    const quantity = parseInt(quantityInput.value);

                    total += price * quantity;
                }
            });
            selectedTotalElement.textContent = "Total  Rp. " + total.toLocaleString();
        }

        // Memanggil updateSelectedTotal() saat halaman dimuat untuk pertama kali
        updateSelectedTotal();
    });
</script>
<script>
    // Fungsi untuk memeriksa jumlah yang dimasukkan pengguna
    function checkQuantity(input, maxQuantity) {
        const quantity = parseInt(input.value);
        const errorMessage = input.parentNode.querySelector("#quantity-error-message");
        
        if (quantity > maxQuantity) {
            errorMessage.textContent = "Jumlah melebihi stok yang tersedia (" + maxQuantity + ")";
            input.value = maxQuantity; // Mengatur nilai input menjadi maksimum jika melebihi
        } else {
            errorMessage.textContent = ""; // Menghapus pesan kesalahan jika jumlah valid
        }
    }

    // Sisanya kode JavaScript Anda tetap sama
    document.addEventListener("DOMContentLoaded", function () {
        // ...
    });
    
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var cartItemId = this.getAttribute('data-id');
                var form = document.getElementById('delete-form-' + cartItemId);
                form.submit();
            });
        });
    });
</script>
                  
@include('user.layouts.footer')
