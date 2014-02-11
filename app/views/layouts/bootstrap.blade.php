<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cataclysm Items</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">

    <link href="/css/cataclysm.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="terminal">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Cataclysm DDA</a>
        </div>
        <div class="collapse navbar-collapse">
          <form class="navbar-form navbar-right" role="form" action="<?= action("ItemsController@search") ?>" >
            <a href="http://cdda.estilofusion.com<?= $_SERVER["REQUEST_URI"] ?>">[stable]</a>
            <a href="http://cdda-trunk.estilofusion.com<?= $_SERVER["REQUEST_URI"] ?>">[trunk]</a>

            <div class="form-group">
              <input name="q" type="text" placeholder="Search..." class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Go</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
@yield('content')

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- cataclysm -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-2695962190082245"
     data-ad-slot="9012422814"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
