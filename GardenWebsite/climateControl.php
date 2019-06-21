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
        <title>Climate Control</title>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
        <link rel="icon" type="image/png" href="images/logoIcon.ico">    
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
                <img id="flowerImg" src="images/logo_no_text.png" alt="logo">
                <div id="backImgAct">
                </div>
            </div>
            <nav class="navBar">
                <ul class="navList" style="color:white">
                    <li class="leftItem"></li>
                    <li class="leftItem"></li>
                    <li class="leftItem"></li>
                    <li class="leftItem"></li>
                </ul> 
            </nav>
            <nav class="rightBar">
                <ul class="navList" style="color:white">
                    <li class="rightItem"></li>
                    <li class="rightItem"></li>
                    <li class="rightItem"></li>
                    <li class="rightItem"></li>
                </ul> 
            </nav>
            <div id="buttonContainer">
                <div class="buttonSplit">
                    <input class="rangeSlider" id="maxSlider" type="range" min="0" max="50" value="25">
                    <button class="actButton" id="maxTempButton" type="button" onclick="setMaxTemp()">Set Max Temp</button>
                    <p class="rangeSlideResponse" id="maxTempSlideResponse"></p></span></p>
                </div>
                <div class="buttonSplit">
                </div>
                <div class="buttonSplit">
                    <input class="rangeSlider" id="minSlider" type="range" min="0" max="50" value="15">
                    <button class="actButton" id="minTempButton" type="button" onclick="setMinTemp()">Set Min Temp</button>
                    <p class="rangeSlideResponse" id="minTempSlideResponse"></span></p>
                </div>
            </div>
            <div id="iconContainer">
                <div class="iconSplit">
                    <p class="rangeSlideText" id="maxTempSlideText"><span id="maxRangeSpan"></span></p>
                </div>
                <div class="iconSplit">
                    
                </div>
                <div class="iconSplit">
                    <p class="rangeSlideText" id="minTempSlideText"><span id="minRangeSpan"></span></p>
                </div>
            </div>

       </div>    
       <script type="text/javascript" src="js/js.js"></script>           
    </body>
</html>