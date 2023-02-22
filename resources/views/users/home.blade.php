@include('layouts.users.header')

<link rel="stylesheet" href="{{asset("users/css/home.css")}}">

<video id="homeBgVid" autoplay loop muted plays-inline>        
    <source id="homeBgSrc" src="{{ asset('users/img/homeBg.mp4') }}" type="video/mp4">
</video>
<script>
    let homeBgVid = document.getElementById("homeBgVid");
    let homeBgSrc = document.getElementById("homeBgSrc");
    setTimeout(function() {
        homeBgSrc.src="users/img/homeBgContinue.mp4";
        homeBgVid.load();
        homeBgVid.play();
    }, 20100);
    
</script>
<div class="home-nav"></div>

<header>
    <div class="home-main">
        <p class="upper-p">Genrate Bulk <span>Certificates</span></p>
        <h1>Certification is as easy as never <span>before</span></h1>
        <p class="lower-p">Bulk Certificates Maker & Mailer</p>
        <br>
        <a href="{{url("/projects")}}" class="pop-outin">Let's Start!</a>
    </div>
</header>
{{-- <main></main> --}}

<script src="{{asset('users/js/home.js')}}"></script>

@include('layouts.users.footer')