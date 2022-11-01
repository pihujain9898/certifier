@include('layouts.users.header')



<form class="mb-3" action="{{url('/upload-certificate')}}" method="POST" id="fileForm" enctype="multipart/form-data">
    @csrf
    <div class="drag-box">
        <label for="fileInput"><i class="bi bi-cloud-upload-fill fs-1"></i></label>
        <label for="fileInput">Upload blank certificate</label>
        <input type="file" id="fileInput" accept="image/png, image/jpg, image/gif, image/jpeg" name="fileUrl">
    </div>
</form>



@include('layouts.users.footer')