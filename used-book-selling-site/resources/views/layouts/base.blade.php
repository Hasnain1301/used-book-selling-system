<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Used book selling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

    @yield('css')

    @yield('js')
    
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex justify-content-start">
                <a class="navbar-brand text-white" href="/"><img src="{{ asset('images/logo.jpg') }}" alt="" height="125" width="125"></a>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                @auth
                    <a class="nav-link text-white" href="">{{ auth()->user()->name }}</a>
                    <a class="nav-link text-white" href="{{ route('manage.listings') }}">Create/Manage Listings</a>
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
    
<footer class="bg-dark text-white pt-4 pb-2">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5 class="text-uppercase mb-3">Books4Less</h5>
                <p>&copy; {{ date('Y') }} Books4Less. All rights reserved.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="text-uppercase mb-3">Quick links</h5>
                @auth
                    <a class="text-white" href="{{ route('home') }}">Home</a><br><br>
                    <a class="text-white" href="{{ route('profile.orderHistory') }}">My Orders</a><br><br>
                    <a class="text-white" href="{{ route('profile', ['name' => auth()->user()->name]) }}">My Profile</a>
                @endauth
                @guest
                    <a class="text-white" href="{{ route('home') }}">Home</a><br><br>
                    <a class="text-white" href="{{ route('login') }}">Login</a><br><br>
                    <a class="text-white" href="{{ route('register') }}">Sign Up</a>
                @endguest
            </div>
            <div class="col-md-4 mb-3">
                <h5 class="text-uppercase mb-3">Subscribe to recieve promo codes and more</h5>
                <form>
                    <div class="form-group mb-2">
                        <input type="email" class="form-control" placeholder="Email address">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" placeholder="Your name">
                    </div>
                    <button type="submit" class="btn btn-primary">Subscribe now to get benefits</button>
                </form>
            </div>
        </div>
    </div>
</footer>

</body>
</html>