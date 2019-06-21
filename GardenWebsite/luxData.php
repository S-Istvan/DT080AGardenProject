<?php
    $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
    $db_serverUname = "Homer";                 //default username for MySQL
    $db_serverPwd = "Baron";                     //default password for MySQL
    $database = "gardenprojectdb";          //Name of the database
    
    $conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database; 
    if(isset($_POST["lux"]))
    {
        if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
        {
            print("Error connecting to MySQL database" . mysqli_connect_error($conn));
        } 
        else
        {
            $lux = $_POST["lux"];
            $lux = mysqli_real_escape_string($conn,$lux); //Check the lux for common characters used in SQL injection attacks
            $stmt = mysqli_prepare($conn, "INSERT INTO lux (lux,date,time) VALUES (?,NOW(),CURTIME())"); //Prepare an SQL statement
            mysqli_stmt_bind_param($stmt,"s", $lux); //Bind the lux as a parameter for the SQL statement
            if(mysqli_stmt_execute($stmt)==TRUE) //Execute the statement and test if it returned true
            {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                unset($_POST["lux"]);
            }
            else
            {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                unset($_POST["lux"]);
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
        <h1>You're not supposed to be here</h1>
        <img src="images/whatareyouupto.jpg" alt="angry pointing" style="height:92%; position:fixed;bottom:0%;">
    </body>
nd();
    </script>
</html>
