<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION["error"]))
    {
        echo '<p style="color:red; left:40%; position:fixed;">You need to be logged in to access that resource</p>';
    }
    unset($_SESSION['error']);
    $usernameErr="";
    $username="";
    $passwordErr="";
    $password="";
    $preHashWord="";
    $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
    $db_serverUname = "Homer";                 //default username for MySQL
    $db_serverPwd = "Baron";                     //default password for MySQL
    $database = "gardenprojectdb";        //name of db you created
    $stamp = "";

    //Check user input
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_POST["uname"]))
        {
            $usernameErr="Username must be entered"; //Return error if username hasn't been entered
        }
        else
        {
            $username = checkUserData($_POST["uname"]); //validate user input to gaurd against xss
        }
        if(empty($_POST["pword"]))
        {
            $passwordErr="Password must be entered"; //Return an error if the password hasn't been entered
        }
        else
        {
            $password = checkUserData($_POST["pword"]); //validate user input to gaurd against xss
            $preHashWord=$password;
            $password = md5($password);
            
        }
    }
    //This function checks the input from the form to protect against xss
    function checkUserData($inputData) 
    {
        $inputData = filter_var($inputData, FILTER_SANITIZE_STRING);
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        return $inputData;
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
            <div>
            <div style="display: inline-block; width:33%;">
            </div>
            <div id="login" style="display: inline-block;">
                <form name="formLogin" id="loginForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                    <h2 style=" font-family: 'RobotoDraft', 'Roboto', sans-serif; color: #666666;">Login to your account<h2>
                    <span class="fontawesome-user"></span>
                    <input type="text" name="uname" id="userName" onclick="loginBlank()" maxlength="15" value="<?php echo $username;?>" placeholder="Username">
                    <span class="fontawesome-lock"></span>
                    <input type="password" name="pword" id="password" onclick="passwordBlank()" maxlength="40" value="<?php echo $preHashWord;?>" placeholder="Password">
                    <input type="submit" value="Login" onmouseover="errLoginCheck()" onclick="return login()">
					<br/><br/>
					<a href="register.php"><input type="button" class="regButton" value="Register Here"/></a>
                </form>
            <?php 
                    if($usernameErr!="")
                    {
                        echo "<p class='inputErr' style='color:red'> $usernameErr </p>"; //Input feedback
                    }
                    if($passwordErr!="")
                    {
                        echo "<p class='inputErr' style='color:red'> $passwordErr </p>"; //Input feedback
                    }
                ?>
            </div>
            <div style="display: inline-block; width:33%; ">
            </div>
		</div>    
       <script type="text/javascript" src="js/js.js"></script>  
       <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database
                if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
                {
                    print("Error connecting to MySQL database" . mysqli_connect_error($conn));
                } 
                else
                {
                    $username = mysqli_real_escape_string($conn,$username); //Check the username for common characters used in SQL injection attacks
                    $password = mysqli_real_escape_string($conn,$password); //Strip the password of common SQL injection characters
                    $stmt = mysqli_prepare($conn, "SELECT * FROM logindetails WHERE uname = ? AND pword = ?"); //Prepare an SQL statement
                    mysqli_stmt_bind_param($stmt, "ss", $username, $password); //Bind the username and password as parameters for the SQL statement
                    mysqli_stmt_execute($stmt); //Execute the SQL statement                 
                    if(mysqli_stmt_fetch($stmt)==TRUE) //Test if the execution returned true
                    {
                        mysqli_stmt_close($stmt);
                        $_SESSION['login'] = "1"; //Set the session value login to 1
                        $_SESSION['user'] = $username; //Set the session value user to the valid username
                        $link = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database
                        $stmt = mysqli_prepare($link, "SELECT stamp FROM loginDetails WHERE uname = ? AND pword = ?"); //Prepare an SQL statement
                        mysqli_stmt_bind_param($stmt, "ss", $username, $password); //Bind the username and password as parameters for the SQL statement
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $stamp);
                        mysqli_stmt_fetch($stmt);
                        $cookie_name = "user"; 
                        $cookie_value = substr($stamp, 0, 10);
                        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); //Create a cookie called user, set it's value to the valid username
                        mysqli_stmt_close($stmt);
                        header('Location: index.php'); //return to homepage
                    }	
                    else
                    {
                        mysqli_stmt_close($stmt);
                        $_SESSION['error']="login unsuccessful"; //if the query was not a valid entry then set the session array value error
                    }
                }
                
                mysqli_close($conn); //close the connection
            }   
        ?>
    </body>
</html>
