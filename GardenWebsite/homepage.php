<!DOCTYPE html>
<?php
	session_start();;
?>
<html>
    <?php
        $tempDateArr = array();
        $tempRows = 0;
        $humiDateArr = array();
        $humiRows = 0;
        $luxDateArr = array();
        $luxRows = 0;
        $soilDateArr = array();
        $soilRows = 0;
        $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
        $db_serverUname = "Homer";                 //default username for MySQL
        $db_serverPwd = "Baron";                     //default password for MySQL
        $database = "gardenprojectdb";
        $i=0;
        
        $conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database
        if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
        {
            print("Error connecting to MySQL database" . mysqli_connect_error($conn));
        } 
        else
        {
            $stmt = ( "SELECT DISTINCT date FROM `airData` WHERE 1"); //Prepare an SQL statement
            if ($result = mysqli_query($conn, $stmt)) 
            {
                $tempRows = mysqli_num_rows($result);
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    $tempDateArr[$i]=$row["date"];
                    $i=$i+1;
                }
                $i=0;
            }	
            else
            {
            }
            $stmt = ( "SELECT DISTINCT date FROM `lux` WHERE 1"); //Prepare an SQL statement
            if ($result = mysqli_query($conn, $stmt)) {
                $luxRows = mysqli_num_rows($result);
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    $luxDateArr[$i]=$row["date"];
                    $i=$i+1;
                }
                $i=0;
            }	
            else
            {
            }
            $stmt = ( "SELECT DISTINCT date FROM `soilhumi` WHERE 1"); //Prepare an SQL statement
            if ($result = mysqli_query($conn, $stmt)) {
                $soilRows = mysqli_num_rows($result);
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    $soilDateArr[$i]=$row["date"];
                    $i=$i+1;
                }
                $i=0;
            }	
            else
            {
            }
            mysqli_close($conn);
        }  
    ?>
    <head>
        <title>Data logger</title>
        <meta charset="UTF-8"> 
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="icon" type="image/png" href="images/logoIcon.ico">
        
        <!--make website responsive for viewing on all devices-->
        <link rel="stylesheet" type="text/css" href="css/responsive.css" />
        
        <!--favicon image for title bar-->
        <link rel="shortcut icon" alt="project eden logo" href="" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
        <script type="text/javascript" src="js/js.js"></script> 
        <script>
            $( function() 
            {
                $( "#datepickerTemp" ).datepicker({ dateFormat: 'yy-mm-dd', showButtonPanel: true, changeMonth: true, changeYear: true });
            } );
            $( function() {
                $( "#datepickerHumi" ).datepicker({ dateFormat: 'yy-mm-dd', showButtonPanel: true, changeMonth: true, changeYear: true });
            } );
            $( function() {
                $( "#datepickerSoil" ).datepicker({ dateFormat: 'yy-mm-dd', showButtonPanel: true, changeMonth: true, changeYear: true });
            } );
            $( function() {
                $( "#datepickerLux" ).datepicker({ dateFormat: 'yy-mm-dd', showButtonPanel: true, changeMonth: true, changeYear: true });
            } );
        </script>
    </head>
    
    <body id="homeBody">
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
        <div id="fadeDiv">
        </div>
        <div id="banner">
            <img id="sunImg" src="images/logo.png" alt="sunBanner">
            <div id="backImg">
            </div>
        </div>
        <div id="calContainer">
            <div class="calendar" id="calLeft">
                <form action="airTempChart.php" method="get">
                    <input class="calBox" type="text" value="Click here to select date" id="datepickerTemp" name="airTempDate" readonly>
                    <input class="selectButton" type="submit" value="Air Temperature!" onclick="return testAirData()">
                </form>
                <p id="airError" class="errorText"></p>
                <img class="icon" alt="icon" src="images/thermom.png">
            </div>
            <div class="calendar" id="calCenter1">
                <form action="airHumiChart.php" method="get">
                    <input class="calBox" type="text" value="Click here to select date" id="datepickerHumi" name="airHumiDate" readonly>
                    <input class="selectButton" type="submit" value="Air Humidity!" onclick="return testHumiData()">
                </form>
                <p id="humiError" class="errorText"></p>
                <img class="icon" alt="icon" src="images/drop.png">
            </div>
            <div class="calendar" id="calCenter2">
                <form action="soilHumiChart.php" method="get">
                    <input class="calBox" type="text" value="Click here to select date" id="datepickerSoil" name="soilHumiDate" readonly>
                    <input class="selectButton" type="submit" value="Soil Humidity!" onclick="return testSoilData()">
                </form>
                <p id="soilError" class="errorText"></p>
                <img class="icon" alt="icon" src="images/moist.png">
            </div>
            <div class="calendar" id="calRight">
                <form action="luxChart.php" method="get">
                    <input class="calBox" type="text" value="Click here to select date" id="datepickerLux" name="luxDate" readonly>
                    <input class="selectButton" type="submit" value="Light Value!" onclick="return testLuxData()">
                </form>
                <p id="luxError" class="errorText"></p>
                <img class="icon" alt="icon" src="images/sun2.png">    
            </div>    
        </div>
        <noscript>
            <div>
                <span style="color:red;">You will not be able to select a date, if you do not enable Javascript!!</span>
            </div>
        </noscript>
        <div id="spriteDiv">
            <img id="spriteflower" alt="flower" src="images/flower.svg">            
        </div>
        <script>
            function testAirData()
            {
                var jConvTempArray = <?php echo json_encode($tempDateArr); ?>;
                var tempRows= <?php echo json_encode($tempRows); ?>;
                var selectedDate = document.getElementsByName("airTempDate")[0].value;
                var i=0;
                for(i=0; i<tempRows; i++)
                {
                    if(selectedDate == jConvTempArray[i])
                    {
                        return true;
                    }
                }
                document.getElementById("airError").style.visibility = "visible";
                if(selectedDate != "Click here to select date")
                {
                    document.getElementById("airError").innerHTML = "No data for: " + selectedDate;
                }
                else
                {
                    document.getElementById("airError").innerHTML = "No date selected";
                }
                return false;
            }
            function testHumiData()
            {
                var jConvTempArray = <?php echo json_encode($tempDateArr); ?>;
                var tempRows= <?php echo json_encode($tempRows); ?>;
                var selectedDate = document.getElementsByName("airHumiDate")[0].value;
                var i=0;
                for(i=0; i<tempRows; i++)
                {
                    if(selectedDate == jConvTempArray[i])
                    {
                        return true;
                    }
                }
                document.getElementById("humiError").style.visibility = "visible";
                if(selectedDate != "Click here to select date")
                {
                    document.getElementById("humiError").innerHTML = "No data for: " + selectedDate;
                }
                else
                {
                    document.getElementById("humiError").innerHTML = "No date selected";
                }
                return false;
            }
            function testSoilData()
            {
                var jConvSoilArray = <?php echo json_encode($soilDateArr); ?>;
                var soilRows= <?php echo json_encode($soilRows); ?>;
                var selectedDate = document.getElementsByName("soilHumiDate")[0].value;
                var i=0;
                for(i=0; i<soilRows; i++)
                {
                    if(selectedDate == jConvSoilArray[i])
                    {
                        return true;
                    }
                }
                document.getElementById("soilError").style.visibility = "visible";
                if(selectedDate != "Click here to select date")
                {
                    document.getElementById("soilError").innerHTML = "No data for: " + selectedDate;
                }
                else
                {
                    document.getElementById("soilError").innerHTML = "No date selected";
                }
                return false;
            }       
            function testLuxData()
            {
                var jConvLuxArray = <?php echo json_encode($luxDateArr); ?>;
                var luxRows= <?php echo json_encode($luxRows); ?>;
                var selectedDate = document.getElementsByName("luxDate")[0].value;
                var i=0;
                for(i=0; i<luxRows; i++)
                {
                    if(selectedDate == jConvLuxArray[i])
                    {
                        return true;
                    }
                }
                document.getElementById("luxError").style.visibility = "visible";
                if(selectedDate != "Click here to select date")
                {
                    document.getElementById("luxError").innerHTML = "No data for: " + selectedDate;
                }
                else
                {
                    document.getElementById("luxError").innerHTML = "No date selected";
                }
                return false;
            }   
        </script>
    </body>
    
</html>