<!DOCTYPE html>
<html>
<head>
	<title>IP Manager</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap&subset=latin-ext" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700&display=swap&subset=latin-ext" rel="stylesheet">

	<style type="text/css">
		body {
			background-color: #ffffff;
		}

        ul {
            list-style: none;
            padding: 0 0 0 5px;
            margin: 0;
        }

		#container {
			background-color: #ffffff;
		}

		#sidebar {
			font-family: 'Raleway', sans-serif;
			background-color: #009688;
			min-height: 100vh;
			padding: 0;
		}

		#side-nav {
			background-color: rgba(255, 255, 255, .1);
			margin: 0;
			padding: 0;
		}

		#side-nav ul {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		#side-nav ul li {
			margin: 0;
			padding: 0;
		}

		#side-nav ul li a {
			background-color: rgba(255, 255, 255, .1);
			color: #ffffff;
			padding: 8px 15px;
			position: relative;
			display: block;
			margin: 0;
			color: rgba(255, 255, 255, .7);
			transition: 100ms ease-in-out all;
		}

		#side-nav ul li a:hover {
			text-decoration: none;
			background-color: rgba(255, 255, 255, .3);
			color: rgba(255, 255, 255, .9);
			padding-left: 20px;
		}

		#side-nav ul li ul {

		}

		#side-nav ul li ul li {

		}

		#side-nav ul li .subnav {
			
		}

		#side-nav ul li .subnav-title {
			color: #ffffff;
			font-weight: bold;
			font-size: 1.2em;
			margin-top: 16px;
			padding: 4px 15px;
			background-color: rgba(255, 255, 255, .2);
			border-bottom: 2px solid rgba(255, 255, 255, .5);
			color: rgba(255, 255, 255, .4);
			border-left: 10px solid rgba(255, 255, 255, .4);
		}

		#title {
			text-align: center;
			padding-top: 20px;
			padding-bottom: 20px;
			color: rgba(255, 255, 255, .6);
		}

		#page {
			min-height: 100vh;
		}

		#page #content {
			background-color: #ffffff;
			margin: 15px;
			padding: 20px 25px;
			box-shadow: 3px 3px 4px 2px rgba(0, 0, 0, .3);
			z-index: 999;
		}

		#page #content h3 {
			font-family: 'Raleway', sans-serif;
			border-bottom: 1px solid rgba(0, 0, 0, .1);
			padding-bottom: 5px;
			color: #555555;
		}

		#sidebar-colors {
			margin: 10px;
		}

		#sidebar-colors a {
			width: 20px;
			height: 20px;
			display: block;
			float: left;
			padding: 5px;
			margin: 5px;
			border: 2px solid rgba(255, 255, 255, .3);
		}

		<?php
			if (isset($_COOKIE['sidebar-color'])) {
				echo "#sidebar { background-color: #" . $_COOKIE['sidebar-color'] . "}";
			}
		?>
	</style>
</head>
<body>
	<div class="container-fluid" id="container">
		<div class="row">
