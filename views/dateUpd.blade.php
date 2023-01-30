@extends("layout")

@section("content")

    <div class="bg-white mt-2 px-2 py-2 rounded">
        date: {{$row["date"]}}
    </div>

    <form class="ins-form" action='../dateUpdExe' method='post'>
      <input type='hidden' name='id' value='{{$row["id"]}}'>

      <input type='hidden' name='y' value='{{$y}}'>
      <input type='hidden' name='m' value='{{$m}}'>

      <textarea class="myTextarea form-control vh-50 mt-3 date-textarea-upd" name='text'>{{$row["text"]}}</textarea>
      <input class="btn btn-light mt-2" type='submit' value='send'>
    </form>

@endsection
