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
        <title>Activate Devices</title>
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
                <img id="flowerImg" src="images/logo_no_text.png" alt="logo">
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
                    <button class="actButton" id="lightOnButton" type="button" onmouseover="actLightIconMOver()" onmouseout="actLightIconMOut()" onclick="activateLights()">Activate Lights</button>
                    <p class="actTextOut" id="actLightPara"></p>
                </div>
                <div class="buttonSplit">
                    <button class="actButton" id="lightOffButton" type="button" onmouseover="deactLightIconMOver()" onmouseout="deactLightIconMOut()" onclick="deactivateLights()">Deactivate Lights</button>
                    <p class="actTextOut" id="deactLightPara"></p>
                </div>
                <div class="buttonSplit">
                    <button class="actButton" id="pumpOnButton" type="button" onmouseover="actPumpIconMOver()" onmouseout="actPumpIconMOut()" onclick="activatePump();">Activate Pump</button>
                    <p class="actTextOut" id="actPumpPara"></p>
                </div>
            </div>
            <div id="iconContainer">
                <div class="iconSplit">
                    <img class="icon" id="actLightIcon" alt="icon" src="images/sun3.png"> 
                </div>
                <div class="iconSplit">
                    <img class="icon" id="deactLightIcon" alt="icon" src="images/moon.png">
                </div>
                <div class="iconSplit">
                    <img class="icon" id="actPumpIcon" alt="icon" src="images/rain.png">
                </div>
            </div>

       </div>    
       <script type="text/javascript" src="js/js.js"></script>           
    </body>
</html>