<!DOCTYPE html>
<?php
	session_start();;
?>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="icon" type="image/png" href="images/logoIcon.ico">
        
        <!--make website responsive for viewing on all devices-->
    <!--  <link rel="stylesheet" type="text/css" href="css/responsive.css" /> -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
        <script type="text/javascript" src="js/js.js"></script>      
    </head>
    <body  style="background-color:#48494f">
        <?php
            $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
            $db_serverUname = "Homer";                 //default username for MySQL
            $db_serverPwd = "Baron";                     //default password for MySQL
            $database = "gardenprojectdb";          //The database
            $soilArr = array();                     //Array to hold the stored ADC values in the database
            $soilConvertedArr = array();            //Array to hold the converted values of the humidity reading
            $soilRows = 0;                          //Will hold the number of rows on a particular date
            $soilDate = "";                         //Stores the date selected by the user
            $soilTime = array();                    //Holds the time for each point on the chart
            $stripHour = array();                   //These three arrays separate the hours
            $stripMin = array();                    //minutes and seconds from the time this is important because of
            $stripSec = array();                    // how the timeofday option works for google charts -- ie as [00,00,00] instead of [00:00:00]
            $i=0;
            $select = "";
        
                $conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database
                if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
                {
                    print("Error connecting to MySQL database" . mysqli_connect_error($conn)); //Note -- Need to change this to a session or cookie
                } 
                else
                {
                    if(isset($_GET["soilHumiDate"])) //Test to make sure the user didn't just enter the url into the browser
                    {
                        $soilDate = checkUserData($_GET["soilHumiDate"]); //Store the entered date as another variable
                        //echo($soilDate);
                        $stmt = ( "SELECT soilHumi FROM `soilhumi` WHERE timestamp BETWEEN '".$soilDate." 00:00:00' AND '".$soilDate." 23:59:59'"); //Prepare an SQL statement
                        if ($result = mysqli_query($conn, $stmt))
                        {
                            $soilRows = mysqli_num_rows($result); //Count the rows returned
                            while ($row = mysqli_fetch_assoc($result)) //This will store each of the soilHumi entries into an array
                            {
                                $soilArr[$i]=$row["soilHumi"];
                                $soilConvertedArr[$i] = convertToPercent($soilArr[$i]); //Convert the Stored ADC resolution value to a percentage
                                $i=$i+1;
                            }
                            $i=0;
                            $select = "soilHumi"; //Artifact variable - remember to remove
                        }
                        $stmt = ( "SELECT time FROM `soilhumi` WHERE timestamp BETWEEN '".$soilDate." 00:00:00' AND '".$soilDate." 23:59:59'"); //Prepare an SQL statement
                        if ($result = mysqli_query($conn, $stmt))
                        {
                            $soilRows = mysqli_num_rows($result); //Store each of the time values into an array
                            while ($row = mysqli_fetch_assoc($result)) //This will store arrays for the time values
                            {
                                $soilTime[$i]=$row["time"];
                                $stripHour[$i] = substr($soilTime[$i], 0, 2); //Store the first two characters into an array
                                $stripMin[$i] = substr($soilTime[$i], 3, -3); //Store the minutes into an array
                                $stripSec[$i] = substr($soilTime[$i], -2); //Store the seconds into an array
                                $i=$i+1;
                            }
                            $i=0;
                            $select = "soilHumi";
                            unset($_GET["soilHumiDate"]);
                        }
                    }
                    else
                    {
                        header('Location: /garden/homepage.php');
                    }
                }
                
                mysqli_close($conn); //close the connection
                //This function checks the input from the form to protect against xss
                function checkUserData($inputData) 
                {
                    $inputData = filter_var($inputData, FILTER_SANITIZE_STRING);
                    $inputData = filter_var($inputData, FILTER_SANITIZE_NUMBER_INT);
                    $inputData = trim($inputData);
                    $inputData = stripslashes($inputData);
                    return $inputData;
                }
                function convertToPercent($humiValue) //This function will convert the humidity into a percentage
                {
                    $output = 0;
                    $output = $humiValue / 772;
                    $output = $output * 100;
                    $output = 100 - $output;
                    return (int)$output;
                }
        ?>
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
            <nav class="navBar">
                    <ul class="navList" style="color:white">
                        <li class="listItem" id="dispData"><?php $dispDate = DateTime::createFromFormat('Y-m-d', $soilDate); echo date_format($dispDate, "d/m/y") ?></li>
                        <li class="listItem" id="dispTime"></li>
                        <li class="listItem" id="dispValues"></li>
                        <li class="listItem"></li>
                    </ul> 
                </nav>
            <div id="chart" style="top:10%;">
                <div id="curve_chart" style="width: 89%; height: 90%"></div> 
            </div>
        </div>
        
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']}); //load the line chart options from google charts
            google.charts.setOnLoadCallback(drawChart);
            var j = 0;
            var jConvSoilArray = <?php echo json_encode($soilConvertedArr); ?>; //These arrays and variables are encoded in jSon
            var jHourArray = <?php echo json_encode($stripHour); ?>;            //They are retrieved from the php variables on this page
            var jMinArray = <?php echo json_encode($stripMin); ?>;
            var jSecArray = <?php echo json_encode($stripSec); ?>;
            var soilRows= <?php echo json_encode($soilRows); ?>;
            var select= <?php echo json_encode($select); ?>;;

            function drawChart() //This function will draw the chart with the data and options supplied
            {
                var data = new google.visualization.DataTable();
                data.addColumn('timeofday', 'Time');
                data.addColumn('number', 'Humidity');
                for (i = 0; i < soilRows; i++) 
                {
                    data.addRow([[parseInt(jHourArray[i]),parseInt(jMinArray[i]),parseInt(jSecArray[i])], jConvSoilArray[i]]);
                }

                var options = 
                {
                    title: 'Soil Humidity',
                    curveType: 'function',

                    lineWidth: '1',
                    theme: 'maximized',
                    backgroundColor: 'transparent',
                    colors:['#54ced4'],
                    pointSize:'2',
                    //chartArea:{left:'10%',top:'10%',width:'100%',height:'80%'},
                    titleTextStyle:
                    {
                        color:'#ffffff'
                    },
                    vAxis: 
                    {
                        minValue:0, maxValue:100,
                        format: '#\'%\'',
                        textStyle:
                        {
                            color:'#ffffff'
                        },
                        titleTextStyle:
                        {
                            color:'#ffffff'
                        },
                        gridlines:
                        {
                            color:'#55717c'
                        }
                    },
                    baselineColor: '#f1f442',
                    hAxis:
                    {
                        gridlines:
                        {
                            color:'#55717c'
                        },
                        titleTextStyle:
                        {
                            color:'#ffffff'
                        },
                        textStyle:
                        {
                            color:'#ffffff'
                        },
                    },
                    legend:
                    {
                        position: 'bottom',
                        textStyle:
                        {
                            color:'#54ced4'
                        }
                    },
                    animation: {"startup": true, duration: 1000,
                    easing: 'in'}
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart')); //set the chart document in javascript

                chart.draw(data, options); //Draw the chart
                window.addEventListener("resize", resizeChart);
                google.visualization.events.addListener(chart, 'select', selectHandler);
                function resizeChart()
                {
                    chart.draw(data, options);
                }
                function selectHandler()
                {
                    var selection = chart.getSelection();
                    if (selection.length > 0) 
                    {
                        var c = selection[0];
                        var replaced = "";
                        var message = "Time: ";
                        message += data.getValue(c.row,0);
                        message += " \n"
                        replaced = message.replace(",", ":");
                        replaced = replaced.replace(",", ":");
                        document.getElementById("dispTime").innerHTML = replaced;
                        message = "Humidity: "
                        message += data.getValue(c.row,1);
                        message += "%"
                        document.getElementById("dispValues").innerHTML = message;
                    }
                }
            }
        </script>
	</body>
</html>