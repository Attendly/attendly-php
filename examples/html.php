<?php

function head() {

	return <<<EOD
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>API example</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
	  <div class="row">
		<br>
      <div class="jumbotron">
        <h1>Attendly examples</h1>
        <p>These examples are running on the Attendly server.</p>
        <p>
			<div class="btn-group" role="group" aria-label="...">
			  <a class="btn btn-default" target="_blank" href="https://attendly.me" role="button">Login to Attendly</a>

			  <div class="btn-group" role="group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				  API action
				  <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
				  <li><a href="eventlistactive.php">Event list</a></li>
				  <li><a href="eventlistgroup.php">Event list by group</a></li>
				  <li><a href="eventget.php">Event get</a></li>
				  <li><a href="eventtickets.php">Event tickets</a></li>
				  <li><a href="eventteams.php">Event teams</a></li>
				  <li><a href="eventupdate.php">Event update</a></li>
				  <li><a href="grouplistactive.php">Groups list</a></li>
				  <li><a href="groupget.php">Group get</a></li>
				  <li><a href="groupupdate.php">Group update</a></li>
				</ul>
			  </div>
			</div>
        </p>
      </div>
     </div>

	<div class="row">
EOD;

}

function footer(){

return <<<EOD
	</div>
    </div> <!-- /container -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.5/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.5/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
  </body>
</html>
EOD;
}
