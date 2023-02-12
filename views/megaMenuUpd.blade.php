@extends("layout")

@section("content")

        <form class="upd-form" action='/221224/megaMenuUpdExe' method='post'>
            <input type='hidden' name='id' value={{$row["id"]}}>
	    <!--

            <p>
                <label for="sort">sort:</label>
                <input type='text' name='sort' value={{$row["sort"]}} id="sort" class="form-control">
            </p>
	    -->
<h5 class="mb-0">css
</h5>

      <textarea class="myTextarea form-control vh-50 mt-0 date-textarea-upd" name='css'>{{$row["css"]}}</textarea>

<h5 class="mb-0 mt-2">html
</h5>

      <textarea class="myTextarea form-control vh-50 mt-0 date-textarea-upd" name='html'>{{$row["html"]}}</textarea>

                <input class="btn btn-light mb-2 mt-2" type='submit' value='send'>
        </form>

@endsection
