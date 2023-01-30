@extends("layout")

@section("content")

    <a class="d-inline text-decoration-none px-2 py-1 ms-2 rounded data-item-a border border-primary" href='/221224/datas/{{$row["catId"]}}'>catId:{{$row["catId"]}}</a>

    <div class="bg-white mt-2 px-3 py-2 rounded vh-min-50">

        <div class="text-black-50">id: {{$row["id"]}}</div>
        <div class="text-black-50">date: {{$row["date"]}}</div>
        <div class="text-black-50">tag: {{$row["tag"]}}</div>
    {!!$row["text"]!!}

    </div>

@endsection
