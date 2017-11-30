<?php 
	// ini_set('display_errors', '1');
	ini_set('max_execution_time', 1000);
	// set_time_limit(0);
	// require("db/config.php");
	require("simple_html_dom.php");
	// require("common.php");

	
	if(!empty($_POST))
	{
		$query = $_POST['query'];
		$city = str_replace(",","%2C",str_replace(" ", "+", $_POST['city']));
		//New+York%2C+NY
		$token = "FQ1A4CO0PTLLFHGWKUD0QQDEMH3C21MVTHVLE2HY3G5NDHE1";
		$url = "https://api.foursquare.com/v2/search/recommendations?
		locale=en&explicit-lang=false&v=20171114&m=foursquare&query=".$query."&mode=locationInput&limit=50&noGeoSplitting=1&near=".$city."&wsid=HKZK03NHMOELZUDGDOE0ILY0SZC1SN&oauth_token=".$token."";
		
		$html = file_get_contents($url);
		
		$html = str_get_html($html);

		$total = explode("}",explode("totalResults\":",$html)[1])[0];

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
		// $statement = $link->prepare("INSERT INTO list(list_id, name, address, street, city, state, postalCode, country, formattedAddress, lat, lng, main_url)
		//     VALUES(:list_id, :name, :address, :street, :city, :state, :postalCode, :country, :formattedAddress, :lat, :lng, :main_url)");
		
		
		

		foreach ($result as  $res) {
		if(array_key_exists("venue", $res)){
	        // for($i=0; $i<count($result); $i++) {
			$arr = array();
			$arr['id']= $res['venue']['id'];
			$arr['name']= $res['venue']['name'];
			$arr['location']['address'] = "";
			if(array_key_exists("address",$res['venue']['location']))
			{
				$arr['location']['address']= $res['venue']['location']['address'];
			}
			$arr['location']['street'] = "";
			if(array_key_exists("crossStreet", $res['venue']['location']))
			{
				$arr['location']['street']= $res['venue']['location']['crossStreet'];
			}
			$arr['location']['city'] = "";
			if(array_key_exists("city", $res['venue']['location']))
			{
				$arr['location']['city']= $res['venue']['location']['city'];
			}
			$arr['state'] = "";
			if(array_key_exists("state", $res['venue']['location']))
			{
				$arr['location']['state'] = $res['venue']['location']['state'];	
			}
			$arr['location']['postalCode']= "";
			if(array_key_exists("postalCode", $res['venue']['location']))
			{
				$arr['location']['postalCode']= $res['venue']['location']['postalCode'];	
			}
			
			$arr['location']['country']= $res['venue']['location']['country'];
			
			$arr['formattedAddress'] = $arr['location']['address'] . ' ,(' . $arr['location']['street'] . '), ' . $arr['location']['city'] . ' ' . $arr['location']['state']. ' ' . $arr['location']['postalCode']. ' , ' . $arr['location']['country'];
			//$address= str_replace("\",\"",",",$res['venue']['location']['formattedAddress']));
			// $arr['formattedAddress'] = rtrim(ltrim($res['venue']['location']['formattedAddress'],"[\""),"\"]");
			// echo $arr['formattedAddress'];
			$arr['lat']= $res['venue']['location']['lat'];
			$arr['lng']= $res['venue']['location']['lng'];
			$arr['canonicalUrl']= $res['venue']['canonicalUrl'];

			$html2 = file_get_contents($arr['canonicalUrl']);
			
			$html2 = str_get_html($html2);
			$arr['phone'] = "";
			$arr['website'] = "";
			// $arr['facebookUsername'] = "";
			if(is_object($html2))
			{
				if(is_object($html2->find('span[class=tel]',0))){
					$arr['phone'] = $html2->find('span[class=tel]',0)->innertext;
				}	
			// }
			// echo $arr['phone'];exit;
				
				if(is_object($html2->find('a[class=url]',0))){
					$arr['website'] = $html2->find('a[class=url]',0)->href;	
				}
				

			}else{
				continue;
			}

			// $stmt->bindValue($i++, $arr);
			array_push($sqlQuery, $arr);
			
		}
			// exit;
		}

		echo "<h1>".$total." results in " .$_POST['city']. "</h1>";
		echo "<h3> Limited 50 Results only for demo </h3>";
		
	}

 ?>

		<!-- <div class='list-items'> -->
<div class="block">
	<a class="btn btn-blue" href="download.php">Download CSV</a>
	<!-- <a class="btn btn-default show-form" href="#">Show form</a> -->
</div>
<div class='content-col'>
<div class="table-responsive">
	<table class="table table-striped table-condensed">
		<tr>
			<th></th>
			<th>Name</th>
			<th>Address</th>
			<th>Street</th>
			<th>City</th>
			<th>State</th>
			<th>Postal Code</th>
			<th>Phone</th>
			<th>Website</th>
			<th>Lat Long</th>
			
		</tr>

		<?php
		$count = 1;
		$csv = array();
		foreach($sqlQuery as $k => $v) {
		if($v['name'] != ""){
			// $v = array();
			
			$name          = (!empty($v['name']))                        ? $v['name']                          : '';
			$v_foursq_id   = (!empty($v['id']))                          ? $v['id']                            : '';
			$v_foursq_url  = (!empty($v['canonicalUrl']))                ? $v['canonicalUrl']                  : '';
			$v_address     = (!empty($v['location']['address']))         ? $v['location']['address']           : '';
			$v_street       = (!empty($v['location']['street']))           ? $v['location']['street']
							: '';

			$v_city        = (!empty($v['location']['city']))            ? $v['location']['city']              : '';
			$v_state       = (!empty($v['location']['state']))           ? $v['location']['state']             : '';
			$v_postalCode       = (!empty($v['location']['postalCode']))           ? $v['location']['postalCode']: '';

			$v_country       = (!empty($v['location']['country']))           ? $v['location']['country']: '';

			$v_formattedAddress = (!empty($v['formattedAddress']))           ? $v['formattedAddress']: '';

			$v_lat = (!empty($v['lat']))           ? $v['lat']: '';
			$v_lng = (!empty($v['lng']))           ? $v['lng']: '';

			$v_phone       = (!empty($v['phone']))   ? $v['phone']     : '';
			$v_website     = (!empty($v['website']))                         ? $v['website']                           : '';
			// $v_lat         = (!empty($v['location']['lat']))             ? $v['location']['lat']               : '';
			// $v_lng         = (!empty($v['location']['lng']))             ? $v['location']['lng']               : '';
			// $v_postal_code = (!empty($v['location']['postalCode']))      ? $v['location']['postalCode']        : '';
			// $v_menu        = (!empty($v['menu']['url']))                 ? $v['menu']['url']                   : '';
			// $v_tags        = (!empty($v['tags']))                        ? $v['tags']                          : '';
			// $v_checkins    = (!empty($v['stats']['checkinsCount']))      ? $v['stats']['checkinsCount']        : 0;
			// $v_users       = (!empty($v['stats']['usersCount']))         ? $v['stats']['usersCount']           : 0;
			// $v_facebook    = (!empty($v['contact']['facebookUsername'])) ? $v['contact']['facebookUsername']   : '';
			// $v_twitter     = (!empty($v['contact']['twitter']))          ? $v['contact']['twitter']            : '';

			// // lat/lng
			$v_latlng_display = '';
			if(!empty($v_lat) && !empty($v_lng)) {
				$v_latlng_display = $v_lat . ',' . $v_lng;
			}

			// // tags
			// if(is_array($v_tags)) {
			// 	$v_tags = implode(', ', $v_tags);
			// }

			// // create csv row
			$this_loop = array();

			$this_loop[] = $name;
			$this_loop[] = $v_foursq_id     ; 
			$this_loop[] = $v_address       ; 
			$this_loop[] = $v_city          ; 
			$this_loop[] = $v_state         ; 
			$this_loop[] = $v_phone         ; 
			$this_loop[] = $v_website       ; 
			$this_loop[] = $v_latlng_display; 
			$this_loop[] = $v_postalCode   ; 
			// if($menu        == 1) { $this_loop[] = $v_menu          ; }
			// if($tags        == 1) { $this_loop[] = $v_tags          ; }
			// if($checkins    == 1) { $this_loop[] = $v_checkins      ; }
			// if($users       == 1) { $this_loop[] = $v_users         ; }
			// if($facebook    == 1) { $this_loop[] = $v_facebook      ; }
			// if($twitter     == 1) { $this_loop[] = $v_twitter       ; }

			$row = $this_loop;

			// add row to csv
			$csv[] = $row;
			?>
			<tr>
				<td><?= $count; ?></td>
				<td><a href="<?= $v_foursq_url ?>" target="_blank"><?= $name; ?></a></td>
				<td><?= $v_address       ; ?></td>
				<td><?= $v_street       ; ?></td>
				<td style="white-space: nowrap"><?= $v_city; ?></td>
				<td style="white-space: nowrap"><?= $v_state; ?></td>
				<td style="white-space: nowrap"><?= $v_postalCode; ?></td>
				<td style="white-space: nowrap"><?= $v_phone; ?></td>
				<td><a href="<?= $v_website; ?>" target="_blank"><?= $v_website; ?></a></td>
				<td><?= $v_latlng_display; ?></td>
				
				<!-- <?php if($menu        == 1) { ?><td><a href="<?= $v_menu          ; ?>" target="_blank"><?= $v_menu          ; ?></a></td> <?php } ?>
				
				<?php if($tags        == 1) { ?><td><?= $v_tags          ; ?></td> <?php } ?>
				<?php if($checkins    == 1) { ?><td><?= $v_checkins      ; ?></td> <?php } ?>
				<?php if($users       == 1) { ?><td><?= $v_users         ; ?></td> <?php } ?>
				<?php if($facebook    == 1) { ?><td><a href="http://facebook.com/<?= $v_facebook; ?>" target="_blank"><?= $v_facebook; ?></a></td> <?php } ?>
				<?php if($twitter     == 1) { ?><td><a href="http://twitter.com/<?= $v_twitter; ?>" target="_blank"><?= $v_twitter; ?></a></td> <?php } ?> -->
			</tr>
			<?php
			$count++;
			}
		}
		?>
	</table>
</div>
<!-- </div> -->
</div>
