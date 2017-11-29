<?php 
	ini_set('display_errors', '1');
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
		locale=en&explicit-lang=false&v=20171114&m=foursquare&query=".$query."&mode=locationInput&limit=10&noGeoSplitting=1&near=".$city."&wsid=HKZK03NHMOELZUDGDOE0ILY0SZC1SN&oauth_token=".$token."";
		
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
			$arr['list_id']= $res['venue']['id'];
			$arr['name']= $res['venue']['name'];
			$arr['address'] = "";
			if(array_key_exists("address",$res['venue']['location']))
			{
				$arr['address']= $res['venue']['location']['address'];
			}
			$arr['street'] = "";
			if(array_key_exists("crossStreet", $res['venue']['location']))
			{
				$arr['street']= $res['venue']['location']['crossStreet'];
			}
			$arr['city'] = "";
			if(array_key_exists("city", $res['venue']['location']))
			{
				$arr['city']= $res['venue']['location']['city'];
			}
			$arr['state'] = "";
			if(array_key_exists("state", $res['venue']['location']))
			{
				$arr['state'] = $res['venue']['location']['state'];	
			}
			$arr['postalCode']= "";
			if(array_key_exists("postalCode", $res['venue']['location']))
			{
				$arr['postalCode']= $res['venue']['location']['postalCode'];	
			}
			
			$arr['country']= $res['venue']['location']['country'];
			
			$arr['formattedAddress'] = $arr['address'] . ' ,(' . $arr['street'] . '), ' . $arr['city'] . ' ' . $arr['state']. ' ' . $arr['postalCode']. ' , ' . $arr['country'];
			//$address= str_replace("\",\"",",",$res['venue']['location']['formattedAddress']));
			// $arr['formattedAddress'] = rtrim(ltrim($res['venue']['location']['formattedAddress'],"[\""),"\"]");
			// echo $arr['formattedAddress'];
			$arr['lat']= $res['venue']['location']['lat'];
			$arr['lng']= $res['venue']['location']['lng'];
			$arr['main_url']= $res['venue']['canonicalUrl'];

			// $html2 = file_get_contents($arr['main_url']);
			
			// $html2 = str_get_html($html2);
			$arr['phone'] = "";
			$arr['website'] = "";
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
			// $sql = "INSERT INTO list (list_id, name, address, street, city, state, postalCode, country, formatedaddress, lat, lng, main_url) VALUES
 	      	// ";
			// $sql .= '('.
			// 	'"'.$arr['list_id'].'","'.$arr['name'].'","'.$arr['address'].'","'.$arr['street'].'","'.$arr['city'].'","'.$arr['state'].'","'.$arr['postalCode'].'","'.$arr['country'].'","'.$arr['formattedAddress'].'","'.$arr['lat'].'","'.$arr['lng'].'","'.$arr['main_url'] . '")';
			// echo $sql;
			// $query = mysql_query($sql);
			// echo $query;
			// $query = mysql_query("CALL insert_list(".$arr['list_id'].",".$arr['name'].",".$arr['address'].",".$arr['street'].",".$arr['city'].",".$arr['state'].",".$arr['postalCode'].",".$arr['country'].",".$arr['formattedAddress'].",".$arr['lat'].",".$arr['lng'].",".$arr['main_url'].")");

			// $statement->bindParam(':list_id', $arr['list_id'], PDO::PARAM_STR);  
			// $statement->bindParam(':name', $arr['name'], PDO::PARAM_STR);  
			// $statement->bindParam(':address', $arr['address'], PDO::PARAM_STR);  
			// $statement->bindParam(':street', $arr['street'], PDO::PARAM_STR);  
			// $statement->bindParam(':city', $arr['city'], PDO::PARAM_STR);  
			// $statement->bindParam(':state', $arr['state'], PDO::PARAM_STR);  
			// $statement->bindParam(':postalCode', $arr['postalCode'], PDO::PARAM_STR);  
			// $statement->bindParam(':country', $arr['country'], PDO::PARAM_STR);  
			// $statement->bindParam(':formattedAddress', $arr['formattedAddress'], PDO::PARAM_STR);  
			// $statement->bindParam(':lat', $arr['lat'], PDO::PARAM_STR);  
			// $statement->bindParam(':lng', $arr['lng'], PDO::PARAM_STR);  
			// $statement->bindParam(':main_url', $arr['main_url'], PDO::PARAM_STR);  

			

		}
			// exit;
		}

		
		// $sql .= rtrim($sql,",");
		// $sql = str_replace(", ,","," , $sql);
		// echo $sql;
		// mysql_query($sql);
		// echo $sql;exit;
		// if(mysqli_query($mysql, $sql)){
		//     echo "Records added successfully.";
		// } else{
		//     echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		// }
		 
		// // Close connection
		// mysqli_close($mysql);

		// $statement->execute();		
		echo "<h1>".$total." results in " .$_POST['city']. "</h1>";
		echo "<h3> Limited 10 Results only for demo </h3>";
		// echo "<div class='full-block' style='height:4300px;'>";
		echo "<div class='content-col'>";
		echo "<div class='list-items'>";
		$i = 1;
		echo "<form name='data' action='export.php' method='POST' target='hidden-form'>";
		echo '<input type="submit" name="save" value="Export Excel">';
		foreach ($sqlQuery as  $res) {
		if($res['name'] != ""){
?>
		
		<div class="item" data-ad_id="<?= $res['id'] ?>">
			<div class="item-pic" id="<?= $res['id'] ?>">
				<img src="http://codebasedev.com/directoryapp/directoryapp_108/place_pic_thumb/1/17.03.15.16.39-1489621182.898-51555235.jpg">
			</div><!-- .item-pic -->

			<div class="item-description">
				<div class="item-title-row">
					<div class="item-counter"><div class="item-counter-inner"><?= $i ?></div></div>
					<input type="hidden" name="item[<?= $i ?>]['name']" value="<?= $res['name'] ?>">
					<input type="hidden" name="item[<?= $i ?>]['main_url']" value="<?= $res['main_url'] ?>">
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
						<input type="hidden" name="item[<?= $i ?>]['formatedaddress']" value="<?= $res['formattedAddress'] ?>">
						<strong><?= str_replace("<\/span>","",$res['formattedAddress']) ?></strong>
					<?php } ?>
					</div>

					<div class="item-phone">
						<input type="hidden" name="item[<?= $i ?>]['phone']" value="<?= $res['phone'] ?>">
						<i class="fa fa-phone-square"></i><?= $res['phone'] ?>
					</div>
					<div class="item-url">
						<input type="hidden" name="item[<?= $i ?>]['website']" value="<?= $res['website'] ?>">
						<i class="fa fa-website"></i><?= $res['website'] ?>
					</div>
				</div>
				</div>

			<div class="clear"></div>
		</div>

<?php 	
		$i++;
		}	
		}
		echo '</form>';
		echo "</div>";
		echo "</div>";
		// echo "</div>";
		
	}

 ?>
 	<div class="sidebar">
 		<!-- <input type="button" name="save" id="save" value="Export Excel"> -->
 	</div>
 	<script type="text/javascript">
 		$("#save").click(function(){
 			data = $("form[name=data]").serialize();
 			// $("form[name=data]").ajaxSubmit({url: 'export.php', type: 'post',data: data});
 			$.post('export.php',data);
 			// $.ajax( {
		  //     type: "POST",
		  //     url: 'export.php',
		  //     data: data,
		  //     success: function( response ) {
		  //     	window.open(this.url,'_blank' );
		  //     //    var $a = $("<a>");
				//     // $a.attr("href",data.file);
				//     // $("body").append($a);
				//     // $a.attr("download","file.xls");
				//     // $a[0].click();
				//     // $a.remove();
		  //     }
		  //   } );
 			// $.ajax({
	   //          type: 'POST',
	   //          data: data,
	   //          url: 'export.php',
	   //          dataType: 'json',
	   //          // async: false,
	   //          success: function(result){
	   //              // call the function that handles the response/results
	   //               console.log(result);
	   //              //$(".wrapper").html(result);
	   //              //$('.loading').modal('toggle');
	                
	   //          },
	   //          error: function(){
	                
	   //              window.alert("Wrong query : ");
	   //              //$('.loading').modal('toggle');
	   //              //$("#btn_search").click();
	   //          }
	   //        });
 			// $(".item").each(function(){
 			// 	console.log($(this).val());
 			// });
 		});
 	</script>
