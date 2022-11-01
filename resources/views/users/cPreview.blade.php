@include('layouts.users.header')


<header class="mt-5 container-fluid row certificate-page">
    <div class="col-md-8 ceritificate-box">
        <img id="certificate-img" src="{{url("uploads/certificates/") . "/" . Session()->get('template')}}" alt="">
    </div>
    <form action="{{url('/set-attributes')}}" method="POST" id="textParent" class="col-md-4 ceritificate-control-box">
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
    </form>
    <script src="{{asset('users/js/text.js')}}"></script>
</header>



@include('layouts.users.footer')