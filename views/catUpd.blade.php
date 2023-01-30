@extends("layout")

@section("content")

        <form class="upd-form" action='/221224/catUpdExe' method='post'>
            <input type='hidden' name='id' value='{{$row["id"]}}'>
	    <!--
            <p>
                <label for="sort">sort:</label>
                <input type='text' name='sort' value={$row.sort} id="sort">

                <input type='text' name='tocId' value={{$row['tocId']}}  class="form-control" id="tocId">
        </p>
	    -->
            <p>
                <label for="tocId">tocId:</label>
                <input type='text' name='tocId' value='{{$row["tocId"]}}' id="tocId" class="form-control">
            </p>

           <p>
                <label for="title">title:</label>
                <input type='text' name='title' value='{{$row["title"]}}' id="title" class="form-control">
            </p>

                <input class="btn btn-light mb-2" type='submit' value='send'>
        </form>

<hr>
        <form class="upd-form" action='/221224/catLinkAddDel' method='post'>
            <input type='hidden' name='id' value='{{$row["id"]}}'>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="addOrDel" id="flexRadioDefault1" value="1" checked>
              <label class="form-check-label" for="flexRadioDefault1">
                add
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="addOrDel" id="flexRadioDefault2" value="2">
              <label class="form-check-label" for="flexRadioDefault2">
                delete
              </label>
            </div>
            <p>
                <label for="linkAddDel">linkAddDel:</label>
                <input type='text' name='linkAddDel' id="linkAddDel" class="form-control">
            </p>

            <p>
                linkTo: {{$row["linkTo"]}}
            </p>

            <p>
                linked: {{$row["linked"]}}
            </p>

                <input class="btn btn-light mb-2" type='submit' value='send'>

        </form>

 


@endsection
