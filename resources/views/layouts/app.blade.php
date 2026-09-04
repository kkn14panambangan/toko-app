<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kembang Tahu Pak Ujang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FAFAFA; }
    </style>
</head>
<body>


    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer (Hide on mobile since bottom nav takes over) -->
    <footer class="bg-white text-muted text-center py-4 mt-auto d-none d-md-block border-top">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Kembang Tahu Pak Ujang</p>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Add smooth transition and nice styling for mobile nav */
        .fixed-bottom a { transition: all 0.3s ease; }
        .fixed-bottom a:active { transform: scale(0.9); }
    </style>
</body>
</html>