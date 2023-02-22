@include('layouts.users.header')

<style>
@media screen and (min-width: 800px) {
    body{
        overflow: hidden;
    }
}
@media screen and (max-height: 540px) {
    body{
        overflow: scroll;
    }
}
</style>

<header>
<video autoplay loop class="login-header-bg" muted plays-inline id="loginBgVideo">
    <source src="{{ asset('users/img/bg.mp4') }}" type="video/mp4" playbakrate>
</video>
<script>
    var vid = document.getElementById("loginBgVideo");
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

        <div class="form-item" style="height: 64px">
            <i class="bi bi-eye-fill pas-vis-btn" onclick="passwordShow()"></i>
            <input type="password" name="password" required="required" placeholder="Password" required style="transform: translateY(-30px);">
            <span class="text-danger">
                @error('entered_password')
                    {{ $message }}
                @enderror
            </span>
            <span class="text-danger">
                @error('password')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <script>
            function passwordShow(){
                if($(".form-item input[name='password']")[0].type == "password"){
                    $(".form-item input[name='password']")[0].type = "text"
                } else{
                    $(".form-item input[name='password']")[0].type = "password";
                }
            }
        </script>

        <div class="button-panel">
            <input type="submit" class="button" title="Log In" name="login" value="Login">
        </div>
    </form>
    <div class="reminder">
        <center>
            <a href="{{ url('login/facebook') }}"><img class="login-icon" src="{{ asset('users/img/facebook.png') }}" alt="Facebook Icon"></a>
            <a href="{{ url('login/google') }}"><img class="login-icon" src="{{ asset('users/img/search.png') }}" alt="Google Icon"></a>
            <a href="{{ url('login/github') }}"><img class="login-icon" src="{{ asset('users/img/github.png') }}" alt="Github Icon"></a>
        </center>
        <a href="/signup" id="siginup-page">Not a member? Sign up now</a>
        <p><a href="#">Forgot password?</a></p>
    </div>
</div>



@include('layouts.users.footer')