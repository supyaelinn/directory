<?php 
	set_time_limit(0);
	require("db/config.php");
	require("simple_html_dom.php");

	echo $mysql;
	if(!empty($_POST))
	{
		$query = $_POST['query'];
		$city = str_replace(",","%2C",str_replace(" ", "+", $_POST['city']));
		//New+York%2C+NY
		$token = "FQ1A4CO0PTLLFHGWKUD0QQDEMH3C21MVTHVLE2HY3G5NDHE1";
		$url = "https://api.foursquare.com/v2/search/recommendations?
		locale=en&explicit-lang=false&v=20171114&m=foursquare&query=".$query."&mode=locationInput&limit=30&noGeoSplitting=1&near=".$city."&nearGeoId=72057594043056517&ll=40.75804587574332%2C-73.97712707519531&wsid=HKZK03NHMOELZUDGDOE0ILY0SZC1SN&oauth_token=".$token."";
		
		$html = file_get_contents($url);
		
		$html = str_get_html($html);

		$result = explode(",\"totalResults",explode("results\":", $html)[1])[0];

		//$res =  array($res);
		//echo $res;exit;
		$result = json_decode($result, true);
		// $sqlQuery = "INSERT INTO list VALUES ";

		// $stmt = $conn->prepare("INSERT INTO list (list_id, name, address, street, city, state, postalCode, country, formattedAddress, lat, lng, main_url) VALUES (?, ?, ?,?,?,?,?,?,?,?,?,?)");

		// // $stmt->bind_param("sss", $firstname, $lastname, $email);
		$sqlQuery = array();
		$i = 1;
		foreach ($result as  $res) {
	        // for($i=0; $i<count($result); $i++) {
			$arr = array();
			$arr['list_id']= $res['venue']['id'];
			$arr['name']= $res['venue']['name'];
			$arr['address']= $res['venue']['location']['address'];
			$arr['street']= $res['venue']['location']['crossStreet'];
			$arr['city']= $res['venue']['location']['city'];
			$arr['state']= $res['venue']['location']['state'];
			$arr['postalCode']= $res['venue']['location']['postalCode'];
			$arr['country']= $res['venue']['location']['country'];
			$arr['formattedAddress']= json_encode($res['venue']['location']['formattedAddress']);
			$arr['lat']= $res['venue']['location']['lat'];
			$arr['lng']= $res['venue']['location']['lng'];
			$arr['main_url']= $res['venue']['canonicalUrl'];

			// $stmt->bindValue($i++, $arr);
			array_push($sqlQuery, $arr);
			// //$sqlQuery .= "' ".;
			

	                // if ($i == count($result)-1){
	                //     $sqlQuery .= "(".$result[$i][0]."' '".$result[$i][1]."');";
	                // }else{
	                //     $sqlQuery .= "(".$result[$i][0].", '".$ids[$result][1]."'),";
	                // }

	        // }

	         


		}

		echo json_encode($sqlQuery);
		// $stmt->bindValue($param,$sqlQuery);
		// $result = $stmt->execute();
		// $sqlQuery = rtrim($sqlQuery,",");
		
		
		// mysql_query($sqlQuery,$mysql) or die('Error, insert query failed: '.mysql_error()); 

		exit;
		//echo count($res);exit;
		// $res = json_encode($res);
		// $arr = array();
		// echo "<h1>Search results for in " .$_POST['city']. "</h1>";
		// echo "<div class='full-block'>";
		// echo "<div class='content-col'>";
		// echo "<div class='list-items'>";
		// foreach ($result as  $res) {
		// 	echo "<div class='item'>";
		// 	echo "<div class='item-description'>";
		// 	echo "<div class='item-title-row'>";
		// 	echo "<div class='item-description'>";
		// 	echo "<h2><a href='".."'>";

		// 	echo "</a></h2>";

		// 	echo "</div>";
		// 	echo "</div>";
		// 	echo "</div>";
		// 	array_push($arr, $res);
		// 	// $arr['name'] =  $res['venue']['name'];
		// 	// $arr['id'] = $res['venue']['id'];
		// 	// $arr['location'] = $res['venue']['location']['address'];
		// 	// $arr['street'] = $res['venue']['location']['crossStreet'];
		// 	// $arr['postalCode'] = $res['venue']['location']['postalCode'];
			
		// 	// $arr['city'] = $res['venue']['location']['city'];
		// 	// $state = $res['venue']['location']['state'];
		// 	// $country = $res['venue']['location']['country'];
		// 	// $formattedAddress = $res['venue']['location']['formattedAddress'];
		// 	// $lat = $res['venue']['location']['lat'];
		// 	// $lng = $res['venue']['location']['lng'];
		// 	// $url = $res['venue']['canonicalUrl'];
			
		// }
		// echo "</div>";
		// echo "</div>";
		// echo "</div>";
		exit;

	}

 ?>
