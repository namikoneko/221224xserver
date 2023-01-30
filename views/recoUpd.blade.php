@extends("layout")

@section("content")

    <div class="bg-white mt-2 px-2 py-2 rounded">
        {{$row["date"]}}
    </div>

        <form class="upd-form" action='/221224/recoUpdExe' method='post'>
            <input type='hidden' name='id' value='{{$row["recoId"]}}'>
            <input type='hidden' name='recoCatId' value='{{$row["recoCatId"]}}'>

            <input type='hidden' name='y' value='{{$y}}'>
            <input type='hidden' name='m' value='{{$m}}'>

	    <!--
	    -->
        <p>
            <label for="min">min:</label>
            <input type='text' name='min' value='{{$row["min"]}}' id="min" class="form-control">
        </p>

        <textarea class="myTextarea form-control vh-50 mt-3 record-textarea-upd" name='text'>{{$row["recoText"]}}</textarea>

                <input class="btn btn-light my-2" type='submit' value='send'>
        </form>


@endsection
