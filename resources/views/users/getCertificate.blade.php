@include('layouts.users.header')



<form class="mb-3" action="{{url('/upload-certificate').'/'.$id}}" method="POST" id="fileForm" enctype="multipart/form-data">
    @csrf
    <div class="drag-box">
        <label for="fileInput"><i class="bi bi-cloud-upload-fill fs-1"></i></label>
        <label for="fileInput">Upload blank certificate</label>
        <input type="file" id="fileInput" accept="image/png, image/jpg, image/gif, image/jpeg" name="fileUrl">
    </div>
</form>
<script src="{{url('users/js/index.js')}}"></script>


@include('layouts.users.footer')