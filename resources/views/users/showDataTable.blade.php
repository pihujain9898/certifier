@include('layouts.users.header')
<form action="{{url('/get-data-attribs').'/'.$id}}" method="POST">
  @csrf
<div class="data-table-div">
  <h3 class="data-table-heading">
      Set attributes on the data
  </h3>
  <input type="submit" class="btn btn-outline-primary" value="Embade Columns" onclick="sanitize()">
</div>
{{(json_decode($dataFileAttribs)[0]->dataFileAttribs)}}
<section class="w-100 text-center table-responsive">
  <table class="table">
    <thead>
      <tr>
        @for($i=0; $i<count($array[0]); $i++)
            <th scope="col">
                <select class="form-select data-table-dropbox" name="{{$i}}">
                  <option value="select" selected>Select</option> 
                  @foreach($attribArray as $item)
                  <option value="{{strtolower($item)}}">{{ucfirst($item)}}</option>
                  @endforeach
                  <option value="email">Email</option>
                </select> 
            </th>
        @endfor
      </tr>
    </thead>
    <tbody>
      @foreach ($array as $item)
        <tr>
          @foreach ($item as $value)
            <td>
                @php
                  $results = print_r($value, true);
                  echo $results;
                @endphp
            </td>                
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</section>
</form>
<script>
  function sanitize(){
    var menues = document.getElementsByClassName("data-table-dropbox");
    for (var i=0; i<menues.length; i++){
      if(menues[i].options[menues[i].selectedIndex].value=="select"){
        menues[i].removeAttribute("name");
      }
    }
  }
</script>

@include('layouts.users.footer')