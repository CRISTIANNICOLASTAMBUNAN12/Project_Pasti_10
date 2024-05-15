@include('admin.layouts.sidebar')

@include('admin.layouts.header')
<style>
    .action-btn {
        margin-right: 20px; /* Adjust spacing between buttons */
    }
</style>

<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Galeri</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#0">Daftar Galeri</a>
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
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="mb-0">Data Galeri</h2>
                            <button class="btn btn-success" onclick="window.location='{{ route('admin.addgaleri') }}'">
                                <div style="display: flex; align-items: center;">
                                    <i class="lni lni-plus"></i> 
                                    <span style="margin-left: 5px;">Tambah Kategori</span>
                                </div>
                            </button>
                        </div>
                        <div class="table-wrapper table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="lead-email">
                                            <h6>No</h6>
                                        </th>
                                        <th class="lead-email">
                                            <h6>Nama</h6>
                                        </th>
                                        <th class="lead-phone">
                                            <h6>Gambar</h6>
                                        </th>
                                        <th class="lead-phone">
                                            <h6>Status</h6>
                                        </th>
                                        <th>
                                            <h6>Action</h6>
                                        </th>
                                    </tr>
                                    <!-- end table row-->
                                </thead>
                                <tbody>
                                    @foreach($sliders as $key => $category)
                                    <tr>
                                        <td class="min-width">
                                            <p>{{ $key + 1 }}</p>
                                        </td>
                                        <td class="min-width">
                                            <p>{{ $category['name'] }}</p>
                                        </td>
                                        <td class="min-width">
                                            <img src="{{ asset($category['image']) }}" alt="" style="max-width: 200px;">
                                        </td>
                                        <td class="min-width">
                                            <p><p>{{ $category['Status'] == 1 ? 'Active' : 'Nonactive' }}</p>
                                        </p>
                                        </td>
                                        <td>
                                            <div class="action">
                                                <a href="{{ route('admin.editgaleri',$category['ID']) }}" class="btn btn-primary btn-sm action-btn" title="Edit">
                                                    <i class="lni lni-pencil-alt"></i>
                                                </a>
                                                <a href="{{ route('admin.galeridestroy',$category['ID']) }}" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus produk ini?')){ document.getElementById('delete-form-{{$category['ID']}}').submit(); }" class="btn btn-danger btn-sm"><i class="lni lni-trash-can"></i></a>

                                                <form id="delete-form-{{$category['ID']}}" action="{{ route('admin.galeridestroy',$category['ID']) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                     
                        </div>
                    </div>
                </div>
            </div>              
        </div>
        
        
    </div>
    <!-- end container -->
</section>


@include('admin.layouts.footer')
  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>