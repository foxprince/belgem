<?php
require_once('../log.php');
function processPrice($thecarat, $thecolor, $theclarity, $thecut, $thepolish, $thesymmetry, $thecertificate, $theshape, $thefluo, $rawprice, $sellerdiscount, $source, $target){
	global $conn;

	$very_raw_price=$rawprice;


	$sql_discount='SELECT * FROM price_discount';
	foreach($conn->query($sql_discount) as $r_d){
		if($source=='rapnet' && $target=='agency'){
			$discount=$r_d['rapnet_discount_agency'];
		}else if($source=='rapnet' && $target=='retail'){
			$discount=$r_d['rapnet_discount_retail'];
		}else if($source=='excel' && $target=='agency'){
			$discount=$r_d['excel_discount_agency'];
		}else if($source=='excel' && $target=='retail'){
			$discount=$r_d['excel_discount_retail'];
		}
	}

	//$rawprice_with_discount=$very_raw_price*(100-$discount)/100;

	$sql_rules='SELECT * FROM price_settings where source="'.$source.'" and target="'.$target.'" ORDER BY id ASC';
	$stmt=$conn->query($sql_rules);
	$rulesfound=$stmt->rowCount();
	if($thecolor>'M')
		$thecolor = 'M';
	if($rulesfound){
			foreach($stmt as $r){
				$crr_rule_weight_from=$r['carat_from'];
				$crr_rule_weight_to=$r['carat_to'];
				$crr_rule_color_raw=$r['color'];
				$crr_rule_clarity_raw=$r['clarity'];
					
				$crr_rule_cut_raw=$r['cut'];
				$crr_rule_polish_raw=$r['polish'];
				$crr_rule_symmetry_raw=$r['symmetry'];
				$crr_rule_certificate_raw=$r['certificate'];
				$crr_rule_fluo_raw=$r['fluo'];
				$crr_rule_shape_raw=$r['shape'];
				$crr_rule_weight_from=floatval($crr_rule_weight_from);
				$crr_rule_weight_to=floatval($crr_rule_weight_to);
				$thecarat=floatval($thecarat);
				if(isset($crr_rule_color_array)){
					unset($crr_rule_color_array);
				}
				if(isset($crr_rule_clarity_array)){
					unset($crr_rule_clarity_array);
				}
					
				if(isset($crr_rule_cut_array)){
					unset($crr_rule_cut_array);
				}
				if(isset($crr_rule_polish_array)){
					unset($crr_rule_polish_array);
				}
				if(isset($crr_rule_symmetry_array)){
					unset($crr_rule_symmetry_array);
				}
				if(isset($crr_rule_certificate_array)){
					unset($crr_rule_certificate_array);
				}
				if(isset($crr_rule_shape_array)){
					unset($crr_rule_shape_array);
				}
				if(isset($crr_rule_fluo_array)){
					unset($crr_rule_fluo_array);
				}
					
				$crr_rule_color_array=array();
				$crr_rule_clarity_array=array();
					
				$crr_rule_cut_array=array();
				$crr_rule_polish_array=array();
				$crr_rule_symmetry_array=array();
				$crr_rule_certificate_array=array();
				$crr_rule_fluo_array=array();
				$crr_rule_shape_array=array();
					
				$crr_rule_color_array=explode(',',$crr_rule_color_raw);
				$crr_rule_clarity_array=explode(',',$crr_rule_clarity_raw);
					
				$crr_rule_cut_array=explode(',',$crr_rule_cut_raw);
				$crr_rule_polish_array=explode(',',$crr_rule_polish_raw);
				$crr_rule_symmetry_array=explode(',',$crr_rule_symmetry_raw);
				$crr_rule_certificate_array=explode(',',$crr_rule_certificate_raw);
				$crr_rule_fluo_array=explode(',',$crr_rule_fluo_raw);
				$crr_rule_shape_array=explode(',',$crr_rule_shape_raw);
					
				//echo ' rule:'.$crr_rule_value.'/t';
				/*if($thecarat>$crr_rule_weight_from && $thecarat<=$crr_rule_weight_to && in_array($thecolor, $crr_rule_color_array) && in_array($theclarity, $crr_rule_clarity_array) && in_array($thecut, $crr_rule_cut_array) && in_array($thepolish, $crr_rule_polish_array) && in_array($thesymmetry, $crr_rule_symmetry_array) && in_array($thecertificate, $crr_rule_certificate_array) && in_array($thefluo, $crr_rule_fluo_array) && in_array($theshape, $crr_rule_shape_array)){
				$final_price=$rawprice_with_discount*$crr_rule_value;
				}*/
				if($theshape=='BR'){
					if($thecarat>=$crr_rule_weight_from && $thecarat<=$crr_rule_weight_to && in_array($thecolor, $crr_rule_color_array) && in_array($theclarity, $crr_rule_clarity_array) && in_array($thecut, $crr_rule_cut_array) && in_array($thepolish, $crr_rule_polish_array) && in_array($thesymmetry, $crr_rule_symmetry_array) && in_array($thefluo, $crr_rule_fluo_array) && in_array($theshape, $crr_rule_shape_array) && in_array($thecertificate, $crr_rule_certificate_array)){
						$crr_rule_value=$r['the_para_value'];
						break;
					}
				}else{
					if($thecarat>=$crr_rule_weight_from && $thecarat<=$crr_rule_weight_to && in_array($thecolor, $crr_rule_color_array) && in_array($theclarity, $crr_rule_clarity_array) && in_array($thepolish, $crr_rule_polish_array) && in_array($thesymmetry, $crr_rule_symmetry_array) && in_array($thefluo, $crr_rule_fluo_array) && in_array($theshape, $crr_rule_shape_array) && in_array($thecertificate, $crr_rule_certificate_array)){
						$crr_rule_value=$r['the_para_value'];
						break;
					}
				}
		}
}
if(!isset($crr_rule_value)){
	echo 'not set rule for '.$thecarat.','.$thecolor.','.$theclarity.','.$thecut.','.$thepolish.','.$thesymmetry.','.$thecertificate.','.$theshape.','.$thefluo.','.$source.','.$target.'<br/>';
	logger('not set rule for '.$thecarat.'<br/>');
	logger($thecarat.','.$thecolor.','.$theclarity.','.$thecut.','.$thepolish.','.$thesymmetry.','.$thecertificate.','.$theshape.','.$thefluo.','.$rawprice.','.$sellerdiscount.','.$source.','.$target);

	if($target=='retail'){
		$crr_rule_value=1.3;
	}else{
		$crr_rule_value=1.2;
	}
}
$final_price=$very_raw_price*(100+$sellerdiscount-$discount)/100*$crr_rule_value;
//echo($source.' '.$target.' price of calu : '.$very_raw_price.'*(100+'.$sellerdiscount.'-'.$discount.')/100*'.$crr_rule_value.'*'.$thecarat.'<br/>');
logger($source.' '.$target.' price of '.$thecertificate.' calu : '.$very_raw_price.'*(100+'.$sellerdiscount.'-'.$discount.')/100*'.$crr_rule_value.'*'.$thecarat);
if($source=='rapnet')
	return $final_price;
	else
		return $final_price*$thecarat;
}
?>
