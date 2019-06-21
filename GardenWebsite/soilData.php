<?php
    $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
    $db_serverUname = "Homer";                 //default username for MySQL
    $db_serverPwd = "Baron";                     //default password for MySQL
    $database = "gardenprojectdb";
    
    $conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database; 
    if(isset($_POST["soilHumi"]))
    {
        if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
        {
            print("Error connecting to MySQL database" . mysqli_connect_error($conn));
        } 
        else
        {
            $soilHumi = $_POST["soilHumi"];
            $soilHumi = mysqli_real_escape_string($conn,$soilHumi); //Check the username for common characters used in SQL injection attacks
            $stmt = mysqli_prepare($conn, "INSERT INTO soilhumi (soilHumi,date,time) VALUES (?,NOW(),NOW())"); //Prepare an SQL statement
            mysqli_stmt_bind_param($stmt,"s", $soilHumi); //Bind the humidity as a parameter for the SQL statement
            if(mysqli_stmt_execute($stmt)==TRUE) //Execute the statement and test if it returned true
            {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                unset($_POST["soilHumi"]);
            }
            else
            {
                mysqli_stmt_close($stmt);
                //$_SESSION['regError']="register unsuccessful"; //if the query was not a valid entry then set the session array value error
                mysqli_close($conn);
                unset($_POST["soilHumi"]);
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
        <h1>What are you up to?!</h1>
        <img src="images/accusing.png" alt="angry pointing">
    </body>
</html>
