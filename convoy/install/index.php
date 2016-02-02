<title>Convoy Management System - Installer</title>
<h1>Convoy Management System</h1>
<p>Please enter your database information to begin installation</p>

<?php
    if(isset($_POST) && !empty($_POST)){
        $db_host = $_POST['host'];
        $db_data = $_POST['data'];
        $db_user = $_POST['user'];
        $db_pass = $_POST['pass'];
        
        $conName = 'connection.php';
		$conDir = '../assets/';
        if(!file_exists($conDir . $conName)) 
        {
            $handle = fopen("". $conDir . $conName . "", 'w+') or die('Cannot open file:  '. $conDir . $conName);
            $inputSQLinfo = '
            <?php 
                $username =  "'. $db_user .'"; 
                $password =  "'. $db_pass .'"; 
                $host =  "'. $db_host .'"; 
                $dbname =  "'. $db_data .'"; 
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"); 
                try 
                { 
                    $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 

                }
                catch(PDOException $ex) 
                { 
                    echo($ex->getMessage());
                    exit();
                }

                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 

                if(function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) 
                { 
                    function undo_magic_quotes_gpc(&$array) 
                    { 
                        foreach($array as &$value) 
                        { 
                            if(is_array($value)) 
                            { 
                                undo_magic_quotes_gpc($value); 
                            } 
                            else 
                            { 
                                $value = stripslashes($value); 
                            } 
                        } 
                    } 

                    undo_magic_quotes_gpc($_POST); 
                    undo_magic_quotes_gpc($_GET); 
                    undo_magic_quotes_gpc($_COOKIE); 
                } 
                header("Content-Type: text/html; charset=utf-8");
                require("functions.php");
            ?>
            ';
			
            if (!is_writable($conDir . $conName)) 
            {
                die("Cannot write to file - ". $conDir . $conName .". Check write permissions.");
            } 
            else 
            {
                fwrite($handle, $inputSQLinfo);
                fclose($handle);
                
                require("../assets/connection.php");
                
                $query = "
                    CREATE DATABASE IF NOT EXISTS ". $db_data .";
                    
                    CREATE TABLE IF NOT EXISTS `convoys` (
                      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      `location` varchar(255) NOT NULL,
                      `server` varchar(10) NOT NULL,
                      `startdate` datetime NOT NULL,
                      `description` varchar(5000) NOT NULL,
                      `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                      `user` varchar(255) NOT NULL
                    );
                ";
                try 
                {   $stmt = $db->prepare($query); 
                    $result = $stmt->execute(); 
                } 
                catch(PDOException $ex) 
                { 
                    die("Failed to run query: " . $ex->getMessage()); 
                } 
                
                header("Location: ../index.php");
                exit;
            }
	   }
	   else
	   { 
		  echo '<p>connection.php file already exists, please delete it and try again.</p>';
		  die();
	   }        
    }
?>

<form action="index.php" method="post">
    Host: <input type="text" name="host" placeholder="Database Host"></input><br />
    Database: <input type="text" name="data" placeholder="Database"></input><br />
    User: <input type="text" name="user" placeholder="Database User"></input><br />
    Password: <input type="password" name="pass" placeholder="User Password"></input><br />
    <button type="submit">Install</button>
</form>