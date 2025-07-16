<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop</title>
    {{-- Google Fonts - Poppins for modern look --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar">
        <div class="container">
            <a href="/" class="navbar-brand">MyShop</a>
            <ul class="navbar-links">
                <li><a href="/">Home</a></li>
                <li><a href="/products">Products</a></li>
                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                <li><a href="/cart">Keranjang</a></li>
                {{-- Tambahkan link lain sesuai kebutuhan --}}
            </ul>
        </div>
    </nav>

    {{-- Container untuk pesan flash (alert bawaan Laravel) --}}
    <div class="container" style="margin-top: 20px;">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-info">
                {{ session('status') }}
            </div>
        @endif
    </div>

    {{-- Custom Notification Bar (akan muncul di atas) --}}
    <div id="custom-notification" class="custom-notification" style="display: none;">
        <span id="notification-message"></span>
        <button class="close-btn" onclick="document.getElementById('custom-notification').style.display = 'none';">&times;</button>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 MyShop. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBar = document.getElementById('custom-notification');
            const notificationMessage = document.getElementById('notification-message');

            // Cek apakah ada pesan 'success' dari session
            @if (session('success'))
                notificationMessage.textContent = "{{ session('success') }}";
                notificationBar.style.display = 'flex'; // Tampilkan notifikasi
                notificationBar.classList.add('success'); // Tambahkan kelas success untuk styling

                // Sembunyikan notifikasi setelah 5 detik
                setTimeout(() => {
                    notificationBar.style.display = 'none';
                    notificationBar.classList.remove('success');
                }, 5000);
            @endif
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success') && session('invoice'))
    <script>
        Swal.fire({
            title: 'Pembayaran Berhasil!',
            html: `{!! session('invoice') !!}`,
            icon: 'success',
            confirmButtonText: 'Oke',
            width: 600
        });
    </script>
@endif
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
