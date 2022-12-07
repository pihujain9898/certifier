@include('layouts.users.header')




<main>
    <video autoplay loop class="home-header-bg" muted plays-inline id="bgVideo">
        <source src="{{asset('users/img/bg.mp4')}}" type="video/mp4" playbakrate>
    </video>
    <script>
        var vid = document.getElementById("bgVideo");
        vid.playbackRate = 0.5;
    </script>
    <div class="signup-form-wrapper form-wrapper">  
        <form action="{{url('/signup')}}" method="post" name="myform" >
            @csrf
            <h3  class="form-heading" style="border-bottom: 2px solid rgb(223, 223, 223); padding-bottom:.6em">Register here</h3>

            <div class="form-item">
                <input type="text" name="name" required="required" placeholder="Name" autofocus value="{{old("name")}}">
                <span class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-item">
                <input type="email" name="email" required="required" placeholder="Email" autofocus value="{{old("email")}}">
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="form-item">
                <input type="password" name="password" required="required" placeholder="Password">
                <span class="text-danger">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-item">
                <input type="password" name="password_confirmation" required="required" placeholder="Re-enter password" >
                <span class="text-danger">
                    @error('confirm-password')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="button-panel">
                <input type="submit" class="button" title="Signup" name="signin" value="Signin">
            </div>
        </form>
        <div class="reminder">
        <!-- <p>Not a member? <a href="#">Sign up now</a></p> -->
        <center>
            <a href="{{ url('auth/facebook') }}"><img class="login-icon" src="{{ asset('users/img/facebook.png') }}" alt="Google Icon"></a>
            <a href="{{ url('auth/google') }}"><img class="login-icon" src="{{ asset('users/img/search.png') }}" alt="Google Icon"></a>
            <a href="{{ url('auth/github') }}"><img class="login-icon" src="{{ asset('users/img/github.png') }}" alt="Google Icon"></a>
        </center>
        <a href="{{url('/login')}}" id="siginup-page">Already a member? Log in</a>

        </div>
    </div>
</main>



@include('layouts.users.footer')