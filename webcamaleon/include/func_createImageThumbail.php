<?php
if(!extension_loaded("gd")) @dl("php_gd2.".PHP_SHLIB_SUFFIX);
//-->Funcion para crear los thumbails
function createImageThumbail($pathSource,$pathDest,$maxWidth,$maxHeight,$overwrite=TRUE,$calidadJPG=100){
	$width_thumbail=$maxWidth;//283;
	$height_thumbail=$maxHeight;//180;
	$arr = getimagesize($pathSource);
	if(empty($arr)) return FALSE;
	$width=$Wc=$arr[0];
	$height=$Hc=$arr[1];
	while($Wc > $width_thumbail || $Hc > $height_thumbail){
		if($Wc>$width_thumbail){
			$x=$width_thumbail/$Wc;
			$Wc=$width_thumbail;
			$Hc=floor($Hc*$x);
		}
		if($Hc>$height_thumbail){
			$y=$height_thumbail/$Hc;
			$Hc=$height_thumbail;
			$Wc=floor($Wc*$y);
		}
	}
	$imgDest=imagecreatetruecolor($Wc,$Hc);
	//This is for the 
	imagesavealpha($imgDest, true);
	$trans_colour = imagecolorallocatealpha($imgDest, 0, 0, 0, 127);
    imagefill($imgDest, 0, 0, $trans_colour);
	
	switch($arr[2]){
		case IMAGETYPE_GIF: $img=@imagecreatefromgif($pathSource); break;
		case IMAGETYPE_JPEG: $img=@imagecreatefromjpeg($pathSource); break;
		case IMAGETYPE_PNG: $img=@imagecreatefrompng($pathSource); 		
			/*imagealphablending($img, true);		
			imagesavealpha($img, true);*/
		break;
		default: return FALSE; break;
	}
	if(!$img) return(FALSE);
	imagecopyresampled($imgDest,$img,//resource dst_image, resource src_image
		0,//$half_width_thumbail-$half_Wc,//int dst_x
		0,//$half_height_thumbail-$half_Hc,//int dst_y
		0,//int src_x
		0,//int src_y
		$Wc,//int dst_w
		$Hc,//int dst_h
		$width,//$Wc,//int src_w
		$height//$Hc//int src_h
	);
	if(file_exists($pathDest) && $overwrite){ clearstatcache();	if(!unlink($pathDest)) return FALSE; }
	if(file_exists($pathDest) && !$overwrite){ clearstatcache(); return FALSE; }
	switch($arr[2]){
		case IMAGETYPE_GIF:imagegif($imgDest,$pathDest);break;
		case IMAGETYPE_JPEG:imagejpeg($imgDest,$pathDest,$calidadJPG);break;
		case IMAGETYPE_PNG:imagepng($imgDest,$pathDest);break;
	}
	@chmod($pathDest,0755);
	//clearstatcache();
	imagedestroy($img);
	imagedestroy($imgDest);
	clearstatcache();
	return TRUE;
}
//<--Funcion para crear los thumbails
?>