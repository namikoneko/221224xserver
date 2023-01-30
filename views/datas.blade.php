@extends("layout")

@section("content")

<p class="mb-0">
tocId:
    {{$catrow["tocId"]}}
<div class="bg-white px-2 rounded align-middle d-flex justify-content-between">
<h3 class="m-1">
        <span class=""><a class="text-decoration-none" href='../datas/{{$catrow["id"]}}'>{{$catrow["title"]}}</a></span>
</h3>
    <div>
        <span class="px-2 mt-2 inline-block"><a href='../catUpd/{{$catrow["id"]}}'>update</a></span>
        <span class="px-2 mt-2 inline-block"><a href='../catDel/{{$catrow["id"]}}'>delete</a></span>
    </div>
</div>

</p>

<form class="ins-form" action="../dataInsExe" method="post">
    <input type="hidden" class="inputText" name="catId" value='{{$catrow["id"]}}'>

<div class="row">

<div class="col">
    <label for="ins-tag">tag:</label>
    <input type="text" class="inputText form-control" name="tag" id="ins-tag">
</div>
<div class="col">
    <label for="ins-inTag">inTag:</label>
    <input type="text" class="inputText form-control" name="inTag" id="ins-inTag">
</div>

</div>

    <textarea class="myTextarea form-control mt-2 data-textarea" name='text'></textarea>
    <input class="btn btn-light mt-2" type='submit' value='insert'>
</form>

<div class="d-flex flex-wrap">

<div>リンク先：</div>

  @foreach($linkToRows as $row)
        <div class="bg-white mt-2 mx-2 px-3 py-2 rounded data-record d-flex">

            <span class="text-black-50 me-2">id:{{$row["id"]}}</span><br>
            <span class="text-black-50">title: </span><a href='/221224/datas/{{$row["id"]}}'>{{$row["title"]}}</a><br>
        </div>

  @endforeach
</div>

<hr>


<div class="d-flex flex-wrap">

<span>被リンク：</span>

  @foreach($linkedRows as $row)
        <div class="bg-white mt-2 mx-2 px-3 py-2 rounded data-record d-flex">

            <span class="text-black-50 me-2">id:{{$row["id"]}}</span><br>
            <span class="text-black-50">title: </span><a href='/221224/datas/{{$row["id"]}}'>{{$row["title"]}}</a><br>
        </div>

  @endforeach

</div>


<hr>
<span>内タグ：</span>

  @foreach($inTags as $inTag)

            <span class="text-black-50"></span><a href='/221224/datas/{{$catrow["id"]}}?inTag={{$inTag}}'>{{$inTag}}</a><br>

  @endforeach

  @foreach($rows as $row)
  
  <div class="bg-white mt-2 px-3 py-2 rounded data-record">
    <span class="text-black-50">
        <a href='/221224/dataOne/{{$row["id"]}}'>id: {{$row["id"]}}</a>
    </span>
    <span class="text-black-50 mx-2">date: {{$row["date"]}}</span>
    <span class="text-black-50">tag: {{$row["tag"]}}</span>
    <span class="text-black-50">sort: {{$row["sort"]}}</span>
    <span class="text-black-50">inTag: {{$row["inTag"]}}</span>



    {!!$row["text"]!!}
    <a href='/221224/dataUpd/{{$row["id"]}}'>update</a>
    <a href='/221224/dataDel/{{$row["id"]}}'>delete</a>
    <a class="d-inline text-decoration-none px-2 py-1 ms-2 rounded data-item-a border border-primary" href='/221224/dataUp/{{$row["id"]}}'>up</a>
  </div>
    <!--
    <a href='./datas/{{$row["catnum"]}}'>{{$row["title"]}}</a>
    <br>
    {!!$rows[0]["text"]!!}

    -->
  
  @endforeach

<div class="my-2">
  <a class="btn btn-light" href='./{{$catrow["id"]}}?page={{$page - 1}}'>前へ</a>
  <a class="btn btn-light" href='./{{$catrow["id"]}}?page={{$page + 1}}'>次へ</a>
  <a class="btn btn-light" href='./{{$catrow["id"]}}?page=0'>全表示へ</a>
</div>

@endsection
