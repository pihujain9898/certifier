@include('layouts.users.header')



<form class="mb-3" action="{{url('/upload-data-table'.'/'.$id)}}" method="POST" id="fileForm" enctype="multipart/form-data">
    @csrf
    <div class="drag-box">
        <label for="fileInput"><i class="bi bi-cloud-upload-fill fs-1"></i></label>
        <label for="fileInput">Upload CSV Data File</label>
        <input type="file" id="fileInput" accept=".csv" name="fileUrl">
        {{-- <input type="file" id="fileInput" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="fileUrl"> --}}
    </div>
</form>
<script src="{{url('users/js/index.js')}}"></script>


@include('layouts.users.footer')