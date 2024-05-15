@include('admin.layouts.sidebar')

@include('admin.layouts.header')
<style>
    /* CSS untuk membuat teks di dalam sel tabel menjadi berada di tengah */

   .search {
    position: relative;
   
  }

  .search input {
    height: 45px;
    width: 500px;
    text-indent: 25px;
    border: 2px solid #d6d4d4;
    padding-right: 120px; /* Memberi ruang di kanan untuk tombol */
  }

  .search input:focus {
    box-shadow: none;
    border: 2px solid blue;
  }

  .search .fa-search {
    position: absolute;
    top: 20px;
    left: 16px;
  }

  /* CSS untuk tombol Cari */
  .search button {
    position: absolute;
    top: 0;
    left: 500px;
    height: 100%;
    width: 110px;
    background: blue;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
  }
  </style>
  
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
    
    
                      <div class="tables-wrapper">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="card-style mb-30">
                              <h2 class="mb-0">Data Produk</h2><br>
                              <button class="btn btn-success" onclick="window.location='{{ route('products.create') }}'">
                                <div style="display: flex; align-items: center;">
                                    <i class="lni lni-plus"></i> 
                                    <span style="margin-left: 5px;">Tambah Kategori</span>
                                </div>
                            </button>
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="search">
                                  <i class="fa fa-search"></i>
                                  @if(count($products) === 0)
                                  <div class="alert alert-danger" role="alert">
                                      Produk tidak ditemukan. <a href="{{ route('products.index') }}" class="alert-link">Kembali ke halaman awal</a>
                                  </div>
                                  @else
                                  <form action="/products/search" class="form-inline" method="GET">
                                    <div class="search">
                                        <i class="fa fa-search"></i>
                                        <input type="text" id="search" name="search" class="form-control" placeholder="Cari produk...">
                                        <button   type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                              </div>
                                <button class="btn btn-success" onclick="window.location='{{ route('products.create') }}'">
                                  <div style="display: flex; align-items: center;">
                                      <i class="lni lni-plus"></i> 
                                      <span style="margin-left: 5px;">Tambah Produk</span>
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
                                          <th class="lead-email">
                                            <h6>Deskripsi</h6>
                                          </th>
                                          <th class="lead-email">
                                            <h6>Harga</h6>
                                          </th>
                                          <th class="lead-email">
                                            <h6>Stock</h6>
                                          </th>
                                          <th class="lead-email">
                                            <h6>Kategori</h6>
                                          </th>
                                          <th class="lead-email">
                                            <h6>Gambar</h6>
                                          </th>
                                          <th class="lead-email">
                                        <h6>Action</h6>
                                      </th>
                                    </tr>
                                    <!-- end table row-->
                                  </thead>
                                  <tbody>
                                    @foreach($products as $key => $product)
                                    <tr>
                                        <td class="min-width">
                                            <p>{{ $key + 1 }}</p>
                                          </td>
                                      <td class="min-width">
                                        <p>{{ $product['name'] }}</p>
                                      </td>
                                      <td class="min-width">
                                        <p>{{ $product['description'] }}</p>
                                      </td>
                                      <td class="min-width">
                                        <p>Rp.{{ $product['price'] }}</p>
                                      </td>
                                      <td class="min-width">
                                        <p> @if ($product['weight_unit'] == 'kilogram')
                                          {{ $product['stock'] }} kg
                                          @elseif ($product['weight_unit'] == 'gram')
                                          {{ $product['stock'] }} g
                                          @elseif ($product['weight_unit'] == 'liter')
                                          {{ $product['stock'] }} L
                                          @elseif ($product['weight_unit'] == 'milli')
                                          {{ $product['stock'] }} ml
                                          @elseif ($product['weight_unit'] == 'meter')
                                          {{ $product['stock'] }} m
                                          @else
                                          {{ $product['stock'] }} {{ $product['weight_unit'] }}
                                          @endif</p>
                                      </td>
                                  <td class="min-width">
                                    <p>{{ $product['category_name'] }}</p>
                                  </td>
                                      <td class="min-width">
                                        <img src="{{ asset($product['image']) }}" alt="" style="max-width: 200px;">
                                      </td>
                                      <td>
                                        <div class="action">
                                          <a href="#" class="btn btn-success btn-sm action-btn" title="Detail" data-toggle="modal" data-target="#detailModal{{ $product['ID'] }}">
                                            <i class="lni lni-search"></i>
                                           
                                        </a>
                                            <a href="{{ route('products.edit', $product['ID']) }}" class="btn btn-primary btn-sm action-btn" title="Edit">
                                                <i class="lni lni-pencil-alt"></i>
                                            </a>
                                            <a href="{{ route('products.destroy', $product['ID']) }}" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus produk ini?')){ document.getElementById('delete-form-{{$product['ID']}}').submit(); }" class="btn btn-danger btn-sm"><i class="lni lni-trash-can"></i></a>

                                            <form id="delete-form-{{$product['ID']}}" action="{{ route('products.destroy', $product['ID']) }}" method="POST" style="display: none;">
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
                      {!! $products->links() !!}
                      @endif
                      @foreach($products as $product)
                      <div class="modal fade" id="detailModal{{ $product['ID'] }}" tabindex="-1" role="dialog" aria-labelledby="detailModal{{ $product['ID'] }}Label" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="detailModal{{ $product['ID'] }}Label">Detail Produk: {{ $product['name'] }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <p><strong>Nama:</strong> {{ $product['name'] }}</p>
                                      <p><strong>Deskripsi:</strong> {{ $product['description'] }}</p>
                                      <p><strong>Stock:</strong> {{ $product['stock'] }} {{ $product['weight_unit'] }}</p>
                                      <p><strong>Harga:</strong> Rp.{{ $product['price'] }}</p>
                                      <p><strong>Kategori:</strong>  <p>{{ $product['category_name'] }}</p></p>
                                      
                                      <p><strong>Gambar:</strong></p>
                                      <img src="{{ $product['image'] }}" alt="" style="max-width: 100px;">
                                  </div>
                             
                              </div>
                          </div>
                      </div>
                      @endforeach
        
      
  
    </div>
    <!-- end container -->
  </section>
  @include('admin.layouts.footer')
  <script>
      document.addEventListener("DOMContentLoaded", function() {
    var descriptions = document.querySelectorAll('.description');
  
    descriptions.forEach(function(description) {
      var maxLength = 100; // Jumlah maksimum karakter
      var text = description.innerText;
  
      if (text.length > maxLength) {
        description.innerText = text.substring(0, maxLength) + '...'; // Memotong teks jika melebihi jumlah karakter maksimum
      }
    });
  });
  </script>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  