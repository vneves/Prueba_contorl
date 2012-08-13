
<?php
require_once("config/config.php");
require_once $APP['base_admin_path'].'include/connection.php';
require_once $APP['base_admin_path'].'pages/class/page.php';
require_once $APP['base_path'].'lib/process_page.php';
global $APP;

function process_files_private($pageData,$APP,$Labeldescargas) {
//print_r($pageData);
	if (!empty($pageData['attached_files'])) {//ARCHIVOS ADJUNTOS
				$fileListTmp[] = "<div style='padding-bottom:3px;text-align:center; font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#B2B2B2;'>".$Labeldescargas[$pageData["lang"]]."</div>
				<table class='table_class' cellpadding=\"0\" cellspacing=\"0\">";		
				$fileListTmp[] = "<tr><td style='height: 3px;'></td></tr><tr><td width=\"10\">&nbsp;&nbsp;&nbsp;</td>";
				reset($pageData['attached_files']);
				$cont=0;
				$laststyle="style='padding-right:15px'";
				$fileCount=count($pageData['attached_files']);
				foreach ($pageData['attached_files'] as $id_child) 
				{
					$type = explode(".", $id_child['filename']);
					$type = end($type);				
					switch (strtolower($type)) {
						case "jpg":
						case "gif":
						case "png":
						case "jpeg":
						case "bmp":
						$icon = "img_f.gif";
						break;
						
						case "txt":
						case "doc":
						$icon = "word.gif";
						break;
						
						case "xls":
						$icon = "excel.gif";
						break;
						
						case "pdf":
						$icon = "pdf.gif";
						break;
						
						case "pps":
						case "ppt":
						$icon = "ppt.gif";
						break;
						
						default:
						$icon = "ppt.gif";
						break;
					}
//					print_r($id_child);
					$fileListTmp[] = "
					<td align=\"center\" valign=\"bottom\"><center><a style='background-image:none;color:#999999' href='download.php?codef=".$id_child['id_file']."&codec=".$id_child['id_content']."&codep=".$pageData["id_page"]."' target=\"blank\"><img src=\"imagenes/$icon\" border=\"0\" alt=\"icono\" /><br/><center>".$id_child['title']."</center></a></center></td>
					<td>&nbsp;</td>
					<td width=\"10\">&nbsp;&nbsp;&nbsp;</td>
					";
					if(	$fileCount==5 and count($pageData['attached_files'])!=$fileCount)
					{
						$fileCount=0;
						$fileListTmp[].="</tr><tr>";
					}
				}
				
				
				$fileListTmp[] = "</tr>";
				$fileListTmp[] = "<tr><td style='height: 3px;'></td></tr>
				</table>";
					
				$fileListTmp = join("", $fileListTmp);
			
		
		return $fileListTmp;
	} else {
		return "";
	}
}


?>



