<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION["login"]))
    {
        $_SESSION['error']="You need to be logged in to access that resource"; 
        header('Location:login.php');
    }
?>
<html>
    <head>
        <title>Camera Control</title>
        <link rel="icon" type="image/png" href="images/logoIcon.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">     
    </head>
    <body id="activateBody" style="background-color:rgb(72, 73, 79)">
       <div>
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeChartNav()">&times;</a>
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
            <div id="main" style="margin-left:10%;">
                <span style="font-size:3vw;cursor:pointer; color:white;" onclick="openChartNav()">&#9776; PROJECT EDEN</span>
            </div>
            <div id="fadeDiv">
            </div>
            <div id="bannerAct">
                <div id="backImgAct">
                </div>
                <div id="backImgActAnim">
                </div>
                <div id="backImgActShadow">
                </div>
                <div id="backImgActDarken">
                </div>
                <div id="lightAnim">
                </div>
            </div>
            <nav class="navBar">
                <ul class="navList" style="color:white">
                    <li class="leftItem"></li>
                    <li class="leftItem"></li>
                    <li class="leftItem"><button class="actButton" id="servoUpButton" style="margin:auto" type="button" onclick="moveServoUp()">Move Camera Up</button>
                        <p class="actTextOut" id="moveServoUpPara">Test Me</p> 
                    </li>
                    <li class="leftItem"></li>
                </ul> 
            </nav>
            <nav class="rightBar">
                <ul class="navList" style="color:white">
                    <li class="rightItem"></li>
                    <li class="rightItem"></li>
                    <li class="rightItem"><button class="actButton" id="servoDownButton" style="margin:auto" type="button" onclick="moveServoDown()">Move Camera Down</button>
                        <p class="actTextOut" id="moveServoDownPara"></p>
                    </li>
                    <li class="rightItem"></li>
                </ul> 
            </nav>
            <div id="cameraDiv">
                <img id="camFrame" src="http://192.168.0.221:8082/">
                </img>				
            </div>
			
            <div id="camIconContainer">
                <div class="camIconSplit">

                </div>
				<div class="camIconSplit">

                </div>
            </div>

       </div>    
       <script type="text/javascript" src="js/js.js"></script>           
    </body>
</html>
