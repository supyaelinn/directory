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
		locale=en&explicit-lang=false&v=20171114&m=foursquare&query=".$query."&mode=locationInput&limit=30&noGeoSplitting=1&near=".$city."&wsid=HKZK03NHMOELZUDGDOE0ILY0SZC1SN&oauth_token=".$token."";
		
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
		//$insert = $link->prepare("INSERT INTO list(list_id, name) VALUES (?, ?)");
		
		// $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$statement = $link->prepare("INSERT INTO list(list_id, name, address, street, city, state, postalCode, country, formattedAddress, lat, lng, main_url)
		    VALUES(:list_id, :name, :address, :street, :city, :state, :postalCode, :country, :formattedAddress, :lat, :lng, :main_url)");
		
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
			$arr['formattedAddress']= str_replace("\",\"",",",json_encode($res['venue']['location']['formattedAddress']));
			$arr['lat']= $res['venue']['location']['lat'];
			$arr['lng']= $res['venue']['location']['lng'];
			$arr['main_url']= $res['venue']['canonicalUrl'];

			// $stmt->bindValue($i++, $arr);
			array_push($sqlQuery, $arr);
			$statement->bindParam(':list_id', $arr['list_id'], PDO::PARAM_STR);  
			$statement->bindParam(':name', $arr['name'], PDO::PARAM_STR);  
			$statement->bindParam(':address', $arr['address'], PDO::PARAM_STR);  
			$statement->bindParam(':street', $arr['street'], PDO::PARAM_STR);  
			$statement->bindParam(':city', $arr['city'], PDO::PARAM_STR);  
			$statement->bindParam(':state', $arr['state'], PDO::PARAM_STR);  
			$statement->bindParam(':postalCode', $arr['postalCode'], PDO::PARAM_STR);  
			$statement->bindParam(':country', $arr['country'], PDO::PARAM_STR);  
			$statement->bindParam(':formattedAddress', $arr['formattedAddress'], PDO::PARAM_STR);  
			$statement->bindParam(':lat', $arr['lat'], PDO::PARAM_STR);  
			$statement->bindParam(':lng', $arr['lng'], PDO::PARAM_STR);  
			$statement->bindParam(':main_url', $arr['main_url'], PDO::PARAM_STR);  

			

			// $statement->execute(array(
			// 	$arr['list_id'],$arr['name'],$arr['address'],$arr['street'],$arr['city'],$arr['state'],$arr['postalCode'],$arr['country'],$arr['formattedAddress'],$arr['lat'],$arr['lng'],$arr['main_url']
			// ));

			// exit;
		}

		$statement->execute();		
		echo "<h1>Search results for in " .$_POST['city']. "</h1>";
		echo "<div class='full-block' style='height:4120px;'>";
		echo "<div class='content-col'>";
		echo "<div class='list-items'>";
		$i = 1;
		foreach ($sqlQuery as  $res) {
		if($res['name'] != ""){
?>
		<div class="item" data-ad_id="<?php $res['id'] ?>">
			<div class="item-pic" id="<?php $res['id'] ?>">
				<img src="http://codebasedev.com/directoryapp/directoryapp_108/place_pic_thumb/1/17.03.15.16.39-1489621182.898-51555235.jpg">
			</div><!-- .item-pic -->

			<div class="item-description">
				<div class="item-title-row">
					<div class="item-counter"><div class="item-counter-inner"><?= $i++ ?></div></div>

					<h2><a href="<?= $res['main_url'] ?>" title="<?= $res['name'] ?>"><?= $res['name'] ?></a></h2>
				</div>
				<div class="item-ratings-wrapper">
					<div class="item-rating" data-rating="5.000000" title="gorgeous">
						
				</div>
					<div class="item-ratings-count">
						 									</div>
					<div class="clear"></div>
				</div><!-- .item-ratings-wrapper -->
				<div class="item-info">
					<div class="item-addr">
					<?php if($res['formattedAddress'] != "null"){ ?>
						<strong><?= str_replace("<\/span>","",rtrim(ltrim($res['formattedAddress'],"[\""),"\"]")) ?></strong>
					<?php } ?>
					</div>

					<div class="item-phone">
						<i class="fa fa-phone-square"></i><?= $res['phone'] ?></div>
				</div>
				</div>

			<div class="clear"></div>
		</div>

<?php 	
		}	
		}

		echo "</div>";
		echo "</div>";
		echo "</div>";
		exit;
		//echo json_encode($sqlQuery);
		// $stmt->bindValue($param,$sqlQuery);
		// $result = $stmt->execute();
		// $sqlQuery = rtrim($sqlQuery,",");
		
		
		// mysql_query($sqlQuery,$mysql) or die('Error, insert query failed: '.mysql_error()); 

		// exit;
		//echo count($res);exit;
		// $res = json_encode($res);
		// $arr = array();
		
		
		// echo "<div class='full-block'>";
		// echo "<div class='content-col'>";
		// echo "<div class='list-items'>";
		// foreach ($sqlQuery as  $res) {
		// 	echo "<div class='item'>";
		// 	echo "<div class='item-description'>";
		// 	echo "<div class='item-title-row'>";
		// 	echo "<div class='item-description'>";
		// 	echo "<h2><a href='". $res['id'] ."'>".$res['name'];

		// 	echo "</a></h2>"	;

		// 	echo "</div>";
		// 	echo "</div>";
		// 	echo "</div>";
		// 	echo "</div>";
			// $arr['name'] =  $res['venue']['name'];
			// $arr['id'] = $res['venue']['id'];
			// $arr['location'] = $res['venue']['location']['address'];
			// $arr['street'] = $res['venue']['location']['crossStreet'];
			// $arr['postalCode'] = $res['venue']['location']['postalCode'];
			
			// $arr['city'] = $res['venue']['location']['city'];
			// $state = $res['venue']['location']['state'];
			// $country = $res['venue']['location']['country'];
			// $formattedAddress = $res['venue']['location']['formattedAddress'];
			// $lat = $res['venue']['location']['lat'];
			// $lng = $res['venue']['location']['lng'];
			// $url = $res['venue']['canonicalUrl'];
			
		// }
		

	}

 ?>
