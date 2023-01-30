@extends("layout")

@section("content")

    <form class="ins-form" action="./recoCatInsExe" method="post">

<div class="row">

    <div class="col">

            <label for="ins-title">title:</label>
            <input type="text" class="inputText form-control" name="title" id="ins-title">
    </div>

    <div class="col">

            <label for="ins-sort">sort:</label>
            <input type="text" class="inputText form-control" name="sort" id="ins-sort">
    </div>

</div>

        <input class="btn btn-light mt-2" type='submit' value='insert'>
    </form>

  @foreach($rows as $row)

    <div class="bg-white p-2 rounded me-2 my-2 d-flex justify-content-between">

        <div>
            
            <span class="text-black-50">id: {{$row["id"]}}</span>
            <span class="text-black-50">sort: {{$row["sort"]}}</span>

            <a class="d-inline text-decoration-none px-2 py-1" href='./records?recoCatId={{$row["id"]}}'>{{$row["title"]}}</a>
        </div>

        <div>
            <span class="text-black-50 mx-2"><a href='/221224/recoCatUpd/{{$row["id"]}}'>update</a></span>
<!--
-->
        </div>

    </div>

  @endforeach


@endsection
