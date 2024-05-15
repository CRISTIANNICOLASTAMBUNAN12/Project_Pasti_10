@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add Profile Photo') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('store-profile-photo') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Profile Photo') }}</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" required>
                                    <img id="preview-image" src="#" alt="Preview Image" style="display: none; width: 100px; height: 100px; border-radius: 50%; margin-top: 10px;">

                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="submit-btn" style="display: none;">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            var image = document.getElementById('preview-image');
            image.src = URL.createObjectURL(e.target.files[0]);
            image.style.display = 'block';
            document.getElementById('submit-btn').style.display = 'block';
        });
    </script>
@endsection
