<?php

 $rpta="";
    
 $pageTemp=printPageByPage($APP['Noticias'], "es");
    
 $Child=page::listPages($APP['Noticias'], 'es');
 ?>
<div id="notice">
    <div id="title_notice">
            <a style=" height: 100%; width: 100%; display: block; text-decoration: none; color: #FFFFFF; font-family: 'Gothic'; font-size: 17px; padding-top: 2px;" href="<?=$pageTemp['permalink']?>"><?=$pageTemp['title']?></a>
    </div>
    <div id="notice_show">
            <ul id="mycarousel3" class="jcarousel-skin-tango2">
<?php                
                for($i=0;$i<count($Child);$i++)
                {
                    if($Child[$i]['is_published']==1){
                        $pageTemp=printPageByPage($Child[$i]['id_page'], "es");
			$fecha=$pageTemp['date_creation'];
?>
                <li>
                    <div style="width:599px; height:auto;">
                    <?if($pageTemp['template_images']!=null){?>
                        <div style="position: absolute;float: left;margin-right: 15px;border:1px #000 solid;width: 111px; height: 83px;">
                            <img src='<?=$APP['base_url'].'files_resources/'.$pageTemp['id_page'].'/'.$pageTemp['template_images'][0]['filename']?>'  title="<?=$pageTemp['title']?>" alt="<?=$pageTemp['title']?>" style="z-index:0;" width="111" height="83"  />
                        </div>
                    <?}else{?>
                        <div style="position: absolute;float: left;margin-right: 15px;border:1px #000 solid;width: 111px; height: 83px;">
                            <img src='img/no-image.jpeg'  title="<?=$pageTemp['title']?>" alt="no-image" style="z-index:0;" width="111" height="83"  />
                        </div>
                    <?}?>
                        <div style="width: 470px;margin-left: 130px;position: absolute;">
                            <div style="width:438px; ">
                                <p style="margin: 0px;font-family:'Gothic';font-size: 15px;"><? echo date("d/m/Y", strtotime($fecha));?></p>
                                <p style="margin: 0px;font-family:'Gothic-Bolt';font-size: 17px;"><?=$pageTemp['title']?></p>
                                <div class="intro">
                                    <?=$pageTemp['meta_description']?>
                                </div>
                            </div>
                            <div class="more">
                                <a  href="<?=$pageTemp['permalink']?>"><img style="z-index:0;" src="img/more.png" width="15" height="15" alt="more" /></a>
                            </div>
                        </div>
                    </div>
                </li>                       
<?                  }
            
                }
                echo($rpta); 
?>                    
            </ul>  
    </div>
    <div id="vertical_line">

    </div>
</div>
