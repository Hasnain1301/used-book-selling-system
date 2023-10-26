<h1>Register</h1>

<div>
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter password">
        </div>

        <div>
            <label for="password">Re-enter password</label>
            <input type="password" name="password_confirmation" placeholder="Re-enter your password">
        </div>

        <div>
            <button type="submit">
                Register account now
            </button>
        </div>
    </form>
</div>