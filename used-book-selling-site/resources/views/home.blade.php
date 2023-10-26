<h1>Used books selling website</h1>



@auth
    <a href="">Logout</a>
@endauth

@guest
    <a href="{{ route('register') }}">Register now</a> <br>
    <a href="{{ route('login') }}">Login now</a>
@endguest