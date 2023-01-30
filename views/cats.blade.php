@extends("layout")

@section("content")

    <button class="btn btn-light" @click='toggleBtn'>show tocId</button>

<div class="row">
  <div class="col">
    <form class="ins-form" action="./catInsExe" method="post">
        <label for="ins-tocId">tocId:</label>
        <input type="text" class="inputText form-control" name="tocId" id="ins-tocId">
        <label for="ins-title">title:</label>
        <input type="text" class="inputText form-control" name="title" id="ins-title">
        <input class="btn btn-light mt-2" type='submit' value='insert'>
    </form>
  </div>
  <div class="col">
    <form class="ins-form" action="./find" method="get">
        <label for="find-text">find:</label>
        <input type="text" class="inputText form-control" name="word" id="find-text">
        <input class="btn btn-light mt-2" type='submit' value='find'>
    </form>
  </div>
  <div class="col">
    <form class="ins-form" action="./tag" method="get">
        <label for="find-tag">tag:</label>
        <input type="text" class="inputText form-control" name="word" id="find-tag">
        <input class="btn btn-light mt-2" type='submit' value='tag'>
    </form>
  </div>
</div>

<div class="d-flex flex-wrap my-2">

  @foreach($rows as $row)
  
  <div class="bg-white p-2 rounded me-2 mb-2">

    <span :class="{'tocIdShow': isTocId}" class="text-black-50">
      tocId: {{$row["tocId"]}}
    </span>

    <a class="d-inline text-decoration-none px-2 py-1 data-item-b" href='./datas/{{$row["id"]}}'>{{$row["title"]}}</a>
    <a class="d-inline text-decoration-none px-2 py-1 ms-1 rounded data-item-a border border-primary" href='./catUp/{{$row["id"]}}'>up</a>
      <!--
      -->
  </div>
  
  @endforeach

</div>



@endsection

