@extends("layout")

@section("content")

        <form class="upd-form" action='/221224/recoCatUpdExe' method='post'>
            <input type='hidden' name='id' value='{{$row["id"]}}'>

           <p>
                <label for="sort">sort:</label>
                <input type='text' name='sort' value='{{$row["sort"]}}' id="sort" class="form-control">
            </p>

           <p>
                <label for="title">title:</label>
                <input type='text' name='title' value='{{$row["title"]}}' id="title" class="form-control">
            </p>

                <input class="btn btn-light mb-2" type='submit' value='send'>
        </form>

            <span class="text-black-50 mx-2"><a href='/221224/recordsInsYearFromLink?recoCatId={{$row["id"]}}'>ins record</a></span>

@endsection
