<?php
/*

	<!--Submenu-->
	<div style="float:left; width:10px;"><img src="images/spacer.gif" width="10" height="1" alt="" /></div>
	<div class="submenu" id="div_submenu"><!--div_submenu-->
		<div style="height:52px"></div><!--up space-->
			<div><img src="images/submenu_up.gif" width="164" height="15" alt="" /></div><!--round corner up-->
			<div style="border-left:1px solid #bfbfbf; width:157px; padding-left:7px; float:left"><!--Content menu-->
				<div style="width:151px; background-color:#93BD23"><img src="images/spacer.gif" width="1" height="1" alt="" /></div>
					<div class="submenu_section">
						<a href="./" class="submenu_section">Nostros</a>
						<div class="submenu_option">
							<a href="./" class="submenu_option">Conocimientos fjds jfd saf dsaf j fdsfa j5Ã±43j2 jdÃ±sajfÃ± fdjsa jÃ±5435 fdÃ±saf 5Ã±43j fdsÃ±jafj</a>
						</div>
					</div>
				<div style="width:151px; background-color:#93BD23"><img src="images/spacer.gif" width="1" height="1" alt="" /></div>
					<div class="submenu_section">
						<a href="./" class="submenu_section_selected">Sistemas</a>
						<div class="submenu_option">
							<a href="./" class="submenu_option_selected">Conocimientos fjds jfd saf dsaf j fdsfa j5Ã±43j2 jdÃ±sajfÃ± fdjsa jÃ±5435 fdÃ±saf 5Ã±43j fdsÃ±jafj</a>
						</div>
					</div>
				<div style="width:151px; background-color:#93BD23"><img src="images/spacer.gif" width="1" height="1" alt="" /></div>
			</div><!--End Content menu-->
			<div><img src="images/submenu_down.gif" width="164" height="15" alt="" /></div><!--round corner down-->
		<div style="height:106px"></div><!--down space-->
	</div><!--End div_submenu-->
	<div style="float:left; width:1px; background-color:#BFBFBF"><img id="img_line_menu" src="images/spacer.gif" width="1" height="100" alt="" /></div>
	<div style="float:left">
		<div><img src="images/spacer.gif" width="1" height="95" alt="" /></div>
		<a href="javascript:toggle_submenu()"><img src="images/submenu_rowleft.gif" id="menu_row" width="10" height="81" alt="" /></a>
	</div>
	<script language="javascript" type="text/javascript">
		var submenu_show_status = true;
		function toggle_submenu () {
			dv = document.getElementById("div_submenu");
			img = document.getElementById("menu_row");
			if (submenu_show_status) {
				dv.style.display='none';
				submenu_show_status = false;
				img.src = "images/submenu_rowright.gif";
			} else {
				dv.style.display='';
				submenu_show_status = true;
				img.src = "images/submenu_rowleft.gif";
			}
		}
		function update_line_height(){
			img = document.getElementById("img_line_menu");
			dv = document.getElementById("div_submenu");
			xHeight(img, xHeight(dv));
		}
		update_line_height();
	</script>
	<!--End Submenu-->

*/
/*
Recibe un arreglo con un maximo nivel de anidaciÃ³n de 2
el arreglo tie
$arr_option1 = array (
	0 => array(
		"title" => "Nosotros",
		"href" => "javascript:actionFunction()",
		"children" => array(
			0 => array(
				"title" => "Conocimientos",
				"href" => "javascript:actionFunction()"
			),
		)
	)
	
	1 => array (
		"title" => "Sistemas",
		"href" => "javascript:actionFunction()",
		"selected" => true,
		"children" => array(
			0 => array(
				"title" => "Conocimientos",
				"href" => "javascript:actionFunction()"
			),
		)
	)
);

*/
function submenu ($arrOptions) {
	$str_menu = '';
	$str_javascript = '
		<script language="javascript" type="text/javascript">
			var submenu_show_status = true;
			function toggle_submenu () {
				dv = document.getElementById("div_submenu");
				img = document.getElementById("menu_row");
				if (submenu_show_status) {
					dv.style.display="none";
					submenu_show_status = false;
					img.src = "images/submenu_rowright.gif";
				} else {
					dv.style.display="";
					submenu_show_status = true;
					img.src = "images/submenu_rowleft.gif";
				}
			}
			function show_hide_submenu_options(id_div, id_img){
				dv = document.getElementById(id_div);
				img = document.getElementById(id_img);
				if (dv.style.display=="none") {
					dv.style.display = "";
					img.src = "images/minus.gif";
				} else {
					dv.style.display = "none";
					img.src = "images/plus.gif";
				}
			}
			function update_line_height(){
				img = document.getElementById("img_line_menu");
				imgrow = document.getElementById("menu_row");
				dv = document.getElementById("div_submenu");
				
				xHeight(img, xHeight(dv));
				
				imgrow_height = 40;
				line_height = xHeight(img);
				
				xTop(imgrow, (line_height/2)-imgrow_height);
				
			}
			update_line_height();
		</script>';
	
	$menu_separator = '<div class="submenu_separator"><img src="images/spacer.gif" width="1" height="1" alt="" /></div>';
	
	$str_menu = '
			<div style="float:left; width:10px;"><img src="images/spacer.gif" width="10" height="1" alt="" /></div>
			<div class="submenu" id="div_submenu"><!--div_submenu-->
				<div style="height:52px"></div><!--up space-->
				<div><img src="images/submenu_up.gif" width="164" height="15" alt="" /></div><!--round corner up-->
				<div style="border-left:1px solid #bfbfbf; width:157px; padding-left:7px; float:left"><!--Content menu-->';
					
	$str_menu .= $menu_separator;
	
	$arr_sections = array();
	$i=0;
	
	$conta_section = 0;
	$conta_option = 0;
	foreach ($arrOptions as $key=>$value) {
		$class = (!empty($value["selected"])) ? "submenu_section_selected" : "submenu_section";
		$arr_sections[$i] = '<div class="submenu_section" >';
		
		if (!empty($value["children"])) {//Si la seccion tiene submenus
			$arr_sections[$i] .= '<div style="float:left; width:18px; height:18px;" align="center">
									<img vspace="7" onclick="javascript:show_hide_submenu_options(\'options_div_'.$key.'\',\'img_section_'.$key.'\')" id="img_section_'.$key.'" style="cursor:pointer" src="images/plus.gif" width="9" height="9" alt="" />
								  </div>
								  <div style="float:left"><a id="submenu_section_'.$conta_section.'" href="'.$value["href"].'" class="'.$class.'">'.$value["title"].'</a></div>';//Link de seccion
			$arr_sections[$i] .= '<div id="options_div_'.$key.'" style="clear:both; display:none">';
			$conta_option = 0;
			foreach ($value["children"] as $key2 => $value2) {
				$class = (!empty($value2["selected"])) ? "submenu_option_selected" : "submenu_option";
				$arr_sections[$i] .= '<div class="submenu_option"><a id="submenu_option_'.$conta_section.'_'.$conta_option.'" href="'.$value2["href"].'" class="'.$class.'">'.$value2["title"].'</a></div>';//Link de opcion
				$conta_option++;
			}
			$arr_sections[$i] .= '</div>';
		} else {//Si la seccion no tiene submenus
			$arr_sections[$i] .= '<div style="float:left"><img src="images/spacer.gif" width="18" height="1" alt="" /></div>
								  <div style="float:left"><a id="submenu_section_'.$conta_section.'" href="'.$value["href"].'" class="'.$class.'">'.$value["title"].'</a></div>';//Link de seccion
		}
		$arr_sections[$i] .= '</div>';
		$conta_section++;
		$i++;
	}
	
	$str_menu .= implode($menu_separator, $arr_sections);
	
	$str_menu .= $menu_separator;
	
	$str_menu .= '</div><!--End Content menu-->
				<div><img src="images/submenu_down.gif" width="164" height="15" alt="" /></div><!--round corner down-->
			<div style="height:106px"></div><!--down space-->
		</div><!--End div_submenu-->
		<div style="float:left; width:1px; background-color:#BFBFBF"><img id="img_line_menu" src="images/spacer.gif" width="1" height="100" alt="" /></div>
		<div style="float:left">
			<!--<div><img src="images/spacer.gif" width="1" height="95" alt="" /></div>-->
			<img src="images/submenu_rowleft.gif" onclick="javascript:toggle_submenu()" id="menu_row" width="10" height="81" alt="" style="position:relative; cursor:pointer" />
		</div>';
	
	//$str_menu .= '</div>';
	
	return(array("javascript"=>$str_javascript, "menu"=>$str_menu));
}
?>