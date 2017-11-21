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
	

	try{
            $link = new PDO("mysql:host=$host;dbname=$db","$username","$password");
           
        }catch(PDOException $ex){
            die(json_encode(array(
                'outcome' => false,
                'message' => 'Unable to connect'
            )));
        }
	// $statement = $link->prepare("INSERT INTO testtable(name, lastname, age)
	//         VALUES('Bob','Desaunois','18')");

	//     $statement->execute();	
 ?>