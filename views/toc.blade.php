@extends("layout")

@section("content")

    <form class="ins-form" action="./tocInsExe" method="post">
        <label for="ins-sort">sort:</label>
        <input type="text" class="inputText form-control" name="sort" id="ins-sort">
        <label for="ins-tocId">tocId:</label>
        <input type="text" class="inputText form-control" name="tocId" id="ins-tocId">
        <label for="ins-title">title:</label>
        <input type="text" class="inputText form-control" name="title" id="ins-title">
        <input class="btn btn-light mt-2" type='submit' value='insert'>
    </form>

<div class="my-2">

  @foreach($rows as $row)

  
  <div class="bg-white p-2 rounded mb-2 d-flex justify-content-between">
      <span>
        <span class="ms-2">
            id: {{$row["id"]}}
        </span>

        <span class="ms-2">
            sort: {{$row["sort"]}}
        </span>
        <span class="ms-2">
            <a href='./cat/{{$row["tocId"]}}'>{{$row["title"]}}</a>
        </span>


 
          @foreach($row["cats"] as $row)

            <span class="ms-2">
                <a class="d-inline text-decoration-none px-2 py-1 data-item-b" href='./datas/{{$row["id"]}}'>{{$row["title"]}}</a>
            </span>

          @endforeach
      </span>

      <span>

        <span class="mx-2">
            <a href='./tocUpd/{{$row["id"]}}'>update</a>
        </span>
        <span class="mx-2">
            <a class="" href='./tocDel/{{$row["id"]}}'>delete</a>
        </span>

      </span>

  </div>
  

  @endforeach

</div>

      <!--
  <div class="bg-white p-2 rounded me-2 mb-2 d-flex justify-content-between">

    {{$row["title"]}}
    {{$row["id"]}}
    {{$row["tocId"]}}
    {{$row["title"]}}
      -->

      <!--

      -->

@endsection
