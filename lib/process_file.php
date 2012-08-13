<?php
require_once("config/config.php");
require_once $APP['base_admin_path'].'include/connection.php';
require_once $APP['base_admin_path'].'pages/class/page.php';
require_once $APP['base_path'].'lib/process_page.php';
global $APP;
function process_files($pageData,$APP) {
//print_r($pageData);

	if (!empty($pageData['attached_files'])) {//ARCHIVOS ADJUNTOS
				$fileListTmp[] = '<br/>
				<div style="width:489px;">';		
				
				reset($pageData['attached_files']);
				$cont=0;
				$laststyle="style='padding-right:15px'";
				$fileCount=0;
				foreach ($pageData['attached_files'] as $id_child) 
				{
				$fileCount++;
					$fileListTmp[] = "
					<div style='float:left;padding-bottom:2px;padding-right:13px;'><a href='".$APP['files_resources_url'].$pageData['id_page']."/".$id_child['filename']."' target=\"blank\">".$id_child['filename']."</a></div>
					";
				}
				$fileListTmp[] = "
				<div class='clearThis'></div>
				</div>";		
				
				$fileListTmp = join("", $fileListTmp);				
		return $fileListTmp;
	} else {
		return "";
	}
}?>