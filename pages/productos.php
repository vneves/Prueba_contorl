<?php

require_once $APP['base_admin_path']."include/connection.php";
global $cn;
$sql="SELECT * FROM `page` WHERE id_page='$pageData[id_page]'";
$row = $cn->GetAll($sql);
$sql1="SELECT * FROM `content` WHERE id_page=".$row[0]['id_page'];
$title= $cn->GetAll($sql1);
if($pageData['id_page']==3){
    $Child=page::listPages($APP['Productos'], 'es');
    $Child=printPageByPage($Child[0]['id_page'], "es");

    //echo "<pre>";		print_r($Child);		echo "</pre>";		die();

    $pageTemp=$title[0];
    $pageData=$Child;
    
}
$pageTemp=$pageData;
?>

          		
    <div id="content_brad">

    </div> 
    <div id="title">
        <p><? echo $pageData['title']?></p>
    </div>  
    <div id="content_product">
        <div id="content_left_product">
            <div id="content_menu_product_horizontal">
                <ul class="ul_menu">
                    <li class="nivel1"><a id="car" class="nivel1" onclick=" setColor('car')" style="color:#E6007E;" href="#">Características</a></li>
                    <li class="nivel1"><a id="apl" class="nivel1" onclick=" setColor('apl')" style="color:#FFFFFF;" href="#">Aplicaciones</a></li>
                    <li class="nivel1"><a id="cli" class="nivel1" onclick=" setColor('cli')" style="color:#FFFFFF;" href="#">Clientes</a></li>
                </ul>
            </div>
            <div id="content_product_text">
                <div id="content_product_text_image">
<?php
               $i=0;
//               $Child=page::listPages($APP['Productos'], 'es');
//               $pageTemp=printPageByPage($Child[$i]['id_page'], "es");
               for($c=0;$c<count($pageTemp['template_images']);$c++){
                   if($c==0){
                   ?>                    
                    <a href='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][$c]['filename']?>' rel='prettyPhoto[pp_gal<?=$i?>]'>
                        <img alt="<? echo $pageTemp['title']?>" src="<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][$c]['filename']?>" height="186" width="220" style="z-index:1;"/>
                        <img id="popup" alt="more" src="img/plus.png" height="22" width="22" style="z-index:1;"/>
                    </a>
                    
                <? }else{ ?>                    
                    <a href='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][$c]['filename']?>' rel='prettyPhoto[pp_gal<?=$i?>]'>
                    </a>
                <? }
               } ?>
                    <div id="product_archivo">
                    <ul style="list-style: none;">
                        <?php for($j=0;$j<count($pageTemp['attached_files']);$j++){?>  
                        <li style="margin-top: 24px;">
                            <a style=" text-decoration: none; color: #C4007A;" href="<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['attached_files'][$j]['filename']?>">
                        <? 
//                     if($pageTemp['attached_files'][$j]['filename']!=null)
                        switch (extension_($pageTemp['attached_files'][$j]['filename'])){
                            case "pdf": {
                                echo '<img alt="extension" src="img/pdf.jpeg" height="30" width="30"/>';
                            }break;                
                            case "doc" :
                            case "docx":  {
                                echo '<img alt="extension" src="img/word.jpeg" height="30" width="30"/>';
                            }break;
                            case "xls" :
                            case "xlsx": {
                                echo '<img alt="extension" src="img/xls.jpeg" height="30" width="30"/>';
                            }break;
                            case "txt": {
                                echo '<img alt="extension" src="img/txt.jpeg" height="30" width="30"/>';
                            }break;
                            default:
                            {                    
                                echo '<img alt="extension" src="img/no-extension.jpeg" height="30" width="30"/>';
                            }  
                        }
                        ?>
                                <label><? echo $pageTemp['attached_files'][$j]['title']; ?></label>
                            </a>
                        </li>
                    <?}?>
                    </ul>
                </div>
                </div>
                
                <? $pageTemp_2=page::listPages($pageTemp['id_page'], "es");
//                 echo "<pre>";		print_r($pageTemp['attached_files']);		echo "</pre>";		die();
                  ?>
                <div id="product_text">
                    <? for($a=0;$a<count($pageTemp_2);$a++){
                        if(strcmp($pageTemp_2[$a]['meta_description'],'caracteristicas')==0)
                        {
                            $pageTem=printPageByPage($pageTemp_2[$a]['id_page'], "es"); 
                            ?><div id="car_tex" style="display:block"><?
                            echo $pageTem['maintext'];    
                            ?></div><?                        
                        }else
                            if(strcmp($pageTemp_2[$a]['meta_description'],'aplicasiones')==0) {
                                $pageTem=printPageByPage($pageTemp_2[$a]['id_page'], "es"); 
                                ?><div id="apl_tex" style="display: none;"><?
                                echo $pageTem['maintext'];    
                                ?></div><?                                                                                             
                            }else
                                if(strcmp($pageTemp_2[$a]['meta_description'],'clientes')==0) {                                    
                                    $pageTem=printPageByPage($pageTemp_2[$a]['id_page'], "es"); 
                                    ?><div id="cli_tex" style="display: none; margin-left: 9px; margin-top: 2px;"><?
//                                    echo "<pre>";		print_r($pageTemp);		echo "</pre>";	
                                    for($c=0;$c<count($pageTem['template_images']);$c++){
                                        ?>
                                            <div align="center" style="margin: 5px; width: 150px; float: left;"><a href='<?=$APP['base_url'].'files_resources/'.$pageTem['id_page'].'/'.$pageTem['template_images'][$c]['filename']?>' rel='prettyPhoto[pp_gal_1]'>
                                                <img alt="<? echo $pageTem['title']?>" src="<?=$APP['base_url'].'files_resources/'.$pageTem['id_page'].'/'.$pageTem['template_images'][$c]['filename']?>" height="150" width="150" style=" z-index:1;"/>
                                            </a>
                                            <p  style="width: 100px;"><? echo $pageTem['template_images'][$c]['title']?></p>
                                            </div>
                                <? } 
//                                    echo $pageTem['maintext'];    
                                    ?>
                                     </div><?                                                                            
                                }
                        //echo "<pre>";		print_r($pageTemp_2[$a]);		echo "</pre>";		}//die();
                    }
?>
                </div>
                <div id="button_consultar">
                    <form action="contactenos_5.html&amp;producto=<? echo $pageData['title'];?>">
                        <input type="submit" value="Consultar" style="background-color: #C5C5C5;color: #C4007A; margin-right:11px; float: right;font-size:25px;font-family:'Gothic-Bolt';border-width: 0px; height: 37px; width: 162px;" />
                    </form>
                </div>
            </div>
        </div>
        <div id="content_right_product">
            <div id="content_menu_product_vertical">
                <ul class="ul_menu">
<?              
//               $i=0;
               $Child=page::listPages($APP['Productos'], 'es');
//               echo "<pre>";		print_r($Child);		echo "</pre>";
//               $pageTemp=printPageByPage($Child[$i]['id_page'], "es");
               for($i=0;$i<count($Child);$i++){		
?>
                    <li class="nivel1">
                        <a class="nivel1" style="<?if($pageData['title']==$Child[$i]['title']) echo "color:#E6007E;";?>/*color:#E6007E;*/" href="<? echo $Child[$i]['permalink']; ?>"><? echo $Child[$i]['title']; ?></a>
                    </li>
                <?}?>
                </ul>
            </div>
        </div>
    </div>

<script  type="text/javascript" charset="utf-8">
    function setColor(c){
        if(c=='car'){
             document.getElementById('car').style.color='#E6007E';
             document.getElementById('apl').style.color='#FFFFFF';
             document.getElementById('cli').style.color='#FFFFFF';
             
             document.getElementById('car_tex').style.display='block';
             document.getElementById('apl_tex').style.display='none';
             document.getElementById('cli_tex').style.display='none';
        }        
        if(c=='apl'){
             document.getElementById('car').style.color='#FFFFFF';
             document.getElementById('apl').style.color='#E6007E';
             document.getElementById('cli').style.color='#FFFFFF';
             
             document.getElementById('car_tex').style.display='none';
             document.getElementById('apl_tex').style.display='block';
             document.getElementById('cli_tex').style.display='none';
        }        
        if(c=='cli'){
             document.getElementById('car').style.color='#FFFFFF';
             document.getElementById('apl').style.color='#FFFFFF';
             document.getElementById('cli').style.color='#E6007E';
             
             document.getElementById('car_tex').style.display='none';
             document.getElementById('apl_tex').style.display='none';
             document.getElementById('cli_tex').style.display='block';
        }        
    }
</script>    
<?php 
    function extension_($filename){
        return substr(strrchr($filename, '.'), 1);
    }
?>             

