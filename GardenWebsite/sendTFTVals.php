<html>
    <head>
        <link rel="icon" type="image/png" href="images/logoIcon.ico">
    </head>
    <body>
        <h1>Heading</h1>
        <p>Success</p>
    </body>
</html>

<?php
    $db_serverIPAddr = "127.0.0.1";           //IP address of the database 
    $db_serverUname = "Homer";                 //default username for MySQL
    $db_serverPwd = "Baron";                     //default password for MySQL
    $database = "gardenprojectdb";
    $retVal;
    
    $conn = mysqli_connect($db_serverIPAddr, $db_serverUname, $db_serverPwd, $database); //Open a connection to the MySQL database; 
    //if(isset($_GET["airTemp"]))
   // {
        if (mysqli_connect_errno($conn)) //test the connection to the sql server and db
        {
            print("Error connecting to MySQL database" . mysqli_connect_error($conn));
        } 
        else
        {
                     
            $stmt = mysqli_prepare($conn, "SELECT airTemp FROM airData WHERE (timestamp) = (SELECT MAX(timestamp) FROM airdata)"); //Prepare an SQL statement
            if(mysqli_stmt_execute($stmt)==TRUE) //Execute the statement and test if it returned true
            {
                mysqli_stmt_bind_result($stmt, $retVal);
                mysqli_stmt_fetch($stmt);
                $myfile = fopen("temp.txt", "w");
                fwrite($myfile,$retVal);
                mysqli_stmt_close($stmt);
                fclose($myfile);
            }
            else
            {
                mysqli_stmt_close($stmt);
            }
            $stmt = mysqli_prepare($conn, "SELECT airHumi FROM airData WHERE (timestamp) = (SELECT MAX(timestamp) FROM airData)"); //Prepare an SQL statement
            if(mysqli_stmt_execute($stmt)==TRUE) //Execute the statement and test if it returned true
            {
                mysqli_stmt_bind_result($stmt, $retVal);
                mysqli_stmt_fetch($stmt);
                $myfile = fopen("humi.txt", "w");
                fwrite($myfile,$retVal);
                mysqli_stmt_close($stmt);
                fclose($myfile);
            }
            else
            {
                mysqli_stmt_close($stmt);
            }
            $stmt = mysqli_prepare($conn, "SELECT lux FROM lux WHERE (timestamp) = (SELECT MAX(timestamp) FROM lux)"); //Prepare an SQL statement
            if(mysqli_stmt_execute($stmt)==TRUE) //Execute the statement and test if it returned true
            {
                mysqli_stmt_bind_result($stmt, $retVal);
                mysqli_stmt_fetch($stmt);
                $myfile = fopen("lux.txt", "w");
                fwrite($myfile,$retVal);
                mysqli_stmt_close($stmt);
                fclose($myfile);
            }
            else
            {
                mysqli_stmt_close($stmt);
            }
            $stmt = mysqli_prepare($conn, "SELECT soilHumi FROM soilhumi WHERE (timestamp) = (SELECT MAX(timestamp) FROM soilhumi)"); //Prepare an SQL statement
            if(mysqli_stmt_execute($stmt)==TRUE) //Execute the statement and test if it returned true
            {
                mysqli_stmt_bind_result($stmt, $retVal);
                mysqli_stmt_fetch($stmt);
                $myfile = fopen("soilHumi.txt", "w");
                fwrite($myfile, $retVal);
                mysqli_stmt_close($stmt);
                fclose($myfile);
            }
            else
            {
                mysqli_stmt_close($stmt);
            }						
        }
?>