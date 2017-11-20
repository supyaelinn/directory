<?php 
	
	$host = "127.0.0.1";
	$username = "root";
	$password = "root";
	$db = "directory";
    
   //  $mysql =  new mysqli($host, $username, $password, $db);

  	// if(! $mysql ) {
   //     die('Could not connect: ' . mysql_error());
   //  }

    // $db = mysql_select_db('directory', $mysql) or die(mysql_error());

    // Create connection
	$conn = new mysqli($host, $username, $password, $db);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
 ?>