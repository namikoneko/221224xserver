@extends("layout")

@section("content")

        <form class="upd-form" action='/221224/tocUpdExe' method='post'>
            <input type='hidden' name='id' value={{$row["id"]}}>
	    <!--
	    -->
            <p>
                <label for="sort">sort:</label>
                <input type='text' name='sort' value={{$row["sort"]}} id="sort" class="form-control">
            </p>
            <p>
                <label for="tocId">tocId:</label>
                <input type='text' name='tocId' value={{$row["tocId"]}} id="tocId" class="form-control">
            </p>
            <p>
                <label for="title">title:</label>
                <input type='text' name='title' value={{$row["title"]}} id="title" class="form-control">
            </p>
            <p>
                <input class="btn btn-light mb-2" type='submit' value='send'>
        </form>

@endsection
