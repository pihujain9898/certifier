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
<form class="mb-3" action="{{url('/upload-data'.'/'.$id)}}" method="POST" id="fileForm" enctype="multipart/form-data">
    @csrf
    <div class="mt-5 mb-1 drag-box">
        <label for="fileInput"><i class="bi bi-cloud-upload-fill fs-1"></i></label>
        <label for="fileInput">Upload CSV Data File</label>
        <input type="file" id="fileInput" accept=".csv" name="fileUrl">
        {{-- <input type="file" id="fileInput" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="fileUrl"> --}}
    </div>
    <p class="drag-msg">*Data file must be a csv format file.</p>
    <p class="drag-msg">*Data file size must be in between 1Byte to 16MB</p>
</form>
<script src="{{url('users/js/index.js')}}"></script>


@include('layouts.users.footer')