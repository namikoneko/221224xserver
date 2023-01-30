@extends("layout")

@section("content")

    <div class="bg-white mt-2 px-2 py-2 rounded">
        <h4 class="m-0">{{$y}}年{{$m}}月{{$word}}</h4>
    </div>


    <form class="ins-form" action="./findDateText" method="get">
        <label for="find-text">find:</label>
        <input type="text" class="inputText form-control" name="word" id="find-text">
        <input class="btn btn-light mt-2" type='submit' value='find'>
    </form>


  @foreach($rows as $row)

      <div class="bg-white mt-2 px-2 py-2 rounded">
        <span class="text-black-50 mx-2">id: {{$row["id"]}}</span>
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


        <span class="text-black-50 mx-2"><a href='/221224/dateUpd/{{$row["id"]}}?y={{$y}}&m={{$m}}'>update</a></span>
        {!!$row["text"]!!}
        
      </div>

  @endforeach

<div class="my-2">
  <a class="btn btn-light" href='?y={{$previousYM[0]}}&m={{$previousYM[1]}}'>前月</a>
  <a class="btn btn-light" href='./dates'>今月</a>
  <a class="btn btn-light" href='?y={{$nextYM[0]}}&m={{$nextYM[1]}}'>次月</a>

</div>

    <!--

        <span class="text-black-50 mx-2"><a href='/221224/dateDel/{{$row["id"]}}'>delete</a></span>

  <a class="btn btn-light" href='./{{$catrow["id"]}}?page={{$page + 1}}'>次へ</a>
  <a class="btn btn-light" href='./{{$catrow["id"]}}?page=0'>全表示へ</a>

    -->

@endsection
