<?php

	######	kkkget chunk of text as a string into $string between $start and $end string	######
	function getBetween($string, $start = "", $end = ""){
		if (strpos($string, $start)) { // required if $start not exist in $string
			$startCharCount = strpos($string, $start) + strlen($start);
			$firstSubStr = substr($string, $startCharCount, strlen($string));
			$endCharCount = strpos($firstSubStr, $end);
			if ($endCharCount == 0) {
				$endCharCount = strlen($firstSubStr);
			}
			return substr($firstSubStr, 0, $endCharCount);
		} else {
			return '';
		}
	}
	
	######	 increment VERSION_PATCH, if VERSION_TAG exists remove it, set KB validity to current date +1000 years 	######	 
	$changeStatus = "'R'";
	$verlength = 7;
	$homepage = file_get_contents('C:\Users\ecknnkl\Desktop\RBS_6000.ssc');
	$data1 = getBetween($homepage, 'knowledgeBase RBS_6000_P {', 'includeAdditionalElements');
	#echo $data1;
	$polje = explode('"', $data1);

	$verzija = $polje[1];
	$datum = $polje[2];
	$version = "";
	$version2 = "''";
	#echo $verzija;
	#echo $datum;
	
	$ver = explode("-", $verzija);
	$ver2 = explode(":", $verzija);
	$nesto = strlen($ver2[2]);
	$prvi = $ver2[0];
	$srednji = $ver2[1];
	$drugi = $ver2[2];
	$srednji++;
	$srednji--;
	$brojMin = $srednji;
	$srednji = str_pad($srednji,3,"0",STR_PAD_LEFT);
	$drugi = explode("-", $drugi);
	
	echo $drugi = $drugi[0];
	$drugi++;
	$changePatch = $drugi;
	$drugi = str_pad($drugi,3,"0",STR_PAD_LEFT);
	echo $drugi;
		
	if( strlen($ver2[2])==$verlength){
		$version="";
		$version2 = "''";
	}

	echo $version;

	$updateMid = $prvi.":".$srednji.":".$drugi.$version;
	echo "<br>";
    echo $date = date('Y-m-d');

	
	$novi1 = str_replace($verzija,$updateMid, $homepage);
	$novi2 = str_replace($datum, "\n"."    validFrom ".$date."\n\n", $novi1);

	$data2 = getBetween($homepage, ' constraint RBS6000_PROJECT_VERSION_IMPL {', '}');
	$polje2 = explode(';', $data2);
	$linija = $polje2[4];
	$verMin = $polje2[2];
	$verPatch = $polje2[3];
	$novi3 = str_replace($linija, "\n\t\t\t\t\tVERSION_TAG = ".$version2 , $novi2);
	$novi4 = str_replace($verMin, "\n\t\t\t\t\tVERSION_MINOR = ".$brojMin , $novi3);
	
	#########################	change release status to 'R' if it equals 'T'	##################################### 
	
	$data3 = getBetween($homepage, 'constraint SET_RBS_RELEASE_STATUS {', '}');
	$polje3 = explode(':', $data3);

	$pom = explode(',', $polje3[2]);
	echo $status = $pom[0];
	$pom3 = explode('=', $status);
	$status1 = $pom3[0];
	$status2 = $pom3[1];
	if($status2 == " 'T'")
		echo $status1."= ".$changeStatus;
		$novi5 = str_replace($status, $status1."= ".$changeStatus, $novi4);
		
	$novi6 = str_replace($verPatch, "\n\t\t\t\t\tVERSION_PATCH = ".$changePatch, $novi5);	
		
	file_put_contents('C:\Users\ecknnkl\Desktop\RBS_6000.ssc',$novi6);
	
?>