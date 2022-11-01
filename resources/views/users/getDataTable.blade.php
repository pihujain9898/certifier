@include('layouts.users.header')



<form class="mb-3" action="{{url('/upload-data-table')}}" method="POST" id="fileForm" enctype="multipart/form-data">
    @csrf
    <div class="drag-box">
        <label for="fileInput"><i class="bi bi-cloud-upload-fill fs-1"></i></label>
        <label for="fileInput">Upload data table</label>
        <input type="file" id="fileInput" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="fileUrl">
    </div>
</form>



@include('layouts.users.footer')