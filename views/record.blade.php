@extends("layout")

@section("content")

    <div class="bg-white mt-2 px-2 py-2 rounded d-flex justify-content-between">
        id: {{$recoCatRow["id"]}}
        {{$recoCatRow["title"]}}

    </div>


  @foreach($rows as $row)

      <div class="bg-white mt-2 px-2 py-2 rounded">
        <span class="text-black-50 mx-2">{{$row["date"]}}
@if($row["week"] == 0)
（日）
@elseif($row["week"] == 1)
（月）
@elseif($row["week"] == 2)
（火）
@elseif($row["week"] == 3)
（水）
@elseif($row["week"] == 4)
（木）
@elseif($row["week"] == 5)
（金）
@else
（土）
@endif

@if($row["holiday"] == 1)
（祝）
@endif
</span>
        <span class="text-black-50 mx-2">id: {{$row["recoId"]}}</span>
        <span class="text-black-50 mx-2">min: {{$row["min"]}}</span>

<!--
        <span class="text-black-50 mx-2">{{$row["title"]}}</span>
-->


        <span class="text-black-50 mx-2"><a href='/221224/recoUpd/{{$row["recoId"]}}?y={{$y}}&m={{$m}}'>update</a></span>
        {!!$row["text"]!!}
        
      </div>


  @endforeach

<div class="my-2">
  <a class="btn btn-light" href='?recoCatId={{$recoCatRow["id"]}}&y={{$previousYM[0]}}&m={{$previousYM[1]}}'>前月</a>
  <a class="btn btn-light" href='./dates'>今月</a>
  <a class="btn btn-light" href='?recoCatId={{$recoCatRow["id"]}}&y={{$nextYM[0]}}&m={{$nextYM[1]}}'>次月</a>

</div>

@endsection
