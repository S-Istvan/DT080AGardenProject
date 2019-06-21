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
    <body style="background-color:#48494f; margin:0;">
        <?php
            $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
            $db_serverUname = "Homer";                 
            $db_serverPwd = "Baron";                     
            $database = "gardenprojectdb";
            $humiArr = array();
            $humiRows = 0;
            $humiDate = "";
            $humiTime = array();
            $stripHour = array();
            $stripMin = array();
            $stripSec = array();
            $i=0;
            $select = "";
        
            $conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database
            if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
            {
                print("Error connecting to MySQL database" . mysqli_connect_error($conn));
            } 
            else
            {
                if(isset($_GET["airHumiDate"]))
                {
                    $humiDate = checkUserData($_GET["airHumiDate"]);
                    $stmt = ( "SELECT airHumi FROM `airData` WHERE timestamp BETWEEN '".$humiDate." 00:00:00' AND '".$humiDate." 23:59:59'"); //Prepare an SQL statement
                    if ($result = mysqli_query($conn, $stmt))
                    {
                        $humiRows = mysqli_num_rows($result);
                        while ($row = mysqli_fetch_assoc($result)) 
                        {
                            $humiArr[$i]=$row["airHumi"];
                            $i=$i+1;
                        }
                        $i=0;
                        $select = "airHumi";
                    }
                    $stmt = ( "SELECT time FROM `airData` WHERE timestamp BETWEEN '".$humiDate." 00:00:00' AND '".$humiDate." 23:59:59'"); //Prepare an SQL statement
                    if ($result = mysqli_query($conn, $stmt))
                    {
                        $humiRows = mysqli_num_rows($result);
                        while ($row = mysqli_fetch_assoc($result)) 
                        {
                            $humiTime[$i]=$row["time"];
                            (int)$stripHour[$i] = substr($humiTime[$i], 0, 2);
                            (int)$stripMin[$i] = substr($humiTime[$i], 3, -3);
                            (int)$stripSec[$i] = substr($humiTime[$i], -2);
                            $i=$i+1;
                        }
                        $i=0;
                        $select = "airHumi";
                        unset($_GET["airHumiDate"]);
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
                    <li class="listItem" id="dispData"><?php $dispDate = DateTime::createFromFormat('Y-m-d', $humiDate); echo date_format($dispDate, "d/m/y") ?></li>
                    <li class="listItem" id="dispTime"></li>
                    <li class="listItem" id="dispValues"></li>
                    <li class="listItem"></li>
                </ul> 
            </nav>
            <div id="chart" style="top:10%;">
                <div id="curve_chart" style="width: 89%; height:90%"></div>
            </div>
        </div>
        
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            var j = 0;
            var jConvHumiArray = <?php echo json_encode($humiArr); ?>;
            var jHourArray = <?php echo json_encode($stripHour); ?>;
            var jMinArray = <?php echo json_encode($stripMin); ?>;
            var jSecArray = <?php echo json_encode($stripSec); ?>;
            var humiRows= <?php echo json_encode($humiRows); ?>;
            var select= <?php echo json_encode($select); ?>;;
 
            function drawChart() 
            {
                var data = new google.visualization.DataTable();
                data.addColumn('timeofday', 'Time');
                data.addColumn('number', 'Air Humidity');
                for (i = 0; i < humiRows; i++) 
                {
                    data.addRow([[parseInt(jHourArray[i]),parseInt(jMinArray[i]),parseInt(jSecArray[i])], parseInt(jConvHumiArray[i])]);
                }

                var options = 
                {
                    title: 'Air Humidity',
                    curveType: 'function',
                    lineWidth: '2',
                    theme: 'maximized',
                   // explorer: { actions: ['dragToZoom', 'rightClickToReset'] },
                    backgroundColor: 'transparent',
                    colors:['#54ced4'],
                    pointSize:'2',
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
                    animation: {"startup": true, duration: 1000,easing: 'in'}
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                chart.draw(data, options);
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
                        if (data.getValue(c.row,1)>=90)
                        {
                            document.getElementById("dispValues").style.backgroundColor = "#ff0000";
                            document.getElementById("dispValues").style.color = "#fff";
                        }
                        else if (data.getValue(c.row,1)>75)
                        {
                            document.getElementById("dispValues").style.backgroundColor = "#fffa00";
                            document.getElementById("dispValues").style.color = "#fff";
                        }
                        else if (data.getValue(c.row,1) >=60 && data.getValue(c.row,1) <=75)
                        {
                            document.getElementById("dispValues").style.backgroundColor = "#2ebc07";
                            document.getElementById("dispValues").style.color = "#fff";
                        }
                        else if (data.getValue(c.row,1)<60 && data.getValue(c.row,1)>=50)
                        {
                            document.getElementById("dispValues").style.backgroundColor = "#fffa00";
                            document.getElementById("dispValues").style.color = "#000";
                        }
                        else if (data.getValue(c.row,1)<50)
                        {
                            document.getElementById("dispValues").style.backgroundColor = "#ff0000";
                            document.getElementById("dispValues").style.color = "#fff";
                        }
                    }
                }
            }
        </script>
	</body>	
</html>