@include('admin.layouts.sidebar')

@include('admin.layouts.header')

  
  <section class="section">
    <div class="container-fluid">
      <div class="title-wrapper pt-30">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="title">
              <h2>Edit Category</h2>
            </div>
          </div>
          <!-- end col -->
          <div class="col-md-6">
            <div class="breadcrumb-wrapper">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#0">Edit Category</a>
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
      <form method="POST" action="{{ route('admin.categoryupdate', ['id' => $category['ID']]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Kategori:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $category['name'] }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div><br>
        <div class="form-group">
            <label for="image">Gambar:</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImage(event)">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <input type="hidden" name="existing_image" value="{{ $category['image'] }}">
        <img id="image_preview" src="{{ asset($category['image']) }}" alt="Preview" style="max-width: 300px; max-height: 300px; margin-top: 10px;"><br><br>
        <button type="submit" class="btn btn-primary">Submit</button>
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
  