<?php
    $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
    $db_serverUname = "Homer";                 //default username for MySQL
    $db_serverPwd = "Baron";                     //default password for MySQL
    $database = "gardenprojectdb";
    
    $conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database; 
    if(isset($_POST["airTemp"]))
    {
        if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
        {
            print("Error connecting to MySQL database" . mysqli_connect_error($conn));
        } 
        else
        {
		
            $temp = $_POST["airTemp"];
            $humi = $_POST["airHumi"];
            $temp = mysqli_real_escape_string($conn,$temp); //Check the temp for common characters used in SQL injection attacks
            $humi = mysqli_real_escape_string($conn,$humi);
            $stmt = mysqli_prepare($conn, "INSERT INTO airData (airTemp,airHumi,date,time) VALUES (?,?,NOW(),NOW())"); //Prepare an SQL statement
            mysqli_stmt_bind_param($stmt,"ss", $temp,$humi); //Bind the temperature as a parameter for the SQL statement
            if(mysqli_stmt_execute($stmt)==TRUE) //Execute the statement and test if it returned true
            {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                unset($_POST["airTemp"]);
                unset($_POST["airHumi"]);
		
            }
            else
            {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                unset($_POST["airTemp"]);
                unset($_POST["airHumi"]);
            }	
        }
    }
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

<html>
    <head>
        <link rel="icon" type="image/png" href="images/logoIcon.ico">
    </head>
    <body>
        <h1>Heading</h1>
        <p>This text is just for testing purpose</p>
    </body>
</html>
