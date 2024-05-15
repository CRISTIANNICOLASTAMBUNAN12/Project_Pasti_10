<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <title>Toko Tambunan</title>
     <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
  <script type="text/javascript"
  src="https://app.stg.midtrans.com/snap/snap.js"
data-client-key="{{config('midtrans.client_key')}}"></script>
<!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
</head>
<header>
    <!-- Top Bar -->
<div class="bg-success text-light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <span class="navbar-text">
                Ikuti Kami di 
                <li class="list-inline-item">
                    <a class="nav-link" href="#"><i class="fab fa-facebook"></i></a>
                </li>
                <li class="list-inline-item">
                    <a class="nav-link" href="#"><i class="fab fa-youtube"></i></a>
                </li>
                <li class="list-inline-item">
                    <a class="nav-link" href="#"><i class="fab fa-instagram"></i></a>
                </li>
                <li class="list-inline-item">
                    <a class="nav-link" href="#"><i class="fab fa-twitter"></i></a>
                </li>              
            </span>
            <ul class="list-inline mb-0">
                @if (Auth::check() && Auth::user()->email_verified_at)
        <li class="list-inline-item">
            <a class="nav-link" href="{{route('home')}}"><i class="fas fa-home"></i> Home </a>
        </li>
    @else
        <li class="list-inline-item">
            <a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a>
        </li>
        @endauth
                <li class="list-inline-item">
                    <a class="nav-link" href="#"><i class="fas fa-info-circle"></i> Tentang kami</a>
                </li>
                <li class="list-inline-item">
                    <a class="nav-link" href="{{route('galeri')}}"><i class="fas fa-info-circle"></i> Galeri</a>
                </li>
                <li class="list-inline-item">
                    <a class="nav-link" href=""><i class="fas fa-book-open"></i> Bantuan?</a>
                </li>
                <li class="list-inline-item">
                    <a class="nav-link" href="#"><i class="fas fa-globe"></i> Bahasa Indonesia</a>
                </li>
                &nbsp;
                @if (Auth::check() && Auth::user()->email_verified_at)
                   
                @else
                    <li class="list-inline-item">
                        <a class="nav-link" href="{{ route('login') }}">Daftar | Login</a>
                    </li>
                @endauth
            </ul>
            
        </div>
    </div>
</div>    

<nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container">
        <!-- Logo TP -->
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="user.png" alt="TOKO PUPUK" width="50"> Tambunan Store
        </a>
        <!-- Tombol Kategori Produk -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Kotak Pencarian -->
            <form class="d-flex flex-grow-1">
                <input class="form-control me-2 flex-grow-1" type="search" placeholder="Cari di TP" aria-label="Search">
                <button class="btn btn-outline" type="submit"><i class="fas fa-search search-icon"></i></button>
            </form>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('keranjangs')}}"><i class="fas fa-shopping-cart"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#notificationModal" href="javascript:void(0)"><i class="fas fa-bell"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-comments"></i></a>
                </li>    
                @if (Auth::check() && Auth::user()->email_verified_at)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   
                            <img src="{{ asset('storage/images/' . Auth::user()->image) }}" alt="Foto Profil" class="rounded-circle" width="50">
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                
    </ul>
</li>
            </ul>
        </div>
    </div>
</nav>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                This is a notification message. You can put any content here.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</header>
<br>