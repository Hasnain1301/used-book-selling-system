<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Used book selling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    @yield('css')

    @yield('js')
    
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <div class="d-flex justify-content-start">
                <a class="navbar-brand text-white" href="{{ route('home') }}">Books4less</a>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                @auth
                    <a class="nav-link text-white" href="">{{ auth()->user()->name }}</a>
                    <a class="nav-link text-white" href="{{ route('basket') }}">Basket</a>
                    <a class="nav-link text-white" href="{{ route('profile', ['name' => auth()->user()->name]) }}">My Profile</a>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Logout</button>
                    </form>
                    
                @endauth

                @guest
                    <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                    <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                @endguest
                
            </div>
        </div>
    </nav>

    
    @yield('content')

</body>
</html>