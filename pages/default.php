<?php
require_once $APP['base_admin_path']."include/connection.php";
global $cn;
$sql="SELECT * FROM `page` WHERE id_page='$pageData[id_page]'";
$row = $cn->GetAll($sql);
$sql1="SELECT * FROM `content` WHERE id_page=".$row[0]['id_page'];
$title= $cn->GetAll($sql1);

if($row[0]['id_parent']!=3){
     
    include("pages/migadepan.php");
    
    $pageTemp=printPageByPage($row[0]['id_page'], 'es');  
//    echo "<pre>";
//    print_r($pageTemp['attached_files']);
//    echo "</pre>";

    

    ?> 
    <div id="title">
        <p><? echo $pageTemp['title']?></p>
    </div>
    <div id="content_text">
        <?if($pageTemp['template_images']!=null){?>
        <div id="content_text_image" style="width: 240px; position: relative; float: left ">
            <a href="<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][0]['filename']?>" rel="prettyPhoto">
                <img height="165" width="240" src="<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][0]['filename']?>" title="<?=$pageTemp['title']?>" alt="<?=$pageTemp['title']?>"/>
            </a>
        </div>
<!--        <div class="parrafo">-->
            <?} echo $pageTemp['maintext']?>
<!--        </div>-->
    </div> 
    <? if(count($pageTemp['attached_files'])>0){ ?>
    <div id="archivos">
        <ul>
            <?php for($i=0;$i<count($pageTemp['attached_files']);$i++){?>  
            <li style='list-style-image:url(img/<? 
            switch (extension($pageTemp['attached_files'][$i]['filename'])){
                case "pdf": {
                    echo 'pdf.jpeg';
                }break;                
                case "doc" :
                case "docx":  {
                    echo 'word.jpeg';
                }break;
                case "xls" :
                case "xlsx": {
                    echo 'xls.jpeg';
                }break;
                case "txt": {
                    echo 'txt.jpeg';
                }break;
                default:
                {                    
                    echo 'no-extension.jpeg';
                }  
            }
            ?>);'>
                <a href="<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['attached_files'][$i]['filename']?>">
                    <label><? echo $pageTemp['attached_files'][$i]['title']; ?></label>
                </a>
            </li>
                <?}?>
        </ul>
    </div>
    <? }if($pageTemp['introtext']!=null){ ?>
    <div id="enlaces">
        <div id="bullete2" style="width: 11px; height: 10px; margin-top: -7px;">
            <img style="z-index: 10;" src="img/bullete.png" width="11" height="10" alt="thumbs" />
        </div>
        <div id="enlaces_title">
            <p>Enlaces Relacionados:</p>
        </div>
        <? echo $pageTemp['introtext']?>
    </div>
        

<? }

}else{ 
        require_once("pages/productos.php");
    } ?>
<?php 
    function extension($filename){
        return substr(strrchr($filename, '.'), 1);
    }
?>