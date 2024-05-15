<!-- resources/views/admin/Produk/add_slider.blade.php -->

@include('admin.layouts.sidebar')
<div class="layout-page">

@include('admin.layouts.header')
  
<div class="content-wrapper">
        
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1>Add Slider</h1>
        <div class="container">
            <form method="POST" action="{{ route('admin.storeslider') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Slider Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter slider name" required>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="1">Active</option>
                        <option value="0">Nonactive</option>
                    </select>
                </div>
                <img id="image_preview" src="#" alt="Preview" style="display: none; max-width: 300px; max-height: 300px; margin-top: 10px;">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
    </div>
       
    @include('admin.layouts.footer')
</div>

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
