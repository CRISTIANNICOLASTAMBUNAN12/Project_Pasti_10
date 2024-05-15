
@include('user.layouts.navbar')
<body>  
    <!-- Bagian Carousel Kecil -->
    <div class="container py-5">
      <div class="row">
          <div class="col-md-8">
              <h2>Shipping Information</h2>
              <form>
                  <div class="mb-3">
                      <label for="fullName" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="fullName" placeholder="Enter your full name">
                  </div>
                  <div class="mb-3">
                      <label for="email" class="form-label">Email address</label>
                      <input type="email" class="form-control" id="email" placeholder="Enter your email">
                  </div>
                  <div class="mb-3">
                      <label for="address" class="form-label">Address</label>
                      <textarea class="form-control" id="address" rows="3" placeholder="Enter your address"></textarea>
                  </div>
                  <div class="mb-3">
                      <label for="phone" class="form-label">Phone Number</label>
                      <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                  </div>
                  <button type="submit" class="btn btn-primary">Continue to Payment</button>
              </form>
          </div>
          <div class="col-md-4">
              <div class="card">
                  <div class="card-body">
                      <h2>Order Summary</h2>
                      <ul class="list-group list-group-flush">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                              Product 1
                              <span>$50.00</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                              Product 2
                              <span>$30.00</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                              Shipping
                              <span>Free</span>
                          </li>
                      </ul>
                      <div class="d-flex justify-content-between mt-3">
                          <h5>Total:</h5>
                          <h5>$80.00</h5>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

</body>
@include('user.layouts.footer')
