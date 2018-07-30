<?php
    header("Access-Control-Allow-Origin: *");
    $urlbeg = "https://api.propublica.org/congress/v1/";
    $url = "";
    $urldb = $_GET["datab"];
    if($urldb == "legislators"){
			  $ch = curl_init();
				$headers = array();
				$headers[] = 'X-API-Key: j5sGBsDlqnn5OtIbwkP0SkAgavmRJYvyF98AzZc3';
        $urlby = $_GET["byTab"];
        if($urlby == "state"){
            $urlsta = $_GET["state"];
            if($urlsta == "all"){
								curl_setopt($ch, CURLOPT_URL, 'https://api.propublica.org/congress/v1/115/senate/members.json');
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								$response_s = curl_exec($ch);
								curl_setopt($ch, CURLOPT_URL, 'https://api.propublica.org/congress/v1/115/house/members.json');
								$response_h = curl_exec($ch);
								$res = json_decode($response_s, true);
								$reh = json_decode($response_h, true);
								$result = array_merge($res["results"][0]["members"], $reh["results"][0]["members"]);
								$restr = json_encode($result);
							  echo $restr;
            }
            else{ 
								curl_setopt($ch, CURLOPT_URL, $urlbeg.'members/senate/'.$urlsta.'/current.json');
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								$response_s = curl_exec($ch);
								curl_setopt($ch, CURLOPT_URL, $urlbeg.'members/house/'.$urlsta.'/current.json');
								$response_h = curl_exec($ch);
								$res = json_decode($response_s, true);
								$reh = json_decode($response_h, true);
								$result = array_merge($res["results"], $reh["results"]);
								$restr = json_encode($result);
							  echo $restr;
            }
        }
        else if($urlby == "detailinfo"){
            $urlid = $_GET["detailid"];
					  curl_setopt($ch, CURLOPT_URL, $urlbeg."members/".$urlid.".json");
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($ch);
					  $res = json_decode($response, true);
					  $restr = json_encode($res["results"][0]);
						echo $restr;
        }
        else if($urlby == "detailco"){
            $urlid = $_GET["memberid"];
					  curl_setopt($ch, CURLOPT_URL, $urlbeg."members/".$urlid.".json");
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($ch);
					  $res = json_decode($response, true);
					  $restr = json_encode($res["results"][0]["roles"][0]);
						echo $restr;
        }
        else if($urlby == "detailbi"){
            $urlid = $_GET["sponsorid"];
					  curl_setopt($ch, CURLOPT_URL, $urlbeg."members/".$urlid."/bills/introduced.json");
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($ch);
					  $res = json_decode($response, true);
					  $restr = json_encode($res["results"][0]["bills"]);
					  echo $restr;
        }
        else{
            $urlcham = $_GET["chamber"];
					  curl_setopt($ch, CURLOPT_URL, $urlbeg.'115/'.$urlcham.'/members.json');
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($ch);
					  $res = json_decode($response, true);
					  $restr = json_encode($res["results"][0]["members"]);
						echo $restr;
        }
			  curl_close($ch);
    }
    else if($urldb == "bills"){
			  $ch = curl_init();
				$headers = array();
				$headers[] = 'X-API-Key: j5sGBsDlqnn5OtIbwkP0SkAgavmRJYvyF98AzZc3';
        $urlby = $_GET["byTab"];
        if($urlby == "active"){
					  curl_setopt($ch, CURLOPT_URL, $urlbeg."115/senate/bills/active.json");
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response_s = curl_exec($ch);
						curl_setopt($ch, CURLOPT_URL, $urlbeg."115/house/bills/active.json");
						$response_h = curl_exec($ch);
						$res = json_decode($response_s, true);
						$reh = json_decode($response_h, true);
					  $counts = array("senate"=>$res["results"][0]["num_results"], "house"=>($res["results"][0]["num_results"]+$reh["results"][0]["num_results"]));
					  $result = array_merge($res["results"][0]["bills"], $reh["results"][0]["bills"]);
					  $result = array("counts"=>$counts, "info"=>$result);
						$restr = json_encode($result);
					  echo $restr;
        }
        else if($urlby == "new"){
					  curl_setopt($ch, CURLOPT_URL, $urlbeg."bills/upcoming/senate.json");
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response_s = curl_exec($ch);
						curl_setopt($ch, CURLOPT_URL, $urlbeg."bills/upcoming/house.json");
						$response_h = curl_exec($ch);
						$res = json_decode($response_s, true);
						$reh = json_decode($response_h, true);
					  $result = array_merge($res["results"][0]["bills"], $reh["results"][0]["bills"]);
						$restr = json_encode($result);
					  echo $restr;
        }
        else if($urlby == "detail"){
            $urlbillid = $_GET["billid"];
					  $urlbillid = explode("-", $urlbillid)[0];
					  curl_setopt($ch, CURLOPT_URL, $urlbeg."115/bills/".$urlbillid.".json");
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($ch);
						$res = json_decode($response, true);
						$restr = json_encode($res["results"][0]);
					  echo $restr;
        }
			  curl_close($ch);
    }
    else if($urldb == "committees"){
			  $ch = curl_init();
				$headers = array();
				$headers[] = 'X-API-Key: j5sGBsDlqnn5OtIbwkP0SkAgavmRJYvyF98AzZc3';
        $urlby = $_GET["byTab"];
        curl_setopt($ch, CURLOPT_URL, $urlbeg."115/".$urlby."/committees.json");
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				$res = json_decode($response, true);
				$restr = json_encode($res["results"][0]["committees"]);
				echo $restr;
			  curl_close($ch);
    }
?>