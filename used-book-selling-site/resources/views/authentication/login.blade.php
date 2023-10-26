<h1>Login</h1>

<div>

<div>   
    @if(session('incorrect'))
        {{ session('incorrect') }}
    @endif
</div>


<form action="{{ route('login') }}" method="post">
        @csrf
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter password">
        </div>

        <div>
            <button type="submit">
                Login now
            </button>
        </div>
    </form>
</div>
