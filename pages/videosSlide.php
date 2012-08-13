<?php

 $rpta="";
    
 $pageTemp=printPageByPage($APP['Videos'], "es");
    
 $Child=page::listPages($APP['Videos'], 'es');
//					echo "<pre>";
//					print_r($Child);
//					echo "</pre>";
//					die();
                                        
 ?>

    <div id="content_youtube">
        <div id="title_video">
            <p><?=$pageTemp['title']?></p>
        </div>
        <div id="youtube">
            <ul id="mycarousel2" class="jcarousel-skin-tango1">
<?php                
                for($i=0;$i<count($Child);$i++)
                {
                    if($Child[$i]['is_published']==1){
                        $pageTemp=printPageByPage($Child[$i]['id_page'], "es");
?>
                <li>
                    <a href="<? echo $pageTemp['meta_description']?>" rel="prettyPhoto">
                    <?if($pageTemp['template_images']!=null){?>
                        <img src='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][0]['filename']?>'  title="<?=$pageTemp['title']?>" alt="<?=$pageTemp['title']?>" style="z-index:0;" width="224" height="196"  />
                    
                    <?}else{?>
                        <img src='img/no-video.jpeg'  title="<?=$pageTemp['title']?>" alt="no-video" style="z-index:0;" width="224" height="196"  />
                    <?}?>
                    </a>
                </li>       
<?                  }
            
                }
                echo($rpta); 
?>                    
            </ul>
        </div>
    </div>

