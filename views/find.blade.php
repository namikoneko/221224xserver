@extends("layout")

@section("content")




<h3 class="bg-white px-2 rounded align-middle">
    {{$catrow["title"]}}
</h3>

  @foreach($rows as $row)
  
  <div class="bg-white mt-2 px-3 py-2 rounded data-record">
    <span class="text-black-50">
        <a href='/221224/dataOne/{{$row["id"]}}'>id: {{$row["id"]}}</a>
    </span>
    <span class="text-black-50 mx-2">date: {{$row["date"]}}</span>
    <span class="text-black-50">tag: {{$row["tag"]}}</span>
    <span class="text-black-50">sort: {{$row["sort"]}}</span>


    {!!$row["text"]!!}
    <a href='/221224/dataUpd/{{$row["id"]}}'>update</a>
    <a href='/221224/dataDel/{{$row["id"]}}'>delete</a>
    <a class="d-inline text-decoration-none px-2 py-1 ms-2 rounded data-item-a border border-primary" href='/221224/dataUp/{{$row["id"]}}'>up</a>
  </div>
    <!--
    -->
  
  @endforeach


@endsection
