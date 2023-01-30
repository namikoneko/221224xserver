@extends("layout")

@section("content")

<a class="btn btn-light" href='/221224/cats'>catへ</a>
<a class="btn btn-light" href='/221224/datas/{{$row["catId"]}}'>catId
{{$row["catId"]}}へ</a>

    <form class="ins-form" action='../dataUpdExe' method='post'>
      <input type='hidden' name='id' value='{{$row["id"]}}'>

<div class="row">

<div class="col">
      <label for="ins-catId">catId:</label>
      <input type="text" class="inputText form-control" name="catId" id="ins-catId" value='{{$row["catId"]}}'>
</div>

<div class="col">
      <label for="ins-sort">sort:</label>
      <input type="text" class="inputText form-control" name="sort" id="ins-sort" value='{{$row["sort"]}}'>
</div>

<div class="col">
      <label for="ins-tag">tag:</label>
      <input type="text" class="inputText form-control" name="tag" id="ins-tag" value='{{$row["tag"]}}'>
</div>

<div class="col">
      <label for="ins-inTag">inTag:</label>
      <input type="text" class="inputText form-control" name="inTag" id="ins-inTag" value='{{$row["inTag"]}}'>
</div>

</div>

      <textarea class="myTextarea form-control vh-50 mt-3 data-textarea-upd" name='text'>{{$row["text"]}}</textarea>
      <input class="btn btn-light mt-2" type='submit' value='send'>
    </form>



@endsection
