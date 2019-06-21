<!DOCTYPE html>
<?php
	session_start();;
?>
<html>
	<head>
		<title>Project Eden -  </title>
		<meta charset="UTF-8"> 
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link rel="icon" type="image/png" href="images/logoIcon.ico">
		
		<!--make website responsive for viewing on all devices-->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="css/responsive.css" />
		
		<!--favicon image for title bar-->
		<link rel="shortcut icon" alt="project eden logo" href="" type="image/x-icon" />
		
		<!--style for background image-->
		<style>
			body {
				font-family: "Lato", sans-serif;
				transition: background-color .5s;
			}
			.sidenav {
				height: 100%;
				width: 0;
				position: fixed;
				z-index: 1;
				top: 0;
				left: 0;
				background-color: #111;
				overflow-x: hidden;
				transition: 0.5s;
				padding-top: 60px;
			}

			.sidenav a {
				padding: 8px 8px 8px 10px;
				text-decoration: none;
				font-size: 25px;
				color: #cccccc;
				display: block;
				transition: 0.3s;
			}

			.sidenav a:hover {
				color: #f1f1f1;
			}

			.sidenav .closebtn {
				position: absolute;
				top: 0;
				right: 25px;
				font-size: 36px;
				margin-left: 50px;
			}

			#main {
				transition: margin-left .5s;
				padding: 16px;
			}

			@media only screen and (max-width: 500px) {
					.sidenav {
						width: 0%;
						position: fixed;
						z-index: 1;
						top: 0;
						left: 0;
						background-color: #111;
						overflow-x: hidden;
						transition: 0.5s;
						padding-top:0px;
					}
					
					.sidenav a {
						text-align: center;
						text-decoration: none;
						font-size: 2vw;
						color: #cccccc;
						display: block;
						transition: 0.3s;
						display: inline-block;
						margin:auto;
					}
					
					.sidenav a:hover {
						color: #f1f1f1;
					}
					
					.sidenav .closebtn {
						position: absolute;
						top: 0;
						right: 10%;
						font-size: 2vw;
						margin-left: 0;
					}
					
					#main {
						transition: margin-left .5s;
						z-index: 2;
					}
				}
			
			body {
					/* Location of the image */
					background-image: url(images/1.jpg);
					/* Background image is centered vertically and horizontally at all times */
					background-position: center center;
					
					/* Background image doesn't tile */
					background-repeat: no-repeat;
					
					/* Background image is fixed in the viewport so that it doesn't move when 
						the content's height is greater than the image's height */
					background-attachment: fixed;
					
					/* This is what makes the background image rescale based
						on the container's size */
					background-size: cover;
					
					/* Set a background color that will be displayed
						while the background image is loading */
					background-color: #464646; 
					/* background-blend-mode: darken; */
				}
				/*active page in navbar is green*/
				.active {
					background-color: #818181;
				}
		</style>
		<?php
			$_POST["hash"] = 24;
		?>
	</head>
	<body id="indexBody">

		<div id="mySidenav" class="sidenav">
		  	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		  	<a href="index.php">Home</a>
		  	<a href="homepage.php">Select Data</a>
		  	<a href="activate.php">Activate Devices</a>
			<a href="climateControl.php">Climate Control</a>
			<a href="cameraControl.php">Camera Control</a>
			<?php
				if(!isset($_SESSION["login"]))
				{
					echo '<a href="login.php">Login</a>';
					echo '<a href="register.php">Register</a>';
				}
				else
				{
					echo '<a href="logout.php">Logout</a>';

				}
			?>	
		  	<a href="about.html">About</a>
		</div>

		<div id="main">
		  <span style="font-size:30px;cursor:pointer; color:white;" onclick="openNav()">&#9776; PROJECT EDEN</span>
		</div>

		<script>
			function openNav() {
			if (window.matchMedia("(min-width: 500px)").matches) 
			{
				/* the viewport is at least 400 pixels wide */
				document.getElementById("mySidenav").style.width = "10%";
				document.getElementById("mySidenav").style.height = "100%";
				document.getElementById("main").style.marginLeft = "10%";
				document.getElementById("indexBody").style.backgroundBlendMode = "darken";
				document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
			} else {
				/* the viewport is less than 400 pixels wide */
				document.getElementById("mySidenav").style.width = "100%";
				document.getElementById("mySidenav").style.height = "25%";
				document.getElementById("indexBody").style.backgroundBlendMode = "darken";
				document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
			}
			}
			function closeNav()
			{
				document.getElementById("mySidenav").style.width = "0";
				document.getElementById("main").style.marginLeft= "0";
				document.body.style.backgroundColor = "white";
			}
		</script>
		
	</body>
</html> 
