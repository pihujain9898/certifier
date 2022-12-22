@include('layouts.users.header')

@error('uploadError')
<div class="mt-5 error-notification">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  {{ $message }}
</div>
@enderror
@error('fileUrl')
<div class="mt-5 error-notification">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  {{ $message }}
</div>
@enderror
<form action="{{url('/certificate').'/'.$id}}" method="POST" id="fileForm" enctype="multipart/form-data">
    @csrf
    <div class="mt-5 mb-1 drag-box">
        <label for="fileInput"><i class="bi bi-cloud-upload-fill fs-1"></i></label>
        <label for="fileInput">Upload blank certificate</label>
        <input type="file" id="fileInput" accept="image/png, image/jpg, image/jpeg" name="fileUrl">
    </div>
    <p class="drag-msg">*Image must be in format of png/jpg/jpeg.</p>
    <p class="drag-msg">*Image size must be in between 200KB to 4MB</p>
</form>
<script src="{{url('users/js/index.js')}}"></script>


@include('layouts.users.footer')