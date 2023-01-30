@extends("layout")

@section("content")

  @foreach($rows as $row)

  <div>
    <span class="ms-2">
        id: {{$row["id"]}}
    </span>

    <span class="ms-2">
        sort: {{$row["sort"]}}
    </span>
    <span class="ms-2">
        <a href='./cat/{{$row["tocId"]}}'>{{$row["title"]}}</a>
    </span>
  </div>

  <div>
 
  @foreach($row["cats"] as $row)

    {{$row["id"]}}
    <a class="d-inline text-decoration-none px-2 py-1 data-item-b" href='./datas/{{$row["id"]}}'>{{$row["title"]}}</a>

  @endforeach

  </div>

  @endforeach

@endsection
