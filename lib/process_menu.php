<?php
global $listafooter; 
require_once("./config/config.php");
//require_once("./lib/XMLize.php");
//require_once("./lib/process_page.php");
// READ XML FILE WITH MENU CONFIGURATION
function getRoot($id_page){
	global $APP;
	if($id_page==-1) return(-1);
	if(!file_exists($APP["xml_files"]."/$id_page".".xml")) return(-1);
	
	$currentPage = printPage($id_page);
	
	if($currentPage["id_parent"]=="0") return($id_page);
	
	while ($currentPage["id_parent"] != "0") {
		$nextPage = printPage($currentPage["id_parent"]);
		$currentPage = $nextPage;
	}
	
	return($currentPage["id_page"]);
}

function printMenu ($idSubmenu = 0, $idPageSelected = -1, $lang = "ES") {
	//echo "<!--idSubmenu=$idSubmenu ; idPageSelected=$idPageSelected-->";
	global $APP;
	global	$listafooter;
	$xmlFile = "./xml/menu.xml";
	$fp = fopen("$xmlFile", "r");
	$data = "";
	while ($line = fgets($fp,1024)) {
		$data .= $line;
	}
	fclose($fp);
	
	$xml = xmlize($data); # where $data is the xml in the above section.
	$tmpMenu = $xml["menu"]["#"]["page"];
	
	$menuMain = array();
	$menuSecond = array();
	$menuThird = array();
	//Para agregar el boton de inicio-->
	$inicioHref="./";
	
	$listafooter="<a class=\"enlace_gris\" href=\"".$inicioHref."\" style=\"color:#FFFFFF;\" >Inicio</a> | ";

	if($idSubmenu==0 && $idPageSelected==-1){
		$class=' class="menuOptionTdSelected"';
		$begin_menu = "begin_menu_on.gif";
		$inicioButton = "<td width=\"4\" height=\"32\">".
							"<img src=\"images/$begin_menu\" width=\"4\" height=\"32\" alt='Inicio Menu' title='Inicio Menu' />".
						"</td>".
						"<td class=\"menuOptionTdSelected\" align=\"center\">".
							"<a class=\"menuOption menuOptionPadding\" href=\"".$inicioHref."\">INICIO</a>".
						"</td>\n";
	}else{
		$class="";
		$begin_menu = "begin_menu_off.gif";
		$inicioButton='<td width="4" height="32">'.
						"<img src=\"images/$begin_menu\" width=\"4\" height=\"32\"  id=\"img_begin_menu\" alt=\"inicio menu\" title=\"inicio menu\" />".
						'<script language="javascript" type="text/javascript" >'.
						'function changeImgBegin(imgId,imgSrc){'.
						'	img=document.getElementById(imgId); img.src=imgSrc;'.
						'}'.
						'</script>'.
					'</td>'.
					'<td align="center"'.
						' onmouseover="this.style.background=\'#2d65b2\'; changeImgBegin(\'img_begin_menu\',\'images/begin_menu_on.gif\');"'.
						' onmouseout="this.style.background=\'\'; changeImgBegin(\'img_begin_menu\',\'images/begin_menu_off.gif\');">'.
						'<a class="menuOption menuOptionPadding" href="'.$inicioHref.'" >INICIO</a></td>';
	}
	$menuMain[] = $inicioButton;
	//<--Para agregar el boton de inicio
	$subOption = 0;
	$levelOne = array();
	$levelTwo = array();
	$levelThree = array();
	
	$rootId = getRoot($idPageSelected);
	$classSelectedOption = "";
	if($rootId!=-1){
		$classSelectedOption = "menuOptionTdSelected";
	}
	
	foreach ($tmpMenu as $value) { // LEVEL ONE
		$tmpArray = $value;
		$tmpLang = $tmpArray["#"]["a"][0]["@"]["lang"];
		$tmpLink = $tmpArray["#"]["a"][0]["@"]["href"];
		$tmpId = $tmpArray["#"]["a"][0]["@"]["id_page"];
		$tmpParent = $tmpArray["#"]["a"][0]["@"]["id_parent"];
		$tmpChildren = $tmpArray["#"]["a"][0]["@"]["children"]; // display children page
		$tmpOrder = $tmpArray["#"]["a"][0]["@"]["order"];
		$tmpLabel = $tmpArray["#"]["a"][0]["#"];		
		if($tmpLang == $lang) {
			if($tmpId==$rootId){
				$selectedOption=' class="'.$classSelectedOption.'"';
			}else{
				$selectedOption='';
			}
			
			if($tmpParent != 0) {
				break;
			} else {
				//if($tmpId=="6") break;
				if($tmpChildren != ""){//When the menu option has children
					if($tmpId==$rootId){
						$js="";
					}else{
						$js="onmouseover=\"javascript:MM_showHideLayers('$tmpId','','show'); locateSubmenu('$tmpId'); this.style.background='#2d65b2';\"".
							" onmouseout=\"javascript:MM_showHideLayers('$tmpId','','hide'); this.style.background='';\"";
					}
				}else{//When the menu option has no children
					if($tmpId==$rootId){
						$js="";

					}else{
						$js="onmouseover=\"this.style.background='#2d65b2';\" onmouseout=\"this.style.background='';\"";
					}
				}				
				if($tmpId == 6)
				{
					$listafooter.="<a class=\"enlace_gris\" href=\"".$tmpLink."\" style=\"color:#FFFFFF;\" >".trim(htmlentities($tmpLabel,ENT_QUOTES,"utf-8"))."</a>";
				}
				else
				{
					$listafooter.="<a class=\"enlace_gris\" href=\"".$tmpLink."\" style=\"color:#FFFFFF;\" >".trim(htmlentities($tmpLabel,ENT_QUOTES,"utf-8"))."</a>&#160;|&#160;";
				}

			if($tmpChildren != "") {//when the page has no children
					if($tmpId == 5) {//id=5 id de Noticias y Eventos
						$js="onmouseover=\"this.style.background='#2d65b2';\" onmouseout=\"this.style.background='';\"";
						$menuMain[] = "<td align=\"center\" $js id=\"td$tmpId\" $selectedOption>".
						"<a class=\"menuOption menuOptionPadding\" href=\"$tmpLink\" id=\"o$tmpId\">".htmlentities($tmpLabel,ENT_QUOTES,"utf-8")."</a></td>\r\n";						
						
					} else {
					
					
						$menuMain[] = "<td align=\"center\" $js id=\"td$tmpId\" $selectedOption>".
						"<a class=\"menuOption menuOptionPadding\" href=\"$tmpLink\" id=\"o$tmpId\"".
							" onmouseover=\"javascript:MM_showHideLayers('$tmpId','','show'); locateSubmenu('$tmpId');\"".
							" onmouseout=\"javascript:MM_showHideLayers('$tmpId','','hide');\">".htmlentities($tmpLabel,ENT_QUOTES,"utf-8")."</a></td>\r\n";						
					
					}
					$levelOne[$tmpId] = $tmpChildren;
				} else {//when the page has children
				
				
				
					if($tmpId == 6) {//id=5 id de Noticias y Eventos
					
						if($idPageSelected==6)
						{
							
								
							$class=' class="menuOptionTdSelected"';
							$begin_menu = "end_menu_on.gif";
							$menuMain[]  = "<td class=\"menuOptionTdSelected\" align=\"center\">".
												"<a class=\"menuOption menuOptionPadding\" href=\"$tmpLink\">".htmlentities($tmpLabel,ENT_QUOTES,"utf-8")."</a>".
											"</td>\n".
											"<td width=\"4\" height=\"32\">".
												"<img src=\"images/$begin_menu\"  alt=\"Inicio menu\" title=\"Inicio menu\" width=\"4\" height=\"32\" />".
											"</td>";					
								
						}
						else
						{															
							$class="";
							$begin_menu = "end_menu_off.gif";
							$menuMain[] = '<td align="center"'.
											' onmouseover="this.style.background=\'#2d65b2\'; changeImgEnd(\'img_end_menu\',\'images/end_menu_on.gif\');"'.
											' onmouseout="this.style.background=\'\'; changeImgEnd(\'img_end_menu\',\'images/end_menu_off.gif\');">'.
											'<a class="menuOption menuOptionPadding" href="'.$tmpLink.'" >'.htmlentities($tmpLabel,ENT_QUOTES,"utf-8").'</a></td>'.
										'<td width="4" height="32">'.
											"<img src=\"images/$begin_menu\" width=\"4\" height=\"32\" id=\"img_end_menu\" alt=\"menu fin\" title=\"menu fin\" />".
											'<script language="javascript" type="text/javascript">'.
											'function changeImgEnd(imgId,imgSrc){'.
											'	img=document.getElementById(imgId); img.src=imgSrc;'.
											'}'.
											'</script>'.
										'</td>';
								
								
								
						}
					}
					else{
					$menuMain[] = "<td align=\"center\" $js  $selectedOption><a class=\"menuOption menuOptionPadding\" href=\"$tmpLink\" id=\"o$tmpId\">".htmlentities($tmpLabel,ENT_QUOTES,"utf-8")."</a></td>\n";}
				}
			}	
		}
	}

	
	$parent = 0;
	$tmpReturn = array();
	$tmpReturn["menuSecond"] = "";
	
	foreach ($levelOne as $key => $value) {
		if ($key == 5) {
			continue;
		}
		$flag = 1;
		if($value != "") {
			$tmpReturn["menuSecond"] .= "<div id=\"s$key\" class=\"hidden\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
			foreach ($tmpMenu as $value2) { // LEVE SECOND
				$tmpArray = $value2;
				$tmpLang = $tmpArray["#"]["a"][0]["@"]["lang"];
				$tmpLink = $tmpArray["#"]["a"][0]["@"]["href"];
				$tmpId = $tmpArray["#"]["a"][0]["@"]["id_page"];
				$tmpParent = $tmpArray["#"]["a"][0]["@"]["id_parent"];
				$tmpChildren = $tmpArray["#"]["a"][0]["@"]["children"]; // display children page
				$tmpOrder = $tmpArray["#"]["a"][0]["@"]["order"];
				$tmpLabel = $tmpArray["#"]["a"][0]["#"];
				if($tmpLang == $lang && $key == $tmpParent) {
					
					$showChildren = "";
					$hideChildren = "";
					$arrow = "";
					$felchita="";
					$href = "$tmpLink";
					if($tmpChildren != "") {

						$levelTwo[$tmpId] = $tmpChildren;
						$levelTwoParent[$tmpId] = $tmpParent;
						$showChildren = "MM_showHideLayers('$tmpId','','show'); locateSubmenu2('$tmpId');";
						$hideChildren = "MM_showHideLayers('$tmpId','','hide');";
						$felchita="<td width=\"10\" class=\"submenuOption\"><img src=\"images/flechita.gif\" alt='flechita' /></td>";
						//$arrow = "<img src=\"images/arrow_menu.gif\" alt=\"$tmpLabel\" width=\"4\" height=\"8\">";
						//$href = "#";
					}else
					{
					$felchita="<td class=\"submenuOption\" width=\"10\"><img src=\"images/spacer.gif\" width=\"10\" height=\"1\" alt='espacio' /></td>";
					}
				
					
					if($flag == 1) {
						$tmpReturn["menuSecond"] .= "\n<tr onmouseover=\"javascript:MM_showHideLayers($tmpParent,'','show');\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');\">
															<td align=\"left\" height=\"10\" colspan=\"3\"></td>
														</tr>";
						$flag = 0;
					}
					$tmpReturn["menuSecond"] .= "<tr class=\"cursorHand\" onmouseover=\"javascript:MM_showHideLayers('$tmpParent','','show');Alumbrar_Padre('td$tmpParent'); locateSubmenu('$tmpParent');$showChildren\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');DesAlumbrar_Padre('td$tmpParent');$hideChildren\">													
													<td width=\"10\" class=\"submenuOption\"><img src=\"images/spacer.gif\" width=\"10\" height=\"1\" alt='espacio' /></td>
													<td id=\"td$tmpId\" class=\"submenuOption\" align=\"left\">
														<a class=\"submenuOption\" href=\"$href\" id=\"o$tmpId\" onmouseover=\"javascript:MM_showHideLayers('$tmpParent','','show'); locateSubmenu('$tmpParent');$showChildren\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');$hideChildren\">".htmlentities($tmpLabel,ENT_QUOTES,"utf-8")."</a>
													</td>".$felchita."</tr>\n";
				
				}
			}
			$tmpReturn["menuSecond"] .= "</table></div>";
		}
	}
	
	/*$tmpReturn["menuThird"] = "";
	foreach ($levelTwo as $key => $value) {
		$flag = 1;
		if($value != "") {
			$tmpReturn["menuThird"] .= "<div id=\"s$key\" class=\"hidden\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
			foreach ($tmpMenu as $value2) { // LEVE THIRD
				$tmpArray = $value2;
				$tmpLang = $tmpArray["#"]["a"][0]["@"]["lang"];
				$tmpLink = $tmpArray["#"]["a"][0]["@"]["href"];
				$tmpId = $tmpArray["#"]["a"][0]["@"]["id_page"];
				$tmpParent = $tmpArray["#"]["a"][0]["@"]["id_parent"];
				$tmpChildren = $tmpArray["#"]["a"][0]["@"]["children"]; // display children page
				$tmpOrder = $tmpArray["#"]["a"][0]["@"]["order"];
				$tmpLabel = $tmpArray["#"]["a"][0]["#"];
				
				if($tmpLang == $lang && $key == $tmpParent) {
					$showChildren = "MM_showHideLayers('".$levelTwoParent[$key]."','','show'); ";
					$hideChildren = "MM_showHideLayers('".$levelTwoParent[$key]."','','hide');";
					$tmpReturn["menuThird"] .= "<tr class=\"cursorHand\" onmouseover=\"javascript:MM_showHideLayers('$tmpParent','','show');Alumbrar_Padre('td".$levelTwoParent[$key]."');$showChildren\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');DesAlumbrar_Padre('td".$levelTwoParent[$key]."');$hideChildren\">
													<td class=\"submenuOption\" width=\"10\"><img src=\"images/spacer.gif\" width=\"10\" height=\"1\" alt='espacio' /></td>
													<td class=\"submenuOption\" align=\"left\">
														<a class=\"submenuOption\" href=\"$tmpLink\" id=\"o$tmpId\" onmouseover=\"javascript:MM_showHideLayers('$tmpParent','','show');$showChildren\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');$hideChildren\">$tmpLabel</a>
													</td>
													<td class=\"submenuOption\" width=\"10\"><img src=\"images/spacer.gif\" width=\"10\" height=\"1\" alt='espacio' /></td>
												</tr>\n";

				}
			}
			$tmpReturn["menuThird"] .= "</table></div>";
		}
	}
	*/
		
	$tmpReturn["menuThird"] = "JOLA";
	foreach ($levelTwo as $key => $value) {
		$flag = 1;
		if($value != "") {
			$tmpReturn["menuThird"] .= "<div id=\"s$key\" class=\"hidden\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
			foreach ($tmpMenu as $value2) { // LEVE THIRD
				$tmpArray = $value2;
				$tmpLang = $tmpArray["#"]["a"][0]["@"]["lang"];
				$tmpLink = $tmpArray["#"]["a"][0]["@"]["href"];
				$tmpId = $tmpArray["#"]["a"][0]["@"]["id_page"];
				$tmpParent = $tmpArray["#"]["a"][0]["@"]["id_parent"];
				$tmpChildren = $tmpArray["#"]["a"][0]["@"]["children"]; // display children page
				$tmpOrder = $tmpArray["#"]["a"][0]["@"]["order"];
				$tmpLabel = $tmpArray["#"]["a"][0]["#"];
				
				if($tmpLang == $lang && $key == $tmpParent) {
					$showChildren = "MM_showHideLayers('".$levelTwoParent[$key]."','','show'); ";
					$hideChildren = "MM_showHideLayers('".$levelTwoParent[$key]."','','hide');";
					
					
				if ($idPageSelected==$levelTwoParent[$key])
				{
					$tmpReturn["menuThird"] .= "<tr class=\"cursorHand\" onmouseover=\"javascript:MM_showHideLayers('$tmpParent','','show');$showChildren\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');$hideChildren\">
														<td class=\"submenuOption\" width=\"10\"><img src=\"images/spacer.gif\" width=\"10\" height=\"1\" alt='espacio' /></td>
														<td class=\"submenuOption\" align=\"left\">
															<a class=\"submenuOption\" href=\"$tmpLink\" id=\"o$tmpId\" onmouseover=\"javascript:MM_showHideLayers('$tmpParent','','show');$showChildren\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');$hideChildren\">$tmpLabel</a>
														</td>
														<td class=\"submenuOption\" width=\"10\"><img src=\"images/spacer.gif\" width=\"10\" height=\"1\" alt='espacio' /></td>
													</tr>\n";
				}else
				{
					$tmpReturn["menuThird"] .= "<tr class=\"cursorHand\" onmouseover=\"javascript:MM_showHideLayers('$tmpParent','','show');Alumbrar_Padre('td".$levelTwoParent[$key]."');$showChildren\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');DesAlumbrar_Padre('td".$levelTwoParent[$key]."');$hideChildren\">
														<td class=\"submenuOption\" width=\"10\"><img src=\"images/spacer.gif\" width=\"10\" height=\"1\" alt='espacio' /></td>
														<td class=\"submenuOption\" align=\"left\">
															<a class=\"submenuOption\" href=\"$tmpLink\" id=\"o$tmpId\" onmouseover=\"javascript:MM_showHideLayers('$tmpParent','','show');$showChildren\" onmouseout=\"javascript:MM_showHideLayers('$tmpParent','','hide');$hideChildren\">$tmpLabel</a>
														</td>
														<td class=\"submenuOption\" width=\"10\"><img src=\"images/spacer.gif\" width=\"10\" height=\"1\" alt='espacio' /></td>
													</tr>\n";
				}
					
					

				}
			}
			$tmpReturn["menuThird"] .= "</table></div>";
		}
	}

/*	$menuMain = (count($menuMain) > 0) ? "<table cellpadding=\"0\" height=\"32\" width=\"100%\" cellspacing=\"0\" border=\"0\" align=\"center\"><tr>".
		$inicioButton.
		join("<td width=\"1\" align=\"center\" valign=\"middle\"><img src=\"images/menuOptionSeparator.gif\"  title=\"separador\"  alt=\"separador\" /></td>", $menuMain)."</tr></table>" : "";*/
	
	$menuMain = (count($menuMain) > 0) ? "<table cellpadding=\"0\"  width=\"100%\" cellspacing=\"0\" border=\"0\" align=\"center\"><tr>".
		join("<td width=\"1\" align=\"center\" valign=\"middle\"><img src=\"images/menuOptionSeparator.gif\" title=\"separador\" alt=\"separador\" /> </td>", $menuMain)."</tr></table>" : "";
	$tmpReturn["menuMain"] = $menuMain;
	return $tmpReturn;
}
?>