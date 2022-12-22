@include('layouts.users.header')
@error('uploadError')
<div class="mt-5 error-notification">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  {{ $message }}
</div>
@enderror
<header class="mt-5 container-fluid row certificate-page">
    <div class="col-md-8 ceritificate-box">
        <img id="certificate-img" src="{{url("uploads/certificates") . "/" . $img_name[0]->template}}" alt="">
    </div>
    <form action="{{url('/template').'/'.$id}}" method="POST" id="textParent" class="col-md-4 ceritificate-control-box">
        @csrf
        <div id="textChild" class="container row">
            <div class="col-sm-12 row mb-3">
                <label class="col-sm-3" for="attrib-type" for="font-size">TYPE</label>
                <select class="col-sm-9" id="attrib-type" onclick="changeAttribType()">
                    <option value="static">Static</option>
                    <option value="dynamic">Dynamic</option>
                  </select>
            </div>
            <div class="col-sm-12 row mb-3">
                <label class="col-sm-3" for="attrib-name" for="font-size">ATTRIB</label>
                <input class="col-sm-9" type="text" id="attrib-name" onkeyup="changeAttribName()">
            </div>
            <div class="col-sm-12 row mb-3">
                <label class="col-sm-3" for="sample-text" for="font-size">SAMPLE</label>
                <input class="col-sm-9" type="text" id="sample-text" onkeyup="sampleText()">
            </div>
            <div class="col-sm-12 row">
                <label class="col-sm-3" for="font-size">SIZE</label>
                <input id="font-size" class="col-sm-3" type="text" onkeyup="changeFontSize()">
                <div class="row col-sm-6" style="justify-content: flex-end;">
                    <button type="button" class="btn btn-dark col-sm-4" onclick="increaseSize()">+</button>
                    <button type="button" class="btn btn-dark col-sm-4" onclick="decreaseSize()">-</button>
                </div>
            </div>
        </div>
        <button type="button" id="addText" class="mt-4 btn btn-dark" onclick="addTexts()">Add Text</button>
        <input type="submit" class="mt-4 btn btn-primary" value="Save">

        @if(!empty($attribs[0]->textAttribs))
        @php
        $i= 0;    
        @endphp
        @foreach (json_decode($attribs[0]->textAttribs) as $text)
        <div class="scrollText savedscrollText" data-id="{{$i}}" onclick="showAttribs({{$i}})" style="font-size:{{json_decode($text)->fontSize}}; cursor: grab; top: {{json_decode($text)->yPosition}}; left: {{json_decode($text)->xPosition}};">{{json_decode($text)->attribSample}}</div>
        <input class="scrollInput" type="hidden" data-id="{{$i}}" name="{{json_decode($text)->attribName}}" value='{"attribType":"{{json_decode($text)->attribType}}","attribName":"{{json_decode($text)->attribName}}","attribSample":"{{json_decode($text)->attribSample}}","fontSize":"{{json_decode($text)->fontSize}}","xPosition":"{{json_decode($text)->xPosition}}","yPosition":"{{json_decode($text)->yPosition}}"}'>
        @php $i++; @endphp
        @endforeach
        <script>
        elementCount={{count((array)json_decode($attribs[0]->textAttribs))-1;}};
        let certifImg = document.getElementById("certificate-img");
        var item;
        for (var i=0; i<document.getElementsByClassName('savedscrollText').length; i++){
            item=document.getElementsByClassName('savedscrollText')[i];
            item.style.left = (parseInt(item.style.left)+parseInt(certifImg.offsetLeft)-parseInt(item.offsetWidth/2))+"px";
            item.style.top = (parseInt(item.style.top)+parseInt(certifImg.offsetTop)-parseInt(item.offsetHeight/2)-10)+"px";
        }
        </script>
        @endif

    </form>
    <script src="{{asset('users/js/text.js')}}"></script>
</header>



@include('layouts.users.footer')