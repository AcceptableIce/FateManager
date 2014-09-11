<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,400italic' rel='stylesheet' type='text/css'>
		<link href="css/main.css" rel="stylesheet" type="text/css">
		@yield('includes')
	</head>
	<body>
		@yield('content')
		<script src="../js/jquery-2.1.0.js"></script>
		<script src="../js/knockout.js"></script>
		@yield('script')
	</body>
</html>
