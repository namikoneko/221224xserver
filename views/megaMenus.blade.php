@extends("layout")

@section("content")

    <form class="ins-form" action="./megaMenuInsExe" method="post">
        <label for="ins-title">title:</label>
        <input type="text" class="inputText form-control" name="title" id="ins-title">
        <input class="btn btn-light mt-2" type='submit' value='insert'>
    </form>

<div class="d-flex flex-wrap my-2">

  @foreach($rows as $row)
  
  <div class="bg-white p-2 rounded me-2 mb-2">

    <a class="d-inline text-decoration-none px-2 py-1 data-item-b" href='./megaMenu/{{$row["id"]}}'>{{$row["title"]}}</a>
    <a class="d-inline text-decoration-none px-2 py-1 data-item-b" href='./megaMenuTitleUpd/{{$row["id"]}}'>update</a>

      <!--
      -->
  </div>
  
  @endforeach

</div>

@endsection

