<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boarding House Management System')</title>
    
    <!-- Bootstrap 5 CSS - Local file for offline use -->
    <!-- Download from: https://getbootstrap.com/docs/5.3/getting-started/download/ -->
    <!-- Place bootstrap.min.css in public/css/ -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Font Awesome CSS - Local file for offline use -->
    <!-- Download from: https://fontawesome.com/download -->
    <!-- Place font-awesome folder in public/css/ -->
    <link href="{{ asset('css/font-awesome/all.min.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="bg-light">
    @yield('content')
    
    <!-- Bootstrap 5 JS Bundle - Local file for offline use -->
    <!-- Place bootstrap.bundle.min.js in public/js/ -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
