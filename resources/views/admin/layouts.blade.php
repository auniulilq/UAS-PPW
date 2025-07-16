<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MyShop</title>
    {{-- Google Fonts - Poppins for modern look --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Admin specific styles (can be moved to app.css if preferred) */
        body {
            background-color: #f4f7f6;
        }
        .admin-navbar {
            background-color: #2c3e50; /* Dark blue */
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .admin-navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-navbar-brand {
            color: #ecf0f1; /* Light grey */
            font-size: 1.8em;
            font-weight: 700;
            text-decoration: none;
        }
        .admin-navbar-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 25px;
        }
        .admin-navbar-links a {
            color: #bdc3c7; /* Grey */
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .admin-navbar-links a:hover {
            color: #3498db; /* Blue */
        }
        .admin-content {
            padding: 40px 0;
            min-height: calc(100vh - 120px); /* Adjust based on navbar/footer height */
        }
        .admin-footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 20px 0;
            font-size: 0.9em;
        }
        .admin-panel-title {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 50px;
            font-size: 3em;
            font-weight: 700;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-radius: 10px;
            overflow: hidden; /* For rounded corners */
        }
        .admin-table th, .admin-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }
        .admin-table th {
            background-color: #3498db; /* Blue header */
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        .admin-table tbody tr:hover {
            background-color: #f8f8f8;
        }
        .admin-table .action-buttons {
            display: flex;
            gap: 10px;
        }
        .admin-table .action-buttons .btn {
            padding: 8px 12px;
            font-size: 0.85em;
            border-radius: 6px;
            box-shadow: none; /* Override default button shadow */
        }
        .admin-add-button {
            display: inline-block;
            margin-bottom: 30px;
            padding: 12px 25px;
            font-size: 1em;
            border-radius: 8px;
            background-color: #27ae60; /* Green */
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .admin-add-button:hover {
            background-color: #229954;
        }

        /* Form Styles for Admin */
        .admin-form-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .admin-form-container h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 40px;
        }
        .admin-form-container .form-group {
            margin-bottom: 25px;
        }
        .admin-form-container label {
            display: block;
            font-size: 1.1em;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
        }
        .admin-form-container .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .admin-form-container .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }
        .admin-form-container .text-danger {
            color: #e74c3c;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
        .admin-form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            justify-content: flex-end;
        }
        .admin-form-buttons .btn {
            padding: 12px 25px;
            font-size: 1em;
            border-radius: 8px;
        }
        .admin-form-buttons .btn-primary {
            background-color: #3498db;
        }
        .admin-form-buttons .btn-primary:hover {
            background-color: #2980b9;
        }
        .admin-form-buttons .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }
        .admin-form-buttons .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        .admin-form-buttons .btn-danger {
            background-color: #e74c3c;
        }
        .admin-form-buttons .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Image preview in forms */
        .image-preview {
            margin-top: 15px;
            text-align: center;
        }
        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .image-preview p {
            margin-top: 10px;
            font-size: 0.9em;
            color: #777;
        }

        /* Responsiveness for Admin Panel */
        @media (max-width: 768px) {
            .admin-navbar .container {
                flex-direction: column;
                gap: 15px;
            }
            .admin-navbar-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }
            .admin-panel-title {
                font-size: 2.5em;
                margin-bottom: 40px;
            }
            .admin-table {
                font-size: 0.9em;
            }
            .admin-table th, .admin-table td {
                padding: 10px;
            }
            .admin-form-container {
                padding: 25px;
            }
            .admin-form-container h2 {
                font-size: 2em;
                margin-bottom: 30px;
            }
            .admin-form-buttons {
                flex-direction: column;
                gap: 10px;
            }
            .admin-form-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav class="admin-navbar">
    <div class="container">
        <a href="{{ route('admin.products.index') }}" class="admin-navbar-brand">Admin MyShop</a>
        <ul class="admin-navbar-links">
            <li><a href="{{ route('admin.products.index') }}">Produk</a></li>
            <li><a href="{{ route('admin.categories.index') }}">Kategori</a></li> {{-- Baris ini --}}
            {{-- Tambahkan link admin lain di sini --}}
        </ul>
    </div>
</nav>

    <div class="container admin-content">
        {{-- Flash Messages for Admin Panel --}}
        <div style="margin-bottom: 20px;">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>

        @yield('content')
    </div>

    <footer class="admin-footer">
        <div class="container">
            <p>&copy; 2025 Admin MyShop. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
