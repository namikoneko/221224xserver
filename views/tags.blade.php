@extends("layout")

@section("content")

<div class="d-flex flex-wrap my-2">

  @foreach($tags as $tag)


  <div class="bg-white m-2 px-3 py-2 rounded data-record">
    <span class="text-black-50 me-2">
        <a class="d-inline text-decoration-none px-3 py-2 border border-primary" href='./tag?word={{$tag}}'>{{$tag}}</a>
    </span>

  </div>


    <!--
    <span class="text-black-50">id: {{$row["id"]}}</span>

    <a href='./datas/{{$row["catnum"]}}'>{{$row["title"]}}</a>
    <br>
    {!!$rows[0]["text"]!!}

    -->
  
  @endforeach

</div>



@endsection
