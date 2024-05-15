@include('user.layouts.navbar')
<body>  
    <!-- Bagian Carousel Kecil -->
    <div class="container"> <!-- Carousel -->
        <div class="container"> <!-- Carousel -->
            <form id="payment-form" action="{{ route('orders.check') }}" method="POST">
                @csrf
      
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" required>
                <br>
                <label for="expiry_month">Expiry Month:</label>
                <input type="text" id="expiry_month" name="expiry_month" required>
                <br>
                <label for="expiry_year">Expiry Year:</label>
                <input type="text" id="expiry_year" name="expiry_year" required>
                <br>
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required>
                <br>
                <button type="submit">Pay Now</button>
            </form>
        </div>
    </div>
</body>
@include('user.layouts.footer')
