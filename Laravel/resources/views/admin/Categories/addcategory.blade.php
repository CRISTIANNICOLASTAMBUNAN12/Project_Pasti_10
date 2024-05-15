@include('admin.layouts.sidebar')

@include('admin.layouts.header')

  
  <section class="section">
    <div class="container-fluid">
      <div class="title-wrapper pt-30">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="title">
              <h2>Add Category</h2>
            </div>
          </div>
          <!-- end col -->
          <div class="col-md-6">
            <div class="breadcrumb-wrapper">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#0">Add Category</a>
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
      <form method="POST" action="{{ route('admin.storecategory') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div><br>
        <div class="form-group">
            <label for="image">Gambar:</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required onchange="previewImage(event)">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <img id="image_preview" src="#" alt="Preview" style="display: none; max-width: 300px; max-height: 300px; margin-top: 10px;"><br>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
     
      
  
    </div>
    <!-- end container -->
  </section>
  @include('admin.layouts.footer')
  
  <script>
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
  