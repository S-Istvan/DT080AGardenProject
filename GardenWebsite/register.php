<!DOCTYPE html>
<?php
    session_start();
    
    $usernameErr="";
    $username="";
    $passwordErr="";
    $password="";
    $preHashWord="";
    $nameErr="";
    $name="";
    $eMailErr="";
    $email="";
    $counter=0;
    $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
    $db_serverUname = "Homer";                 // username for MySQL
    $db_serverPwd = "Baron";                     // password for MySQL
    $database = "gardenprojectdb";              //name of db
    //Check user input
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_POST["uname"]))
        {
            $counter++;
            $usernameErr="Username must be entered"; //Return error if username hasn't been entered
        }
        else
        {
            $username = checkUserData($_POST["uname"]); //validate user input to gaurd against xss
        }
        if(empty($_POST["pword"]))
        {
            $counter++;
            $passwordErr="Password must be entered"; //Return an error if the password hasn't been entered
        }
        else
        {
            $password = checkUserData($_POST["pword"]); //validate user input to gaurd against xss
            $preHashWord=$password;
            $password = md5($password);
        }
        if(empty($_POST["name"]))
        {
            $counter++;
            $nameErr="Full Name must be entered"; //Return an error if the name hasn't been entered
        }
        else
        {
            $name = checkUserData($_POST["name"]); //validate user input to gaurd against xss
        
        }
        if(empty($_POST["E-Mail"]))
        {
            $counter++;
            $eMailErr="E-mail must be entered"; //Return an error if the password hasn't been entered
        }
        else
        {
            $email = filterEmail($_POST["E-Mail"]); //validate user input to gaurd against xss
        
        }
    }
    function filterEmail($inputMail)
    {
        $inputMail = trim($inputMail);
        $inputMail = stripslashes($inputMail);
        // Remove all illegal characters from email
        $inputMail = filter_var($inputMail, FILTER_SANITIZE_EMAIL);
        // Validate e-mail
        if (filter_var($inputMail, FILTER_VALIDATE_EMAIL) === false) 
        {
            $GLOBALS['eMailErr']="The email adress you entered is not a valid email";
            $GLOBALS ['counter']++;
        } 
        return $inputMail;
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
				<form name="formRegister"id='registerForm' method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>"> 
					<fieldset >
					<legend style="color:white">Register</legend>
						<input type='hidden' name='submitted' id='submitted' value='1'/>
                        <label for='name'style="color:white" >Your Full Name*: </label>
                        <br>
						<input type='text' name='name' id='name' onclick="nameBlank()" value="<?php echo $name;?>" placeholder="name" maxlength="50" />
                        <br>
                        <label for='email' style="color:white">Email Address*:</label>
                        <br>
						<input type='text' name='E-Mail' id='email' onclick="eMailBlank()" value="<?php echo $email;?>" placeholder="email" maxlength="50" />
                        <br>
                        <label for='username'style="color:white" >UserName*:</label>
                        <br>
						<input type='text' name='uname' id='username' maxlength="15" onclick="registerBlank()" value="<?php echo $username;?>" placeholder="Username"/>
                        <br>
                        <label for='password' style="color:white">Password*:</label>
                        <br>
						<input type='password' name='pword' id='password' maxlength="40" onclick="passwordBlank()" value="<?php echo $preHashWord;?>" placeholder="Password" />
						<input type='submit' name='Submit' value='Submit' onmouseover="errRegCheck()" onclick="return registerS()" />
					</fieldset>
						<br/>
						<a href="login.php"><input type="button" class="regButton" value="Login Here"/></a>
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
					if($eMailErr!="")
					{
						echo "<p class='inputErr' style='color:red'> $eMailErr </p>"; //Input feedback
					}
					if($nameErr!="")
					{
						echo "<p class='inputErr' style='color:red'> $nameErr </p>"; //Input feedback
					}
				?>
			</div>
			  <div style="display: inline-block; width:33%; ">
            </div>
		</div>
       </div>    
       <script type="text/javascript" src="js/js.js"></script>  
       <?php
			if ($counter == 0)
			{
				if ($_SERVER["REQUEST_METHOD"] == "POST")
				{
					if(isset($_SESSION["login"]))
					{
						// remove all session variables
						session_unset();
						session_destroy();
						//remove cookie values
						if(isset($_COOKIE["user"]))
						{
							unset($_COOKIE['user']);    
						}
					}
					$conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database
					if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
					{
						print("Error connecting to MySQL database" . mysqli_connect_error($conn));
					} 
					else
					{
						$username = mysqli_real_escape_string($conn,$username); //Check the username for common characters used in SQL injection attacks
						$password = mysqli_real_escape_string($conn,$password); //Strip the password of common SQL injection characters
						$name = mysqli_real_escape_string($conn,$name); //Strip the name of common SQL injection characters
						$email = mysqli_real_escape_string($conn,$email); //Strip the email of common SQL injection characters
						$stmt = mysqli_prepare($conn, "SELECT * FROM logindetails WHERE uname = ?"); //Prepare an SQL statement
						mysqli_stmt_bind_param($stmt, "s", $username); //Bind the username and password as parameters for the SQL statement
						mysqli_stmt_execute($stmt); //Execute the SQL statement                 
						if(mysqli_stmt_fetch($stmt)==TRUE) //Test if the execution returned true
						{
							mysqli_stmt_close($stmt); //close the connection
							return false;
						}
						else{
							mysqli_stmt_close($stmt); //close the connection
							unset($_SESSION['regError']);
							$link = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database
							if (mysqli_connect_errno($link)) //test the connection to the sql server and db
							{
								print("Error connecting to MySQL database" . mysqli_connect_error($link));
							} 
							else{
								$stmt = mysqli_prepare($link, "INSERT INTO logindetails (uname, pword, name, EMail) VALUES (?, ?, ?, ?)"); //Prepare an SQL statement
								mysqli_stmt_bind_param($stmt,"ssss", $username, $password, $name, $email); //Bind the username and password as parameters for the SQL statement
								if(mysqli_stmt_execute($stmt)==TRUE) //Test if the execution returned true
								{
									mysqli_stmt_close($stmt);
									header('Location: index.php'); //return to homepage
								}
								else
								{
									mysqli_stmt_close($stmt);
									$_SESSION['regError']="register unsuccessful"; //if the query was not a valid entry then set the session array value error
								}	
							}	
						}
					}
					
					mysqli_close($conn); //close the connection
				} 
			}  
        ?>
		         
    </body>
</html>