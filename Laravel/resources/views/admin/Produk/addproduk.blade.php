@include('admin.layouts.sidebar')

@include('admin.layouts.header')

  
  <section class="section">
    <div class="container-fluid">
      <div class="title-wrapper pt-30">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="title">
              <h2>Produk</h2>
            </div>
          </div>
          <!-- end col -->
          <div class="col-md-6">
            <div class="breadcrumb-wrapper">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#0">Daftar Produk</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    eCommerce
                  </li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama Produk:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div><br>
        <div class="form-group">
            <label for="description">Deskripsi:</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required></textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div><br>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <div class="input-group">
                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" required style="max-width: 300px;">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <select class="form-control" id="weight_unit" name="weight_unit" required onchange="updatePriceUnit()">
                            <option value="kilogram">Kilogram</option>
                            <option value="gram">Gram</option>
                            <option value="liter">Liter</option>
                            <option value="milli">Milli</option>
                            <option value="meter">Meter</option>
                        </select>
                    </span>
                </div>
            </div>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @error('weight_unit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div><br>
        <div class="form-group">
            <label for="price">Harga:</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required style="max-width: 300px;">
            <span id="price_unit" placeholder="wkwk"></span> <!-- Placeholder for displaying the selected unit -->
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div><br>
        <div class="form-group">
            <label for="category_id">Kategori:</label>
            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category['ID'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div><br>
        <div class="form-group">
            <label for="image">Gambar:</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required onchange="previewImage(event)">
            <img id="image_preview" src="#" alt="Preview" style="display: none; max-width: 300px; max-height: 300px; margin-top: 10px;">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
     
      
  
    </div>
    <!-- end container -->
  </section>
  @include('admin.layouts.footer')
  <script>
    window.onload = function() {
        updatePriceUnit();
    };

    function updatePriceUnit() {
        var selectBox = document.getElementById("weight_unit");
        var selectedValue = selectBox.value; // Mendapatkan nilai yang dipilih
        var priceUnitSpan = document.getElementById("price_unit");
        
        // Menetapkan unit harga berdasarkan nilai yang dipilih
        var priceUnit = "";
        if (selectedValue === "kilogram") {
            priceUnit = " per kilogram";
        } else if (selectedValue === "gram") {
            priceUnit = " per gram";
        } else if (selectedValue === "liter") {
            priceUnit = " per liter";
        } else if (selectedValue === "milli") {
            priceUnit = " per milli";
        } else if (selectedValue === "meter") {
            priceUnit = " per meter";
        }
        
        // Menampilkan unit harga
        priceUnitSpan.textContent = priceUnit;
    }
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
            output.style.display = 'block'; // Menampilkan gambar yang dipilih
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  