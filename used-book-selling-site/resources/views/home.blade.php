<h1>Used books selling website</h1>



@auth
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" style="background: none; border: none; color: blue; text-decoration: underline;">Logout</button>
    </form>
@endauth

@guest
    <a href="{{ route('register') }}">Register now</a> <br>
    <a href="{{ route('login') }}">Login now</a>
@endguest