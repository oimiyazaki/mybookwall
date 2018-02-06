<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="functions.js"></script>
	<link rel="stylesheet" type="text/css" href="styles1.css"/>
	<!-- :::::::::::::::::::::::::::::::: TC S -->
	<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
	<style type="text/css">
		/* The Modal (background) */
		.modal {
		    display: none; /* Hidden by default */
		    position: fixed; /* Stay in place */
		    z-index: 1; /* Sit on top */
		    padding-top: 100px; /* Location of the box */
		    left: 0;
		    top: 0;
		    width: 100%; /* Full width */
		    height: 100%; /* Full height */
		    overflow: auto; /* Enable scroll if needed */
		    background-color: rgb(0,0,0); /* Fallback color */
		    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		}

		/* Modal Content */
		.modal-content {
		    background-color: #fefefe;
		    margin: auto;
		    padding: 20px;
		    border: 1px solid #888;
		    width: 80%;
		}

		/* The Close Button */
		.close {
		    color: #aaaaaa;
		    float: right;
		    font-size: 28px;
		    font-weight: bold;
		}

		.close:hover,
		.close:focus {
		    color: #000;
		    text-decoration: none;
		    cursor: pointer;
		}

		</style>
	<!-- :::::::::::::::::::::::::::::::: TC E -->
</head>
	<body>
		<header>
			<ul>
				<li class="menu-left"><a class="active" href="http://mybookwall.com">My Library</a></li>
				
				<!-- Display full menu if they are logged in -->
				<?php echo $menu; ?>
				
			</ul>



		</header>
