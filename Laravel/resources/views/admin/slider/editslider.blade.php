<!-- resources/views/admin/Produk/edit_slider.blade.php -->

@include('admin.layouts.sidebar')
<div class="layout-page">

@include('admin.layouts.header')
  
<div class="content-wrapper">
        
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1>Edit Slider</h1>
        <div class="container">
            <form method="POST" action="{{ route('admin.sliderupdate', ['id' => $sliders['ID']]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Slider Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter slider name" value="{{ $sliders['name'] }}">
                </div>
                <div class="form-group">
                    <label for="image">Gambar:</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="1" {{ $sliders['Status'] == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $sliders['Status'] == 0 ? 'selected' : '' }}>Nonactive</option>
                    </select>
                </div>
                <!-- Hidden input field to hold the existing image value -->
                <input type="hidden" name="existing_image" value="{{ $sliders['image'] }}">
                
                <img id="image_preview" src="{{ asset($sliders['image']) }}" alt="Preview" style="max-width: 300px; max-height: 300px; margin-top: 10px;"><br><br>
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
