<!doctype html>
<html>
<head>
  <link rel="icon" href="/libs/221211icon.svg" type="image/svg+xml">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/libs/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/221224/views/style.css">


</head>
<body>
<div class="container gray-300">
<div id="app">

<p>
@include("header")
</p>

@yield("content")

<p>
footer
</p>

</div>
</div>

  <script src="/libs/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="/libs/vue.js"></script>
  <script src="/221224/script.js"></script>

</body>
</html>
