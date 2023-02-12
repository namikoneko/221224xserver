@extends("layout")

@section("content")

        <form class="upd-form" action='/221224/megaMenuTitleUpdExe' method='post'>
            <input type='hidden' name='id' value='{{$row["id"]}}'>
	    <!--
	    -->

           <p>
                <label for="title">title:</label>
                <input type='text' name='title' value='{{$row["title"]}}' id="title" class="form-control">
            </p>

                <input class="btn btn-light mb-2" type='submit' value='send'>
        </form>

@endsection
