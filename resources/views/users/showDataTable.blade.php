@include('layouts.users.header')
@error('parameterError')
<div class="mt-5 error-notification">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  {{ $message }}
</div>
@enderror
<form action="{{url('/set-data').'/'.$id}}" method="POST">
  @csrf
<div class="data-table-div">
  <h3 class="data-table-heading">
      Set attributes on the data
  </h3>
  <input type="submit" class="btn btn-outline-primary" value="Embade Columns" onclick="sanitize()">
</div>
<section class="w-100 text-center table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        @for($i=0; $i<count(json_decode($datasrc)[0]); $i++)
            <th scope="col">
                <select class="form-select data-table-dropbox" name="{{$i}}">
                  @if(isset($dataFileAttribs) && !in_array($i, array_keys($dataFileAttribs)))
                  <option value="select" selected>Select</option> 
                  @else
                  <option value="select">Select</option> 
                  @endif
                  @foreach($attribArray as $item)                  
                  @if(isset($dataFileAttribs) && in_array($i, array_keys($dataFileAttribs)) && $item==$dataFileAttribs[$i])
                  <option value="{{strtolower($item)}}" selected>{{ucfirst($item)}}</option>
                  @else
                  <option value="{{strtolower($item)}}">{{ucfirst($item)}}</option>
                  @endif
                  @endforeach
                  @if(isset($dataFileAttribs) && $i==array_search('email', $dataFileAttribs))
                  <option value="email" selected>Email</option>
                  @else
                  <option value="email">Email</option>
                  @endif
                </select> 
            </th>
        @endfor
      </tr>
    </thead>
    <tbody>
      @foreach (json_decode($datasrc) as $item)
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