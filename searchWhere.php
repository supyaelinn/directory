<?php 
	set_time_limit(0);
	require("simple_html_dom.php");


	if(!empty($_GET['query']))
	{
		$query = $_GET['query'];
		
		$url = "https://api.foursquare.com/v2/geo/geocode?locale=en&explicit-lang=false&v=20171114&query=".$query."&autocomplete=true&allowCountry=false&ll=16.7832947%2C96.166687&maxInterpretations=25&wsid=HKZK03NHMOELZUDGDOE0ILY0SZC1SN&oauth_token=QEJ4AQPTMMNB413HGNZ5YDMJSHTOHZHMLZCAQCCLXIX41OMP";
		$html = file_get_contents($url);

		$html = str_get_html($html);

		$name = explode("displayName\":\"", $html);

		$arr = array();
		for ($i=1; $i <= count($name) ; $i++) { 
			$arr2 = array();
			$arr2['id'] = $i;
			$arr2['text'] = explode("\",\"", $name[$i])[0];
			
			$arr[] = $arr2;
		}

		echo json_encode(array("results"=>$arr));exit;
	}

 ?>