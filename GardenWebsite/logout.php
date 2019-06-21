<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
?>
<html xmlns=http://www.w3.org/1999/xhtml>
    
    <head>
        <title>Logout page</title>
    </head>
    
    <body>
       <?php
        if(isset($_SESSION["login"]))
        {
            // remove all session variables
            session_unset();
            session_destroy();
            //remove cookie values
            unset($_COOKIE['user']);
            header('Location: index.php');     
        }
        else
        {
            header('Location: index.php');
        }
       ?>
    </body>
    
</html>