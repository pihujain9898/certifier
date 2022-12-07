@include('layouts.users.header')




<video autoplay loop class="home-header-bg" muted plays-inline id="bgVideo">
    <source src="{{ asset('users/img/bg.mp4') }}" type="video/mp4" playbakrate>
</video>
<script>
    var vid = document.getElementById("bgVideo");
    vid.playbackRate = 0.5;
</script>
<div class="form-wrapper">

    <form action="{{url('/login')}}" method="post" name="myform">
        @csrf
        <h3 class="form-heading">Login here</h3>
        @if (Session::has('error'))
        <span class="text-danger">{{ Session::get('error') }}</span>
        @endif
        <div class="form-item">
            <input type="email" name="email" required="required" placeholder="Email" autofocus required value="{{old("email")}}">
            <span class="text-danger">
                @error('email')
                    {{ $message }}
                @enderror
            </span>
        </div>

        <div class="form-item">
            {{-- <i class="bi bi-eye-fill pas-vis-btn"></i> --}}
            <input type="password" name="password" required="required" placeholder="Password" required>
            <span class="text-danger">
                @error('password_new')
                    {{ $message }}
                @enderror
            </span>
        </div>

        <div class="button-panel">
            <input type="submit" class="button" title="Log In" name="login" value="Login">
        </div>
    </form>
    <div class="reminder">
        <center>
            <a href="{{ url('auth/facebook') }}"><img class="login-icon" src="{{ asset('users/img/facebook.png') }}" alt="Facebook Icon"></a>
            <a href="{{ url('auth/google') }}"><img class="login-icon" src="{{ asset('users/img/search.png') }}" alt="Google Icon"></a>
            <a href="{{ url('auth/github') }}"><img class="login-icon" src="{{ asset('users/img/github.png') }}" alt="Github Icon"></a>
        </center>
        <a href="/signup" id="siginup-page">Not a member? Sign up now</a>
        <p><a href="#">Forgot password?</a></p>
    </div>
</div>



@include('layouts.users.footer')