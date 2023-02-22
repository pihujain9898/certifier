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
        <input type="hidden" name="imageSize" value="{{$attribs[0]->templateSize}}">
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
            <div class="changeFontSize">
                <label class="" for="font-size">SIZE</label>
                <input id="font-size" class="" type="text" onkeyup="changeFontSize()">
                <div class="">
                    <button type="button" class="btn btn-dark" onclick="increaseSize()">+</button>
                    <button type="button" class="btn btn-dark" onclick="decreaseSize()">-</button>
                </div>
            </div>
        </div>
        <button type="button" id="addText" class="mt-4 btn btn-dark" onclick="addTexts()">Add Text</button>
        <input type="submit" class="mt-4 btn btn-primary" value="Save">

        @if(!empty($attribs[0]->textAttribs))
        @php
        $imgName = $img_name[0]->template;
        $imgSize = json_decode($attribs[0]->templateSize);
        $size = getimagesize('uploads/certificates/'.$imgName);
        
        $orignal_width=$size[0];
        $orignal_height=$size[1];
        $display_width=$imgSize->imgWidth;
        $display_height=$imgSize->imgHeight;

        $fontRatio=($display_width/$orignal_width + $display_height/$orignal_height)/2;
        $i= 0;    
        @endphp
        @foreach (json_decode($attribs[0]->textAttribs) as $text)
        <input class="scrollInput" type="hidden" data-id="{{$i}}" name="{{json_decode($text)->attribName}}" value='{"attribType":"{{json_decode($text)->attribType}}","attribName":"{{json_decode($text)->attribName}}","attribSample":"{{json_decode($text)->attribSample}}","fontSize":"{{json_decode($text)->fontSize}}","xPosition":"{{json_decode($text)->xPosition}}","yPosition":"{{json_decode($text)->yPosition}}"}'>
        @php $i++; @endphp
        @endforeach
        @endif
    </form>
    
    <script src="{{asset('users/js/text.js')}}"></script>
</header>



@include('layouts.users.footer')