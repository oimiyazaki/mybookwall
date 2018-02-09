<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="functions.js"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" type="text/css" href="styles1.css"/>
</head>
	<body>
		<header>
			<ul>
				<li class="menu-left"><a class="active" href="http://mybookwall.com">My Library</a></li>
				
				<!-- Display full menu if they are logged in -->
				<?php echo $menu; ?>
				
			</ul>



		</header>
